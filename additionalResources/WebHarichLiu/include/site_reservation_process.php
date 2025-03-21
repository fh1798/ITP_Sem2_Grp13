<!-- Diese Seite gibt aus, ob bzw. dass unsere Reservierung erfolgreich war. -->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
# klassisches Fehlermeldung setzen und alles notwendige einbinden
include('fct_session.php');
include('header.php');
include('fct_reservation.php');
require_once('../config/dbaccess.php');

if(!$db_obj){
    die("Es besteht keine verbindung zur Datenbank.".mysqli_connect_error());
  }
  
$username =$_SESSION['username'];

//debugging
/*echo '<pre>';
var_dump([
    'room_id' => $room_id,
    'username' => $username,
    'check_in_date' => $check_in_date,
    'check_out_date' => $check_out_date,
    'guests' => $guests,
    'breakfast' => $breakfast,
    'pets' => $pets,
    'parking' => $parking,
    'notes' => $notes
]);
echo '</pre>';*/
 ?>



<!-- reservierung ausgeben -->
<div class="container mt-5">
  <ul class="nav flex-column">
    <?php if(isset($_SESSION['role'])&& $_SESSION['role']=='user'):?> 
  
    <li class="nav-item">
      <a class="nav-link" href="site_reservation.php">

        Reservierungsdetails
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="site_reservationlists.php">
        
        Vergangene Reservierungen
      </a>
    </li>
  </ul> 
 <?php endif;?>            
</div>


<?php include 'footer.php';?>