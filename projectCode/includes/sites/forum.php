<?php

// Zugriff nur für eingeloggte Nutzer
if (!isset($_SESSION["benutzerID"])) {
    echo '<div class="container mt-5"><div class="alert alert-warning text-center">⚠️ Bitte loggen Sie sich ein, um das Forum nutzen zu können.</div></div>';
    exit();
}

// Beitrag speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['content'])) {
    $content = trim($_POST['content']);
    $benutzerID = $_SESSION['benutzerID'];

    $sql = "INSERT INTO forum (benutzerID, content, created_at) VALUES (?, ?, NOW())";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("is", $benutzerID, $content);
    $stmt->execute();
    $stmt->close();
}

// Beiträge abrufen
$sql = "SELECT forum.content, forum.created_at, benutzer.vorname, benutzer.nachname 
        FROM forum 
        JOIN benutzer ON forum.benutzerID = benutzer.benutzerID 
        ORDER BY forum.created_at DESC";
$result = $db_obj->query($sql);
?>


<div class="container my-5 info-page" style="max-width: 800px;">
  <h2 class="mb-4">💬 Forum</h2>

  <!-- Formular zum Posten -->
  <form method="POST" class="card p-4 shadow-sm mb-5">
    <div class="mb-3">
      <label for="content" class="form-label fw-bold">Neuer Beitrag:</label>
      <textarea name="content" id="content" rows="4" class="form-control" placeholder="Dein Beitrag..." required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Beitrag posten</button>
  </form>

  <!-- Beiträge anzeigen -->
  <div class="card p-4 shadow-sm">
    <h4 class="mb-3">📚 Alle Beiträge</h4>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="mb-4 border-bottom pb-3">
          <p class="mb-1">
            <strong><?php echo htmlspecialchars($row['vorname'] . ' ' . $row['nachname']); ?></strong>
            <span class="text-muted">am <?php echo $row['created_at']; ?></span>
          </p>
          <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">Noch keine Beiträge vorhanden.</p>
    <?php endif; ?>
  </div>
</div>
