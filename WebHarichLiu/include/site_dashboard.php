<!-- Diese Seite bildet ein Dashboard für eingeloggte Benutzer, mit unterschiedlichen Funktionen,
  je nachdem, ob es sich um einen Standardnutzer oder Admin handelt. -->

<?php
 include 'fct_session.php';       
 include 'header.php';
# einbinden und session starten
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['username'])) {
  die('<div class="alert alert-danger">Fehler: Benutzer nicht eingeloggt.</div>');
}
  $username=$_SESSION['username'];
?>

    <!-- Linkliste als Sidebar links -->    
    <div class="container-fluid">
      <div class="row vh-100">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar pt-5">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="site_dashboard.php">
                 
                  Dashboard 
                </a>
              </li>
              <?php if(isset($_SESSION['role'])&& $_SESSION['role']=='user'):?> 
              <li class="nav-item">
                <a class="nav-link" href="site_rooms.php">
        
                  Zimmerreservierung
                </a>
              </li>
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
              <li class="nav-item">
                <a class="nav-link" href="site_profil.php">
                
                  Profil
                </a>
              </li>
              <?php endif ;?>
              <?php if(isset($_SESSION['role'])&& $_SESSION['role']=='admin'):?> 
              <li class="nav-item">
                <a class="nav-link" href="site_upload.php">
                
                  Blogverwaltung
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin_reservierung.php">
                
                  Reservierungsverwaltung
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin_user.php">
                
                Userverwaltung
                </a>
              </li>
             <?php endif;?>
             <div class="d-flex border-top mt-3 pt-3 ps-3">
              <a href="fct_logout.php" class="btn btn-sm btn-outline-primary w-auto">logout</a>
             </div>
             
            </ul>
           </div>
        </nav>
      </div>
      
    </div>        

<?php include 'footer.php'; ?><!-- footer einbinden, Seite beenden -->