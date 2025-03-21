<!-- Diese Datei ist verantwortlich für die Funktionalität zum ausloggen von der Website -->

<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
# zuerst Fehlermeldungen setzen, danach session und header einbinden
include '../include/fct_session.php';
 


// Logout-Mechanismus
//überprüfen, ob logout paramenter in der url vorhanden ist
if (isset($_GET['logout'])&& $_GET['logout']=='true') {
    session_unset(); // Alle Session-Daten löschen
    session_destroy(); // Session zerstören
    header("Location:../index.php?logout=success"); 
    exit();
}
include '../include/header.php';

?>

<!-- Für das Logout mit modal -->
<!-- trigger wenn es angeklickt wird, werden die optionen ausloggen oder abbrechen ausgelöst -->
<div class="container text-center my-5 min-vh-100">
    <div class="container border border-warning py-5">  
        <p class="text-center">Wollen Sie wirklich ausloggen?</p>
        <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
    </div>
</div>

<div class="modal fade" id="logoutModal"tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <div class="modal-body text-center">
            <p>Sie werden jetzt ausgeloggt.</p>
        </div>
        <div class="modal-footer">
        <!-- ausgeloggt durch checken ob logout paramenter den value=true hat  -->
        <a href="?logout=true" class="btn btn-warning" role="alert">Bestätigen und Logout</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
        </div>
    </div>
  </div>
</div>


<?php include '../include/footer.php';?><!-- footer einbinden, Seite beenden -->