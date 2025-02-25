<!-- Diese Seite liefert ein Upload-Formular für Admins, um neue Blogbeiträge zu erstellen -->

<?php 
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
# klassisches einbinden, diesmal mit fct_upload.php
include 'fct_session.php';
require_once '../config/dbaccess.php';
include 'fct_upload.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_FILES['image']) && isset($_POST['title'])&& isset($_POST['text'])){

    //real_escape_string schützt die Datenbank vor SQL-Injection
    $title = $db_obj->real_escape_string($_POST['title']);
    $content = $db_obj->real_escape_string($_POST['text']);
    $status = 'Entwurf';
    $image_path = null;
    $thumbnail_path = null;

    //funktion von fct_upload.php
    $upload_result = handleImageUpload();

    if($upload_result['success']){
        $image_path = $upload_result['image_path'];
        $thumbnail_path = $upload_result['thumbnail_path'];

        //prepared statement fuer die sql-abfrage
        $stmt=$db_obj->prepare("INSERT INTO news (title, content, image_path, thumbnail_path, status, created_at) 
        VALUES(?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss",$title, $content, $image_path, $thumbnail_path, $status);

    if($stmt->execute()){
        $upload_message= '<p class="text-success">News-beitrag erstellt.</p>';
    } else{
        $upload_message= '<p class="text-danger">News-beitrag kann nicht erstellt werden. Fehler' . $upload_result['message'] . '</p>';
    }
    $stmt->close();

    }
    else{
        $upload_message= '<p class="text-danger">Fehler beim hochaden: ' . $upload_result['message'] . '</p>';
    }
}
?>

<!-- Formular -->
<div class="container mt-5">
    <h2 class="text-center">News-Beitrag Erstellen</h2>

    <?php 
    // Hier eine Erfolgs- oder Fehlermeldung ausgeben
    if (isset($upload_message)) {
        echo $upload_message;
    } else{
        $upload_message='';
    }    
    ?>

    <!-- Formular für den Bildupload -->
    <div class="container" style="max-width:60%;">
        <form action="site_upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Titel des Beitrags</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Bild hochladen (nur JPEG)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg" required>
            </div>
            <div class="mb-3">
                <label for="text">Artikeltext:</label>
                <textarea class="form-control" id="text" name="text" rows="10" placeholder="Schreib hier den Artikeltext..." required></textarea>
            </div>
            <button type="button" class="btn btn-primary">Speichern</button>
            <button type="submit" class="btn btn-primary">Beitrag erstellen</button>
        </form>
        
    </div>
</div>

<?php include 'footer.php'; ?>