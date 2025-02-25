<!-- Diese Datei ist verantwortlich für die Funktionalität und das Formular zum einloggen auf der Website -->

<?php
# Fehlersetting, wie in session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'fct_session.php'; # session einbinden

$error_msg = "";
$success_msg = "";
require_once '../config/dbaccess.php';//datenbank in register.php einbinden
//prüfen ob db verbindung gibt
if(!$db_obj){
  die("Es besteht keine Verbindung zur Datenbank.");
}
//prüfen, ob die anmeldung erfolgreich war oder fehlgeschlagen ist
if(isset($_GET['error'])&&($_GET['error']=='user_exists')){
  $error_msg="Benuzer existiert, loggen Sie sich bitte erneut ein.";
}
if(isset($_GET['success'])&&($_GET['success']=='registered')){
  $success_msg="Registrierung erfolgreich! Sie können jetzt einloggen.";
}


// Wenn das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Benutzereingaben validieren
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    // Einfaches Beispiel: Überprüfen, ob alle Felder ausgefüllt sind
    if (empty($username) || empty($password)) {
        echo "<p class='text-danger'>Alle Felder müssen ausgefüllt werden.</p>";
    }
  
      else {
        //DB-Zugriff Prepared Statements

       //check gibt es den username schon in der db?
        $sql_check = "SELECT user_id, password, role, status from users WHERE username = ?";
        $stmt_check = $db_obj->prepare($sql_check);
        $stmt_check-> bind_param("s", $username);
        $stmt_check->execute();
        $stmt_check->store_result();
        if($stmt_check->num_rows==0){
          $error_msg ="Es liegen keine Logindaten für Sie vor.";
        }
        //wenn username schon existiert
        if($stmt_check->num_rows>0){
          $stmt_check->bind_result($user_id, $hashed_password_db, $role, $status);
          $stmt_check->fetch();
          if($status=='inactive'){
            $error_msg ="Ihr Konto ist inaktiv, sie können nicht einloggen.";
          }
          //passwort prüfen
            elseif(password_verify($password, $hashed_password_db)){  

            $_SESSION['username'] = $username;//username speichern in session
            $_SESSION['user_id']= $user_id;
            $_SESSION['role'] = $role;
            header("Location:../index.php");
            exit();
          }else{
            $error_msg = "Username oder Passwort war falsch. Versuchen Sie es noch mal!";
          }
  
        } 
      }
        $stmt_check->close();
    }
?>



<!-- Sign in/Loginformular -->
<?php include '../include/header.php';?><!-- header (und somit navbar und session) einbinden -->

<div class="container-fluid vh-100 my-5" >
  <h2 class="text-center">Login</h2>  
  <!-- anzeigen fehlermeldungen oder erfolg -->
   <?php if(!empty($error_msg)): ?>
    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
   <?php endif; ?>
   <?php if(!empty($success_msg)): ?>
    <div class="alert alert-success"><?php echo $success_msg; ?></div>
   <?php endif; ?>

  <!-- Formular -->
  <form class="container border rounded bg-grey border-shadow py-5 my-5" style= "max-width:640px;" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Passwort</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div> 

<?php include '../include/footer.php';?><!-- footer einbinden, Seite beenden -->