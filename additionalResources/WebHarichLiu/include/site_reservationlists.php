<!-- Diese Seite gibt nicht nur wie site_reservation.php die neuste Reservierung eines Users aus,
 sondern eine Tabelle mit allen vergangenen Reservierungen. -->

<?php
include 'fct_session.php';
require_once'../config/dbaccess.php';

include 'header.php';

//falls es noch kein session existiert
if(session_status()== PHP_SESSION_NONE){
  session_start();
}

//wenn der user nicht eingeloggt ist
if(!isset($_SESSION['username'])){
  echo('Bitte loggen Sie sich ein!');
}

//sonst ist der user eingeloggt und kann die vergangenen reservierungen nachsehen
$username = $_SESSION['username'];

$sql="SELECT * FROM reservations WHERE username = ? ORDER BY created_at DESC";
$stmt=$db_obj->prepare($sql);

if(!$stmt){
  die('<div class="alter alter-danger">Fehler beim Abrufen der Reservierungen:' .htmlspecialchars($db_obj->error).'</div>');
}
$stmt->bind_param("s", $username);
$stmt->execute();
$reservations=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>


<!-- Reservierungsliste ausgeben -->
<div class="container mt-5">
  <h1 class="text-center my-3">Ihre Reservierungen</h1>
  
  <?php if (!empty($reservations)): ?>
    <table class="table table-bordered mt-3 p-3">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Reservierungs-ID</th>
          <th scope="col">Zimmer-ID</th>
          <th scope="col">Check-in Datum</th>
          <th scope="col">Check-out Datum</th>
          <th scope="col">Gäste</th>
          <th scope="col">Frühstück</th>
          <th scope="col">Kinder</th>
          <th scope="col">Haustier</th>
          <th scope="col">Parkplatz</th>
          <th scope="col">Notizen</th>
          <th scope="col">Status</th>
          <th scope="col">Erstellt am</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $index => $reservation): ?>
          <tr>
            <th scope="row"><?php echo $index + 1; ?></th>
            <td><?php echo htmlspecialchars($reservation['reservation_id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['room_id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['check_in_date'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['check_out_date'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['guests'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['breakfast'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['children'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['pets'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['parking'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['notes'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['status'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">Keine Reservierungen gefunden.</div>
  <?php endif; ?>
  <a href="site_dashboard.php" class="btn btn-primary mt-5 me-4">Zurück</a>
    
</div>

<?php include 'footer.php'; ?>