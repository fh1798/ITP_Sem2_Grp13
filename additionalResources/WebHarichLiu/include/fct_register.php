<!-- Diese Datei ist verantwortlich für die Funktionalität und das Formular zum registrieren neuer Benutzer. -->

<?php 
# Fehlersetting, wie in session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'fct_session.php'; # einbinden der session

$error_msg = "";
$success_msg = "";
require_once '../config/dbaccess.php';//datenbank in register.php einbinden
if(!$db_obj){
  die("Es besteht keine verbindung zur Datenbank.");
}


// Wenn das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Benutzereingaben validieren
    $anrede = htmlspecialchars(trim($_POST['anrede']));
    $vorname = htmlspecialchars(trim($_POST['vorname']));
    $nachname = htmlspecialchars(trim($_POST['nachname']));
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Einfaches Beispiel: Überprüfen, ob alle Felder ausgefüllt sind
    if (empty($anrede) ||empty($vorname) ||empty($nachname) ||empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        echo "<p class='text-danger'>Alle Felder müssen ausgefüllt werden.</p>";
    }
    // Überprüfen, ob die Passwörter übereinstimmen
    elseif ($password !== $password_confirm) {
        echo "<p class='text-danger'>Die Passwörter stimmen nicht überein.</p>";
    }
    // E-Mail-Validierung
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='text-danger'>Ungültige E-Mail-Adresse.</p>";
    } else {
        //Validierung erfolgreich -> DB-Zugriff Prepared Statements
        // Passwort sicher Hashen
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

       //check gibt es schon einen username oder useremail schon in der db?
        $sql_check = "SELECT user_id from users WHERE username = ? OR useremail = ? ";
        $stmt_check = $db_obj->prepare($sql_check);
        $stmt_check-> bind_param("ss", $username, $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        //wenn daten schon vorliegt
        if($stmt_check->num_rows>0){
          $error_msg="Benuzer existiert, loggen Sie sich bitte ein.";
        } 
        else{//user noch nicht vorhanden, dann insert user into table, user role ist standard 
              $sql_insert = "INSERT INTO users(anrede, vorname, nachname, username, password, useremail, role) VALUES (?, ?, ?, ?, ?, ?, 'user')";
              $stmt_insert = $db_obj->prepare($sql_insert);
              $stmt_insert->bind_param("ssssss", $anrede, $vorname, $nachname, $username, $hashed_password, $email);

            //wenn kundendaten hinzugefügt wurde
           if($stmt_insert->execute()) {
              $success_msg = "Ihre Registrierung war erfolgreich. Sie können sich einloggen";
              $_SESSION['user_id']=$db_obj->insert_id;
              $_SESSION['username']=$username;
              header("Location: ../include/fct_login.php?success=registered");
              exit();
           } else{
            $error_msg="Die Registrierung ist fehlgeschlagen, versuchen Sie es noch mal.";
           }

           $stmt_insert->close();
        }
        $stmt_check->close();
    }   
}
?>




<!-- Sign up/Registrierungsformular -->
<?php include '../include/header.php';?><!-- header (und somit navbar und session) einbinden -->

<div  class="container-fluid my-5" style= "max-width:640px;">
  <h2 class="text-center">Kundenregistrierung</h2>
  <!-- Im Fehlerfall: Registrierung fehlgeschlagen, Fehlermeldung -->
  <?php if(!empty($error_msg)): ?>
    <div class="alert alert-danger"><?php echo $error_msg;?></div>
  <?php endif;?> 

  <?php if(!empty($success_msg)): ?>
    <div class="alert alert-success"><?php echo $success_msg;?></div>
  <?php endif;?>  

<!-- formular -->
  <form class="container border rounded bg-grey border-shadow py-5 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="mb-3">
    <label for="anrede" class="form-label">Anrede</label>
    <select name="anrede" id="anrede" class="florm-select" required>
      <option value="Herr">Herr</option>
      <option value="Frau">Frau</option>
    </select>
    </div>
    <div class="mb-3">
      <label for="vorname" class="form-label">Vorname</label>
      <input type="text" class="form-control" id="vorname" name="vorname" required>  
    </div>
    <div class="mb-3">
      <label for="nachname" class="form-label">Nachname</label>
      <input type="text" class="form-control" id="nachname" name="nachname" required>
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-Mail</label>
      <input type="email" class="form-control" id="email" name="email" required>
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

<?php include '../include/footer.php';?><!-- footer einbinden, Seite beenden -->