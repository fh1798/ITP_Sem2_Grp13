<!-- Seite, um als Admin einen anderen Benutzer löschen zu können (nur für inaktive Nutzer möglich) -->

<?php
    include 'fct_session.php';
    include 'header.php';
    require_once '../config/dbaccess.php';

 //sichergehen, dass die session stattfindet   
 if(session_status()==PHP_SESSION_NONE)   {
    session_start();
 }

//prüfen ob der user Admin ist, wenn nicht erfüllt sofort alles beenden.
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

if($user['status']!=='inactive'){
    echo'<div class="alert alert-danger">Nur inaktive benutzer können gelöscht werden!</div>';
    header:('Location: admin_user.php');
}



    $delete_sql="DELETE FROM users WHERE user_id = ?";
    $delete_stmt=$db_obj->prepare($delete_sql);
    $delete_stmt->bind_param("i",  $user_id);

    if($delete_stmt->execute()){
        echo '<div class="alert alert-success">Benutzerdaten erfolgreich gelöscht.</div>';
        header('Refresh: 2; URL=admin_user.php');
    } else{
        echo '<div class="alert alert-danger">Benutzerdaten kann nicht gelöscht.</div>';
    }
    $delete_stmt->close();
    $stmt->close();
    
    include 'footer.php'?>

