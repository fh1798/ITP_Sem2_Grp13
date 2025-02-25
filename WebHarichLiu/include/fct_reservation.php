<!-- Diese Datei stellt die Funktionalität für die Reservierungsseiten zur Verfügung. -->

<?php
require_once '../config/dbaccess.php';
include('fct_session.php');

if(!$db_obj){
  die("Es besteht keine Verbindung zur Datenbank.".mysqli_connect_error());
}
$guests = $breakfast = $pets = $parking = $notes = $check_in_date = $check_out_date = '';


  if($_SERVER['REQUEST_METHOD']=='POST'){

    
    $check_in_date = $_POST['check_in_date'] ?? '';
    $check_out_date = $_POST['check_out_date'] ?? '';
    $guests = isset($_POST['guests']) ? (int)$_POST['guests'] : 1;
    $breakfast = $_POST['breakfast'] ?? '';
    $pets = $_POST['pets'] ?? '';
    $parking = $_POST['parking'] ?? '';
    $notes = $_POST['notes'] ?? '';
  
  }

$username=$_SESSION['username'];

//debugging
/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_POST); // Zeigt die empfangenen Daten an
  // Debugging, falls Daten fehlen
  die();
}*/
$error_msg=[];
  //Validierung
  //pflichtfelder check
  if(empty($check_in_date) ||empty($check_out_date)){
    $error_msg[]="Pflichtfelder, bitte ausfüllen.";
  } 

  if($guests<1){
    $error_msg[]="Gastanzahl kann nicht weniger als 1 sein.";
  }
  //datum soll nicht in der vergangenkeit liegen
  $today=date('Y-m-d');
  if(!empty($check_in_date) && !empty($check_out_date)){
  
    
    if($check_in_date<$today || $check_out_date<$today){
      $error_msg[]="Datum liegt in der Vergangenheit!";
    
    }
  
    if($check_out_date<=$check_in_date){
        $error_msg[]="Aufenthalt zu kurz! Check-out Datum muss nach dem Check-in datum sein.";
      }


    if(!empty($error_msg)){
      echo'<div class="alert alert-warning">';
      foreach($error_msg as $error){
        echo"<p>$error</p>";
      }
      
    } 
    echo '</div>';
  
  } 



//funktion verfügbarkeit check und room_id ausgeben
function getAvailabilityRoomId($db_obj, $check_in_date, $check_out_date){
  
  $query = "SELECT room_id
  
  FROM rooms
  WHERE room_id NOT IN(
  
  SELECT room_id
  FROM reservations
  WHERE ? BETWEEN check_in_date AND check_out_date
               OR ? BETWEEN check_in_date AND check_out_date
               OR (check_in_date BETWEEN ? AND ?)
  )             
  ORDER BY room_id ASC 
  

  LIMIT 1";
  

  $stmt = $db_obj->prepare($query);

  if(!$stmt){
    die("Fehler: " .$db_obj->error);
  }

  $stmt->bind_param("ssss", $check_in_date, $check_out_date, $check_in_date, $check_out_date);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
  $stmt->close(); // Statement schließen

  return $data['room_id'] ?? null;//room_id zurückgeben oder null wenn zimmer nicht verfügbar ist
}

//hinzufügen der daten in die reservations tabelle, funktion aufrufen getAvailabilityRoomId($db_obj, $check_in_date, $check_out_date)

$room_id = getAvailabilityRoomId($db_obj, $check_in_date, $check_out_date);
if(!$room_id){
  die('<div class="container"><div class="alert alert-success">Kein verfügbares Zimmer im gewählten Zeitraum.</div></div>');
  

}
 
 $query= "INSERT INTO reservations(room_id, username, check_in_date, check_out_date, guests, breakfast, pets, parking, notes, created_at, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'neu')";

 $stmt=$db_obj->prepare($query);

 if(!$stmt){
     die("Fehler" . $db_obj->error);
 
 }
 $stmt->bind_param("isssissss",$room_id, $username, $check_in_date,$check_out_date,$guests,$breakfast,$pets,$parking,$notes);

if($stmt->execute()){
echo'<div class="container mt-4"><div class="alert alert-success">Ihre Reservierung wurde erfolgreich gespeichert. Sie können den <a href="site_reservation.php"> Status </a> überprüfen.</div></div>';
}else {
echo'<div class="container"><div class="alert alert-warning">Ihre Reservierung wurde nicht gespeichert: ' .$stmt->error.' </div></div>';
}
$stmt->close(); // Statement schließen

  
//wenn es mehre reservierungen von einem kunden gibt, soll die neuste reservierung angezeigt werden und dann die ältere
function listReservations($db_obj,$username){

  $query = "SELECT r.*, rm.room_id, rm.price_per_night
  FROM reservations AS r
  JOIN rooms AS rm ON r.room_id = rm.room_id 
  WHERE r.username = ? 
  ORDER BY r.created_at DESC";

  $stmt=$db_obj->prepare($query);
  if(!$stmt){
    die("Fehler" . $db_obj->error);

}
$stmt->bind_param("s", $username);
$stmt->execute();
$result=$stmt->get_result();
$reservations=$result->fetch_all(MYSQLI_ASSOC);
$stmt->close(); // Statement schließen
return $reservations;
}
?>