<!-- Diese Seite gibt dem Admin einen Überblick über alle existierenden User und leitet weiter zur Bearbeitung ebendieser. -->

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
 

//db verbinden + Fehlermeldungen
$sql="SELECT user_id, username, status, useremail FROM users ORDER BY user_id ASC";
$stmt=$db_obj->prepare($sql);

if(!$stmt){
    die('<div class="alert alert-danger"> Fehler beim Abrufen der Reservierungen: ' .
    htmlspecialchars($db_obj->error). '</div>');
}

$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows== 0){
   echo '<div class="alert alert-danger">Keine Benutzer gefunden. </div>';
   return;
}else{
    $user_id = $result->fetch_all(MYSQLI_ASSOC);
}

$stmt->close();

?>

<!-- Darstellung als Tabelle -->
<div class="container-fluid mt-5">
  <h1 class="text-center my-3">Userverwaltung</h1>
  
  <?php if (!empty($user_id)): ?>
    <table class="table table-bordered mt-3 p-3">
      <thead class="thead-light">
        <tr>
          <th >#</th>
          <th >Status</th>
          <th >Benutzer_ID</th>
          <th >Username</th>
          <th >E-Mail</th>
    
          <th >Aktionen</th>
        </tr>
      </thead>
      <tbody>
        <!-- syntax foreach ($array as $key => $value) { Aktionen mit $key und $value } -->
        <?php foreach ($user_id as $index => $user): ?>
          <tr>
            <th scope="row"><?php echo $index + 1; ?></th>
            <td><?php echo htmlspecialchars($user['status'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($user['useremail'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <!-- get method user_id -->
                <a href="update_user.php?user_id=<?php echo htmlspecialchars($user['user_id']); ?>" 
                class="btn btn-primary btn-sm me-2">Bearbeiten</a>
                <?php if($user['status']== 'inactive'):?>
                    <a href="delete_user.php?user_id=<?php echo htmlspecialchars($user['user_id']); ?>" 
                class="btn btn-danger btn-sm">Löschen</a>
                <?php endif ;?>
                </td>
          </tr>
        <?php endforeach; ?>
        
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">Keine Benutzer gefunden.</div>
  <?php endif; ?>
  <a href="site_dashboard.php" class="btn btn-primary mt-5 me-4">Zurück</a>
    
</div>

<?php include 'footer.php'; ?>

