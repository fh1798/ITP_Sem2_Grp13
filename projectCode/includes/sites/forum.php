<?php
require_once(__DIR__ . '/../../config/dbaccess.php');
require_once(__DIR__ . '/../../config/session.php');

// Zugriff nur für eingeloggte Nutzer
if (!isset($_SESSION['benutzerID'])) {
    header("Location: index.php");
    exit();
}

// Beitrag speichern, wenn Formular gesendet
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

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Forum</title>
</head>
<body>
    <h2>Forum (nur für eingeloggte Benutzer)</h2>

    <form method="POST">
        <textarea name="content" rows="4" cols="50" placeholder="Dein Beitrag..." required></textarea><br>
        <button type="submit">Beitrag posten</button>
    </form>

    <hr>

    <h3>Alle Beiträge:</h3>
    <?php while ($row = $result->fetch_assoc()): ?>
        <p><strong><?php echo htmlspecialchars($row['vorname'] . ' ' . $row['nachname']); ?></strong> schrieb am 
           <?php echo $row['created_at']; ?>:</p>
        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
        <hr>
    <?php endwhile; ?>
</body>
</html>
