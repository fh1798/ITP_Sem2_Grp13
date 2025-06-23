<?php
require_once(__DIR__ . '/../../config/dbaccess.php');

if (!isset($_SESSION['benutzerID'])) {
    echo "<div class='alert alert-warning text-center'>Bitte zuerst einloggen.</div>";
    exit();
}

$benutzerID = $_SESSION['benutzerID'];

// === Benutzer-E-Mail abrufen ===
$email = '';
$stmt = $db_obj->prepare("SELECT email FROM benutzer WHERE benutzerID = ?");
$stmt->bind_param("i", $benutzerID);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// === Warenkorb abrufen ===
$sql = "
    SELECT a.artikelID, a.name, w.menge, p.preisNetto, s.steuersatz
    FROM warenkorb w
    JOIN artikel a ON w.artikelID = a.artikelID
    JOIN preisliste p ON a.artikelID = p.artikelID
    JOIN steuersatz s ON p.steuersatzId = s.steuersatzID
    WHERE w.benutzerID = ?
";
$stmt = $db_obj->prepare($sql);
$stmt->bind_param("i", $benutzerID);
$stmt->execute();
$result = $stmt->get_result();

$warenkorb = [];
$gesamtpreis = 0;

while ($row = $result->fetch_assoc()) {
    $preisBrutto = $row['preisNetto'] * (1 + $row['steuersatz']);
    $zeilenpreis = $preisBrutto * $row['menge'];
    $gesamtpreis += $zeilenpreis;

    $warenkorb[] = [
        'artikelID' => $row['artikelID'],
        'name' => $row['name'],
        'menge' => $row['menge'],
        'preisBrutto' => $preisBrutto,
        'zeilenpreis' => $zeilenpreis,
    ];
}
$stmt->close();

// === Bestellung absenden ===
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    $lieferadresse = trim($_POST['liefer_strasse'] ?? '') . ' ' .
                 trim($_POST['liefer_hausnummer'] ?? '') . ', ' .
                 trim($_POST['liefer_plz'] ?? '') . ' ' .
                 trim($_POST['liefer_ort'] ?? '');

if (!empty($_POST['liefer_tel'])) {
    $lieferadresse .= ' (Tel: ' . trim($_POST['liefer_tel']) . ')';
}

if (isset($_POST['rechnung_selbe'])) {
    $rechnungsadresse = $lieferadresse;
} else {
    $rechnungsadresse = trim($_POST['rechnung_strasse'] ?? '') . ' ' .
                        trim($_POST['rechnung_hausnummer'] ?? '') . ', ' .
                        trim($_POST['rechnung_plz'] ?? '') . ' ' .
                        trim($_POST['rechnung_ort'] ?? '');
}

if (
    empty($_POST['liefer_strasse']) || empty($_POST['liefer_hausnummer']) ||
    empty($_POST['liefer_plz']) || empty($_POST['liefer_ort']) ||
    (!isset($_POST['rechnung_selbe']) &&
     (empty($_POST['rechnung_strasse']) || empty($_POST['rechnung_hausnummer']) ||
      empty($_POST['rechnung_plz']) || empty($_POST['rechnung_ort']))
    )
) {
        echo "<div class='alert alert-danger'>Bitte alle Adressfelder ausfüllen.</div>";
    } else {
        // Bestellung speichern
        $sql = "INSERT INTO bestellung (benutzerID, gesamtpreis, zahlungsart, bestellt_am, lieferadresse, rechnungsadresse)
                VALUES (?, ?, 'Rechnung', NOW(), ?, ?)";
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param("idss", $benutzerID, $gesamtpreis, $lieferadresse, $rechnungsadresse);
        $stmt->execute();
        $bestellungID = $stmt->insert_id;
        $stmt->close();

        // Positionen speichern
        $sql = "INSERT INTO bestellposition (bestellungID, artikelID, menge, einzelpreis)
                VALUES (?, ?, ?, ?)";
        $stmt = $db_obj->prepare($sql);
        foreach ($warenkorb as $item) {
            $stmt->bind_param("iiid", $bestellungID, $item['artikelID'], $item['menge'], $item['preisBrutto']);
            $stmt->execute();
        }
        $stmt->close();

        // Warenkorb leeren
        $stmt = $db_obj->prepare("DELETE FROM warenkorb WHERE benutzerID = ?");
        $stmt->bind_param("i", $benutzerID);
        $stmt->execute();
        $stmt->close();

        $success = true;
    }
}
?>
<div class="container py-5">
  <h1 class="text-center mb-4">🧾 Checkout</h1>

  <?php if ($success): ?>
    <div class="alert alert-success text-center">
      <h4>🎉 Ihre Bestellung wurde erfolgreich aufgegeben!</h4>
      <p>Die Rechnung wird in Kürze an Ihre E-Mail-Adresse <strong><?php echo htmlspecialchars($email); ?></strong> gesendet.</p>
    </div>
  <?php elseif (empty($warenkorb)): ?>
    <div class="alert alert-info text-center">Ihr Warenkorb ist leer.</div>
  <?php else: ?>
    <h4>🛍 Bestellübersicht</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Artikel</th>
          <th>Menge</th>
          <th>Einzelpreis</th>
          <th>Gesamt</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($warenkorb as $item): ?>
          <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo $item['menge']; ?></td>
            <td><?php echo number_format($item['preisBrutto'], 2); ?> €</td>
            <td><?php echo number_format($item['zeilenpreis'], 2); ?> €</td>
          </tr>
        <?php endforeach; ?>
        <tr class="table-success">
          <td colspan="3" class="text-end"><strong>Gesamt:</strong></td>
          <td><strong><?php echo number_format($gesamtpreis, 2); ?> €</strong></td>
        </tr>
      </tbody>
    </table>

    <h4 class="mt-4">📦 Lieferadresse</h4>
    <form method="POST">
      <div class="mb-3 row">
        <div class="col-md-6 mb-2">
          <input type="text" name="liefer_strasse" class="form-control" placeholder="Straße" required
                 value="<?php echo htmlspecialchars($_POST['liefer_strasse'] ?? ''); ?>">
        </div>
        <div class="col-md-6 mb-2">
          <input type="text" name="liefer_hausnummer" class="form-control" placeholder="Hausnummer" required
                 value="<?php echo htmlspecialchars($_POST['liefer_hausnummer'] ?? ''); ?>">
        </div>
        <div class="col-md-4 mb-2">
          <input type="text" name="liefer_plz" class="form-control" placeholder="PLZ" required
                 value="<?php echo htmlspecialchars($_POST['liefer_plz'] ?? ''); ?>">
        </div>
        <div class="col-md-8 mb-2">
          <input type="text" name="liefer_ort" class="form-control" placeholder="Ort" required
                 value="<?php echo htmlspecialchars($_POST['liefer_ort'] ?? ''); ?>">
        </div>
        <div class="col-12">
          <input type="text" name="liefer_tel" class="form-control" placeholder="Telefonnummer (optional)"
                 value="<?php echo htmlspecialchars($_POST['liefer_tel'] ?? ''); ?>">
        </div>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="rechnung_selbe" id="rechnung_selbe" checked
               onclick="document.getElementById('rechnungsfeld').style.display = this.checked ? 'none' : 'block';">
        <label class="form-check-label" for="rechnung_selbe">
          Rechnungsadresse ist gleich wie Lieferadresse
        </label>
      </div>

      <div id="rechnungsfeld" style="display:none;">
        <h5>📄 Rechnungsadresse</h5>
        <div class="col-md-6 mb-2">
          <input type="text" name="rechnung_strasse" class="form-control" placeholder="Straße"
                 value="<?php echo htmlspecialchars($_POST['rechnung_strasse'] ?? ''); ?>">
        </div>
        <div class="col-md-6 mb-2">
          <input type="text" name="rechnung_hausnummer" class="form-control" placeholder="Hausnummer"
                 value="<?php echo htmlspecialchars($_POST['rechnung_hausnummer'] ?? ''); ?>">
        </div>
        <div class="col-md-4 mb-2">
          <input type="text" name="rechnung_plz" class="form-control" placeholder="PLZ"
                 value="<?php echo htmlspecialchars($_POST['rechnung_plz'] ?? ''); ?>">
        </div>
        <div class="col-md-8 mb-2">
          <input type="text" name="rechnung_ort" class="form-control" placeholder="Ort"
                 value="<?php echo htmlspecialchars($_POST['rechnung_ort'] ?? ''); ?>">
        </div>
      </div>

      <button type="submit" name="submit_order" class="btn btn-success btn-lg mt-3">✅ Bestellung abschließen</button>
    </form>
  <?php endif; ?>
</div>