<?php
require_once(__DIR__ . '/../../config/dbaccess.php');

// Benutzer muss eingeloggt sein
if (!isset($_SESSION['benutzerID'])) {
    echo "<div class='alert alert-warning text-center'>Bitte zuerst einloggen, um den Warenkorb zu nutzen.</div>";
    exit();
}

$benutzerID = $_SESSION['benutzerID'];

// === POST-Logik ===
// Artikel hinzufügen
if (isset($_POST['addArtikelID'])) {
    $artikelID = intval($_POST['addArtikelID']);
    $menge = intval($_POST['menge']) ?: 1;

    $sql = "INSERT INTO warenkorb (benutzerID, artikelID, menge)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE menge = menge + VALUES(menge)";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("iii", $benutzerID, $artikelID, $menge);
    $stmt->execute();
    $stmt->close();
}

// Artikel entfernen
if (isset($_POST['removeArtikelID'])) {
    $artikelID = intval($_POST['removeArtikelID']);
    $sql = "DELETE FROM warenkorb WHERE benutzerID = ? AND artikelID = ?";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("ii", $benutzerID, $artikelID);
    $stmt->execute();
    $stmt->close();
}

// Menge aktualisieren
if (isset($_POST['updateArtikelID']) && isset($_POST['neueMenge'])) {
    $artikelID = intval($_POST['updateArtikelID']);
    $neueMenge = intval($_POST['neueMenge']);
    $sql = "UPDATE warenkorb SET menge = ? WHERE benutzerID = ? AND artikelID = ?";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("iii", $neueMenge, $benutzerID, $artikelID);
    $stmt->execute();
    $stmt->close();
}

// === Warenkorb anzeigen ===
$sql = "
    SELECT a.artikelID, a.name, a.artikelBildSrc, w.menge, p.preisNetto, s.steuersatz
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

$gesamt = 0;
?>

<div class="container py-5">
  <h1 class="text-center mb-4">🛒 Ihr Warenkorb bei <strong>Perfumia Duftwelt</strong></h1>

  <?php while ($row = $result->fetch_assoc()):
    $preisBrutto = $row['preisNetto'] * (1 + $row['steuersatz']);
    $zeilenpreis = $preisBrutto * $row['menge'];
    $gesamt += $zeilenpreis;
  ?>
  <div class="card mb-3">
    <div class="row g-0 align-items-center">
      <div class="col-md-3">
        <img src="<?php echo htmlspecialchars($row['artikelBildSrc']); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($row['name']); ?>">
      </div>
      <div class="col-md-9">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
          <p class="card-text">Einzelpreis: <?php echo number_format($preisBrutto, 2); ?> €</p>
          <form method="POST" class="d-flex align-items-center gap-2 mb-2">
            <input type="hidden" name="updateArtikelID" value="<?php echo $row['artikelID']; ?>">
            <input type="number" name="neueMenge" value="<?php echo $row['menge']; ?>" min="1" class="form-control form-control-sm" style="width:80px;">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Menge ändern</button>
          </form>
          <form method="POST">
            <input type="hidden" name="removeArtikelID" value="<?php echo $row['artikelID']; ?>">
            <button type="submit" class="btn btn-outline-danger btn-sm">🗑 Entfernen</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php endwhile; ?>

  <div class="text-end mt-4">
    <h4>Gesamtpreis: <strong><?php echo number_format($gesamt, 2); ?> €</strong></h4>
    <button class="btn btn-success btn-lg mt-3">Zur Kasse</button>
  </div>
</div>