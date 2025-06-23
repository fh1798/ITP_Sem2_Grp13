<?php
// Prüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['benutzerID'])) {
    header("Location: index.php");
    exit();
}

// Benutzer-ID aus der Session holen
$benutzerID = $_SESSION['benutzerID'];

// Abfrage der Nutzerdaten
$sql = "SELECT vorname, nachname, email, geschlecht, geburtsdatum FROM benutzer WHERE benutzerID = ?";
$stmt = $db_obj->prepare($sql);
$stmt->bind_param("i", $benutzerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<p>Fehler: Benutzerdaten konnten nicht geladen werden.</p>";
    exit();
}

$stmt->close();
?>

<div class="container my-5 info-page" style="max-width: 700px;">
  <h2 class="mb-4">👤 Mein Profil</h2>
  <div class="card shadow">
    <div class="card-body">
      <p><strong>Vorname:</strong> <?php echo htmlspecialchars($user['vorname']); ?></p>
      <p><strong>Nachname:</strong> <?php echo htmlspecialchars($user['nachname']); ?></p>
      <p><strong>E-Mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      <p><strong>Geschlecht:</strong> <?php echo htmlspecialchars($user['geschlecht']); ?></p>
      <p><strong>Geburtsdatum:</strong> <?php echo htmlspecialchars($user['geburtsdatum']); ?></p>
    </div>
  </div>
</div>

<?php
// Bestellungen abrufen
$sql = "SELECT bestellt_am, gesamtpreis, lieferadresse, rechnungsadresse
        FROM bestellung
        WHERE benutzerID = ?
        ORDER BY bestellt_am DESC";

$stmt = $db_obj->prepare($sql);
$stmt->bind_param("i", $benutzerID);
$stmt->execute();
$bestellungen = $stmt->get_result();
?>

<div class="container my-5 info-page" style="max-width: 700px;">
  <h2 class="mb-4">📦 Meine Bestellungen</h2>

  <?php if ($bestellungen->num_rows > 0): ?>
    <?php while ($b = $bestellungen->fetch_assoc()): ?>
      <div class="card shadow mb-4">
        <div class="card-body">
          <p><strong>Bestelldatum:</strong> <?php echo htmlspecialchars($b['bestellt_am']); ?></p>
          <p><strong>Gesamtpreis:</strong> <?php echo number_format($b['gesamtpreis'], 2, ',', '.') . ' €'; ?></p>
          <p><strong>Lieferadresse:</strong><br><?php echo nl2br(htmlspecialchars($b['lieferadresse'])); ?></p>
          <p><strong>Rechnungsadresse:</strong><br><?php echo nl2br(htmlspecialchars($b['rechnungsadresse'])); ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-info">Sie haben bisher keine Bestellungen getätigt.</div>
  <?php endif; ?>

  <?php $stmt->close(); ?>
</div>
