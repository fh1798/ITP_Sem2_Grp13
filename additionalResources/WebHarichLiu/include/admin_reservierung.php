<!-- Diese Seite gibt dem Admin eine Liste aller Reservierungen aus, und erlaubt das verändern von deren Status. -->

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
 

//db verbinden
$sql="SELECT * FROM reservations ORDER BY status DESC";
$stmt=$db_obj->prepare($sql);

if(!$stmt){
    die('<div class="alert alert-danger"> Fehler beim Abrufen der Reservierungen: ' .
    htmlspecialchars($db_obj->error). '</div>');
}

$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows== 0){
   echo '<div class="alert alert-danger">Keine Reservierungen gefunden. </div>';
   return;
}else{
    $reservations = $result->fetch_all(MYSQLI_ASSOC);
}

$stmt->close();
?>


<!-- Ausgabe als Tabelle -->
<div class="container mt-5">
  <h1 class="text-center my-3">Reservierungen</h1>
  
  <?php if (!empty($reservations)): ?>
    <table class="table table-bordered mt-3 p-3">
      <thead class="thead-light">
        <tr>
          <th >#</th>
          <th >Reservierungs-ID</th>
          <th >Zimmer-ID</th>
          <th >Check-in Datum</th>
          <th >Check-out Datum</th>
          <th >Gäste</th>
          <th >Frühstück</th>
          <th >Kinder</th>
          <th >Haustier</th>
          <th >Parkplatz</th>
          <th >Notizen</th>
          <th >Erstellt am</th>
          <th >Status</th>
          <th >bearbeitet am</th>
          <th >bearbeitet von</th>
          <th >Aktionen</th>
        </tr>
      </thead>
      <tbody>
        <!-- syntax foreach ($array as $key => $value) { Aktionen mit $key und $value } -->
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
            <td><?php echo htmlspecialchars($reservation['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['status'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['bearbeitet_am'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($reservation['bearbeitet_von'], ENT_QUOTES, 'UTF-8'); ?></td>

            <!-- status wird per post-methode ermittelt -->
            <td>
                <form method="POST" action="admin_update_reservierung.php">
                    <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">
                    <select name="status" id="status" class="form-select" mb-2>
                        <option value="neu"<?= $reservation['status'] == 'neu' ? 'selected' : '' ?> >Neu</option>
                        <option value="bestätigt"<?= $reservation['status'] == 'bestätigt' ? 'selected' : '' ?> >Bestätigt</option>
                        <option value="storniert"<?= $reservation['status'] == 'storniert' ? 'selected' : '' ?> >Storniert</option>
                    </select>

                    <button class="btn btn-primary btn-sm">Speichern</button>
                </form>
            </td>
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