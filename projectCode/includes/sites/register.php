<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vorname = htmlspecialchars(trim($_POST['vorname']));
    $nachname = htmlspecialchars(trim($_POST['nachname']));
    $geschlecht = htmlspecialchars(trim($_POST['geschlecht']));
    $geburtsdatum = htmlspecialchars(trim($_POST['geburtsdatum']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (!isset($db_obj) || $db_obj->connect_error) {
        echo "Datenbankverbindungsfehler: " . ($db_obj->connect_error ?? "Variable \$db_obj nicht definiert");
        die();
    }

    if (empty($vorname) || empty($nachname) || empty($geschlecht) || empty($geburtsdatum) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_msg = "Alle Felder müssen ausgefüllt werden.";
    } elseif ($password !== $password_confirm) {
        $error_msg = "Die Passwörter stimmen nicht überein.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Ungültige E-Mail-Adresse.";
    } elseif (!in_array($geschlecht, ['Mann', 'Frau', 'Divers'])) {
        $error_msg = "Ungültiges Geschlecht ausgewählt.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Datenbankverbindung überprüfen
        if (!isset($db_obj) || $db_obj->connect_error) {
            $error_msg = "Datenbankverbindungsfehler: " . ($db_obj->connect_error ?? "Keine Verbindung");
        } else {
            // Prüfen ob E-Mail schon existiert
            $sql_check = "SELECT benutzerID FROM benutzer WHERE email = ?";
            $stmt_check = $db_obj->prepare($sql_check);
            if (!$stmt_check) {
                $error_msg = "Vorbereitungsfehler: " . $db_obj->error;
            } else {
                $stmt_check->bind_param("s", $email);
                $stmt_check->execute();
                $stmt_check->store_result();

                if ($stmt_check->num_rows > 0) {
                    $error_msg = "Benutzer existiert bereits, bitte loggen Sie sich ein.";
                } else {
                    // Benutzer neu einfügen
                    $sql_insert = "INSERT INTO benutzer (vorname, nachname, geschlecht, geburtsdatum, passwort, email, role) 
                                VALUES (?, ?, ?, ?, ?, ?, 'Benutzer')";
                    $stmt_insert = $db_obj->prepare($sql_insert);
                    if (!$stmt_insert) {
                        $error_msg = "Vorbereitungsfehler beim Einfügen: " . $db_obj->error;
                    } else {
                        $stmt_insert->bind_param("ssssss", $vorname, $nachname, $geschlecht, $geburtsdatum, $hashed_password, $email);

                        if ($stmt_insert->execute()) {
                            $success_msg = "Ihre Registrierung war erfolgreich. Sie können sich jetzt einloggen.";
                            $_SESSION['vorname'] = $vorname;
                        } else {
                            $error_msg = "Die Registrierung ist fehlgeschlagen: " . $stmt_insert->error;
                        }
                        $stmt_insert->close();
                    }
                }
                $stmt_check->close();
            }
        }
    }
}




?>

<!-- HTML Teil -->
<div class="container-fluid my-5" style="max-width:640px;">
  <h2 class="text-center">Kundenregistrierung</h2>

  <?php if (!empty($error_msg)): ?>
    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
  <?php endif; ?>

  <?php if (!empty($success_msg)): ?>
    <div class="alert alert-success"><?php echo $success_msg; ?></div>
  <?php endif; ?>

  <form class="container border rounded bg-grey border-shadow py-5 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=register">
    <div class="mb-3">
      <label for="vorname" class="form-label">Vorname</label>
      <input type="text" class="form-control" id="vorname" name="vorname" value="<?php echo isset($vorname) ? $vorname : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="nachname" class="form-label">Nachname</label>
      <input type="text" class="form-control" id="nachname" name="nachname" value="<?php echo isset($nachname) ? $nachname : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="geschlecht" class="form-label">Geschlecht</label>
      <select class="form-select" id="geschlecht" name="geschlecht" required>
        <option value="" disabled <?php echo !isset($geschlecht) ? 'selected' : ''; ?>>Bitte wählen</option>
        <option value="Mann" <?php echo isset($geschlecht) && $geschlecht == 'Mann' ? 'selected' : ''; ?>>Mann</option>
        <option value="Frau" <?php echo isset($geschlecht) && $geschlecht == 'Frau' ? 'selected' : ''; ?>>Frau</option>
        <option value="Divers" <?php echo isset($geschlecht) && $geschlecht == 'Divers' ? 'selected' : ''; ?>>Divers</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="geburtsdatum" class="form-label">Geburtsdatum</label>
      <input type="date" class="form-control" id="geburtsdatum" name="geburtsdatum" value="<?php echo isset($geburtsdatum) ? $geburtsdatum : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-Mail</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Passwort</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
      <label for="password_confirm" class="form-label">Passwort bestätigen</label>
      <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
    </div>
    <button type="submit" class="btn btn-primary">Registrieren</button>
  </form>
</div>