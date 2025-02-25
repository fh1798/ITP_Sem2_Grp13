<!-- Diese Datei bringt die Funktionalität zum Einsehen der eigenen Nutzerdaten, bei eingeloggten Usern -->

<?php
include ('fct_session');
include('header.php');
require_once '../config/dbaccess.php';//datenbank in register.php einbinden
if(!$db_obj){
  die("Es besteht keine verbindung zur Datenbank.");
}

$username = $_SESSION['username'] ?? null;

if(!$username){
  die("Bitte,loggen Sie sich ein.");
}

// db
$sql="SELECT user_id, anrede, vorname, nachname, username, useremail AS email, password AS passwort
      FROM users WHERE username = ?";
$stmt=$db_obj->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result=$stmt->get_result(); 

//user in  der db gefunden
if($result->num_rows > 0){
  $kundendaten=$result->fetch_assoc();
} else {die ("Es liegt keine Daten für Sie vor.");}

?>

 <!-- Tabelle mit Daten -->
    <div class="container">
      <h3 class="text-center mt-3 pt-3">Kundendaten</h3>
    </div> 
    <div class="container vh-100">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Kunden-ID </th>
            <th scope="col">Anrede</th>
            <th scope="col">Vorname</th>
            <th scope="col">Nachname</th>
            <th scope="col">Username</th>
            <th scope="col">E-Mail</th>
            
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><?php echo htmlspecialchars($kundendaten['user_id']); ?></th>
            <td><?php echo htmlspecialchars($kundendaten['anrede']); ?></td>
            <td><?php echo htmlspecialchars($kundendaten['vorname']); ?></td>
            <td><?php echo htmlspecialchars($kundendaten['nachname']); ?></td>
            <td><?php echo htmlspecialchars($kundendaten['username']); ?></td>
            <td><?php echo htmlspecialchars($kundendaten['email']); ?></td>
            
          </tr>
        </tbody>
      </table> 
      <div class="container-fluid">
        <a href="site_dashboard.php" class="btn btn-primary px-2">Zurück</a></button>
        <a href="site_profilverwaltung.php" class="btn btn-primary px-2">Daten bearbeiten</a></button>
     
    </div>
  </div>

<?php include('footer.php'); ?>