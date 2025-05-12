<?php
require_once 'config/dbaccess.php';
require_once 'basicElements/session.php';

// Nur eingeloggte Benutzer dürfen hierhin
if (!isset($_SESSION['benutzerID'])) {
    header("Location: index.php");
    exit();
}

$benutzerID = $_SESSION['benutzerID'];
$success_msg = '';
$error_msg = '';

// Wenn Formular gesendet wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $neue_email = trim($_POST['email']);
    $neues_passwort = $_POST['passwort'];
    $passwort_bestaetigen = $_POST['passwort_bestaetigen'];

    // Validierung
    if (!filter_var($neue_email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Ungültige E-Mail-Adresse.";
    } elseif (!empty($neues_passwort) && $neues_passwort !== $passwort_bestaetigen) {
        $error_msg = "Die Passwörter stimmen nicht überein.";
    } else {
        // Passwort hashen, falls eingegeben
        if (!empty($neues_passwort)) {
            $gehashtes_passwort = password_hash($neues_passwort, PASSWORD_DEFAULT);
            $sql = "UPDATE benutzer SET email = ?, passwort = ? WHERE benutzerID = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param("ssi", $neue_email, $gehashtes_passwort, $benutzerID);
        } else {
            $sql = "UPDATE benutzer SET email = ? WHERE benutzerID = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param("si", $neue_email, $benutzerID);
        }

        if ($stmt->execute()) {
            $success_msg = "Daten erfolgreich aktualisiert.";
            $_SESSION['email'] = $neue_email;
        } else {
            $error_msg = "Fehler beim Aktualisieren: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Profil bearbeiten</title>
</head>
<body>
    <h2>Profil bearbeiten</h2>

    <?php if (!empty($error_msg)): ?>
        <p style="color:red;"><?php echo $error_msg; ?></p>
    <?php endif; ?>

    <?php if (!empty($success_msg)): ?>
        <p style="color:green;"><?php echo $success_msg; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="email">Neue E-Mail-Adresse:</label><br>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required><br><br>

        <label for="passwort">Neues Passwort (optional):</label><br>
        <input type="password" name="passwort" id="passwort"><br><br>

        <label for="passwort_bestaetigen">Passwort bestätigen:</label><br>
        <input type="password" name="passwort_bestaetigen" id="passwort_bestaetigen"><br><br>

        <button type="submit">Aktualisieren</button>
    </form>
</body>
</html>
