<!-- Diese Datei erlaubt es dem Admin, das Passwort eines Benutzers zu verändern. -->

<?php
    include 'fct_session.php';
    include 'header.php';
    require_once '../config/dbaccess.php';

 //sichergehen, dass die session stattfindet   
 if(session_status()==PHP_SESSION_NONE)   {
    session_start();
 }

//prüfen ob der user Admin ist, wenn nicht erfüllt sofort alles beende.
 if(!$_SESSION['role']||$_SESSION['role']!=='admin'){
   echo"<div class='alert alert-danger'> Sie haben keine Berechtigung.</div>";
   include 'footer.php';
   exit();
 }
 if(!isset($_GET['user_id'])||intval($_GET['user_id'])<=0){

    echo"<div class='alert alert-danger'> Benutzer_ID unglütig.</div>";
    include 'footer.php';
    header("Location: admin_user.php");
    exit();
  }

  $user_id=intval($_GET['user_id']);
 

//db verbinden, ausgewälten user aus der db abrufen
$sql="SELECT user_id, username, status, useremail FROM users WHERE user_id = ?";
$stmt=$db_obj->prepare($sql);

if(!$stmt){
    die('<div class="alert alert-danger"> Fehler beim Abrufen der Benutzerdaten: ' .
    htmlspecialchars($db_obj->error). '</div>');
}


$stmt->bind_param("i",$user_id);
$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows== 0){
   echo '<div class="alert alert-danger">Keine Benutzer gefunden. </div>';
   return;
}

$user= $result->fetch_assoc();


if($_SERVER['REQUEST_METHOD']=='POST'){

    $new_password = $_POST['new_password'] ?? '';

    //$new_password hashen
    $hashed_password =password_hash($new_password, PASSWORD_DEFAULT);

    $update_sql= "UPDATE users SET password = ? WHERE user_id = ?";
    $update_stmt =$db_obj->prepare($update_sql);

    if (!$update_stmt) {
        echo '<div class="alert alert-danger"> Datenbankfehler: ' . htmlspecialchars($db_obj->error) . '</div>';
        exit();
    }
    $update_stmt->bind_param("si", $hashed_password, $user_id);

    if($update_stmt->execute()){
        echo '<div class="alert alert-success">Passwort aktualisiert</div>';
    } else{

        echo '<div class="alert alert-danger">Passwort kann nicht aktualisiert werden</div>';
    }

    
    $update_stmt->close();
}
?>

<!-- Formular -->
<div class="container mt-5" style="max-width: 600px;">
   
    <p class="text-center"> <strong><?= htmlspecialchars($user['username']); ?></strong></p>
    <form method="post" action="fct_pw_reset.php?user_id=<?= htmlspecialchars($user['user_id'])?>">
    <div class="mb-3">
            <label for="new_password" class="form-label">Neues Passwort</label>
            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Neues Passwort eingeben" required>
    </div>    
    <button class="btn btn-secondary btn-sm">Passwort aktualisieren</button>
    <a href="admin_user.php" class="btn btn-secondary btn-sm">zurück</a>

    </form>
</div>
<?php include 'footer.php';?>