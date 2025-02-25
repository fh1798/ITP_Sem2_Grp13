<!-- Diese Datei gibt dem Admin die Möglichkeit, Benutzername und Email eines Users zu bearbeiten. -->

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

//wenn formular gesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $useremail = $_POST['useremail'] ?? '';
    $status = $_POST['status'] ?? '';
    if(!in_array($status,['active','inactive'], true)){
        echo '<div class="alert alert-danger">Ungültiger Status.</div>';
    }
    $update_sql="UPDATE users SET useremail = ?, status = ? WHERE user_id = ?";
    $update_stmt=$db_obj->prepare($update_sql);
    $update_stmt->bind_param("ssi", $useremail, $status, $user_id);

    if($update_stmt->execute()){
        echo '<div class="alert alert-success">Benutzerdaten erfolgreich aktualisiert.</div>';
        header('Refresh: 2; URL=admin_user.php');
    } else{
        echo '<div class="alert alert-danger">Benutzerdaten kann nicht aktualisiert.</div>';
    }
    $update_stmt->close();
}
$stmt->close();
?>

<!-- Formular -->
<div class="container-fluid mt-5">
  <h1 class="text-center my-3">Bearbeiten</h1>
<form method="post" action="update_user.php?user_id=<?= htmlspecialchars($user['user_id']); ?>">
    <input type="hidden" name="user_id" value="<?=htmlspecialchars($user['user_id']);?>">

    <div class="mb-3">
        <label class="form-label">Benutzername</label>
        <input type="text" class="form-control" name="username" value="<?=htmlspecialchars($user['username']);?>">
    </div>
    <div class="mb-3" >
        <label class="form-label">E-Mail</label>
        <input type="text" class="form-control" name="useremail" value="<?=htmlspecialchars($user['useremail']);?>">
    </div>
    <div class="mb-3">
    <label class="form-label d-block" value="<?=htmlspecialchars($user['status']);?>">Status</label>
            <div class="form-check form-check-inline">
                <input type="radio" id="active" name="status" value="active" 
                       class="form-check-input" <?= $user['status'] === 'active' ? 'checked' : ''; ?>>
                <label for="active" class="form-check-label">Aktiv</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="active" name="status" value="inactive" 
                       class="form-check-input" <?= $user['status'] === 'inactive' ? 'checked' : ''; ?>>
                <label for="active" class="form-check-label">Inaktiv</label>
            </div> 

    </div>
    <div class="mb-3">
       <a href="fct_pw_reset.php?user_id=<?=htmlspecialchars($user['user_id']);?>" class="btn btn-secondary btn-sm">Passwort zurücksetzen</a>
       <button type="submit" class="btn btn-primary btn-sm">Speichern</button>

    </div>
</form>
  
  <a href="site_dashboard.php" class="btn btn-primary mt-5 me-4">Zurück</a>
    
</div>

<?php include 'footer.php'; ?>

