<?php
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

<div class="container my-5 info-page" style="max-width: 700px;">
  <h2 class="mb-4">✏️ Profil bearbeiten</h2>

  <?php if (!empty($error_msg)): ?>
    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
  <?php endif; ?>

  <?php if (!empty($success_msg)): ?>
    <div class="alert alert-success"><?php echo $success_msg; ?></div>
  <?php endif; ?>

<form method="POST" class="card p-4 shadow">
  <div class="mb-3">
    <label for="email" class="form-label fw-bold">Neue E-Mail-Adresse:</label>
    <input type="email" class="form-control" id="email" name="email"
           value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
  </div>

  <div class="mb-3">
    <label for="passwort" class="form-label fw-bold">Neues Passwort:</label>
    <input type="password" class="form-control" id="passwort" name="passwort">
  </div>

  <div class="mb-3">
    <label for="passwort_bestaetigen" class="form-label fw-bold">Passwort bestätigen:</label>
    <input type="password" class="form-control" id="passwort_bestaetigen" name="passwort_bestaetigen">
  </div>

  <button type="submit" class="btn btn-primary">Änderungen speichern</button>
</form>

</div>
