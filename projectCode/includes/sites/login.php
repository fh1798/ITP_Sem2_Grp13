<?php
// Diese Datei ist verantwortlich für die Funktionalität und das Formular zum einloggen auf der Website

// Prüfen, ob die anmeldung erfolgreich war oder fehlgeschlagen ist
if(isset($_GET['error']) && ($_GET['error']=='user_exists')){
  $error_msg = "Benutzer existiert, loggen Sie sich bitte ein.";
}
if(isset($_GET['success']) && ($_GET['success']=='registered')){
  $success_msg = "Registrierung erfolgreich! Sie können jetzt einloggen.";
}

// Wenn das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Benutzereingaben validieren
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    
    // Überprüfen, ob alle Felder ausgefüllt sind
    if (empty($email) || empty($password)) {
        $error_msg = "Alle Felder müssen ausgefüllt werden.";
    } else {
        // DB-Zugriff Prepared Statements
        // Prüfen, ob die E-Mail-Adresse in der Datenbank existiert
        $sql_check = "SELECT benutzerID, vorname, nachname, passwort, role FROM benutzer WHERE email = ?";
        $stmt_check = $db_obj->prepare($sql_check);
        
        if (!$stmt_check) {
            $error_msg = "Datenbankfehler: " . $db_obj->error;
        } else {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();
            
            if ($stmt_check->num_rows == 0) {
                $error_msg = "Es liegen keine Logindaten für diese E-Mail-Adresse vor.";
            } else {
                // Wenn E-Mail existiert
                $stmt_check->bind_result($benutzerID, $vorname, $nachname, $hashed_password_db, $role);
                $stmt_check->fetch();
                
                // Passwort prüfen
                if (password_verify($password, $hashed_password_db)) {
                    // Login erfolgreich - Session-Variablen setzen
                    $_SESSION['benutzerID'] = $benutzerID;
                    $_SESSION['vorname'] = $vorname;
                    $_SESSION['nachname'] = $nachname;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    
                    // Weiterleitung zur Hauptseite
                    header("Location: index.php");
                    exit();
                } else {
                    $error_msg = "E-Mail-Adresse oder Passwort ist falsch. Bitte versuchen Sie es erneut!";
                }
            }
            $stmt_check->close();
        }
    }
}
?>

<!-- Sign in/Loginformular -->
<div class="container-fluid my-5" style="max-width:640px;">
  <h2 class="text-center">Login</h2>  
  
  <!-- Anzeigen Fehlermeldungen oder Erfolg -->
   <?php if(!empty($error_msg)): ?>
    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
   <?php endif; ?>
   <?php if(!empty($success_msg)): ?>
    <div class="alert alert-success"><?php echo $success_msg; ?></div>
   <?php endif; ?>
   
  <!-- Formular -->
  <form class="container border rounded bg-grey border-shadow py-5 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=login">
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">E-Mail-Adresse</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Passwort</label>
                <input type="password" class="form-control" id="password" placeholder="********">
            </div>
            
                <button type="submit" class="btn btn-primary">Einloggen</button>
            
            <div class="mt-3">
              <p>Noch kein Konto? <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=register">Jetzt registrieren</a></p>
            </div>
  </form>
</div>