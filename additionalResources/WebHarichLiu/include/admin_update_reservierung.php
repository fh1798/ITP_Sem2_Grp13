<!-- Diese Datei erlaubt es dem Admin, den Status einer Reservierung zu verändern. -->
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


 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservation_id'], $_POST['status'])) {
//definiere $reservation_id und $status

    $reservation_id = intval($_POST['reservation_id']);//int
    $status = $_POST['status'];

    // Gültige Statuswerte definieren
    $valid_status = ['neu', 'bestätigt', 'storniert'];

    //wenn $status nicht in array $valid_status?
    if (!in_array($status, $valid_status, true)) {
        echo '<div class="alert alert-warning">Ungültiger Statuswert übergeben!</div>';
        exit();
    }}

//db verbinden
$sql="UPDATE reservations SET status = ? WHERE reservation_id = ?";
$stmt=$db_obj->prepare($sql);

if(!$stmt){
    die('<div class="alert alert-danger"> Fehler beim Abrufen der Reservierungen: ' .
    htmlspecialchars($db_obj->error). '</div>');
}
$stmt->bind_param("si", $status,$reservation_id);

if($stmt->execute()){
    echo '<div class="alert alert-success">Status erfolgreich gespeichert. </div>';
  
} else{
    echo '<div class="alert alert-danger">Status wurde nicht gespeichert. </div>';
}


$stmt->close();
?>

<!-- Ausgabe der Bestätigung, dass die Reservierung gültig verändert wurde. -->
<form class="container-fluid" action="admin_reservierung.php" method="POST">
    <button class="btn btn-primary btn-sm">zurück</button>

</form>

<?php include 'footer.php'; ?>