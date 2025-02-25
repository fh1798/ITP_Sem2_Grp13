<!-- Diese Datei stellt Funktionalitäten zur Verfügung, welche in site_upload benötigt werden. -->

<?php

/*error_log("Thumbnail wird erstellt...");
$thumbnail = imagecreatetruecolor($thumb_width, $thumb_height);

if (!$thumbnail) {
    error_log("Fehler: imagecreatetruecolor fehlgeschlagen.");
    return false;
}

error_log("Resampling...");
if (!imagecopyresampled($thumbnail, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height)) {
    error_log("Fehler: Resampling fehlgeschlagen.");
    return false;
}

error_log("Speichern des Thumbnails...");
if (!imagejpeg($thumbnail, $thumbnail_path, 90)) {
    error_log("Fehler: imagejpeg fehlgeschlagen für $thumbnail_path");
    return false;
}*/

function handleImageUpload(){
    
    // Überprüfen, ob ein Bild hochgeladen wurde
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && isset($_POST['title'])) {
    
        $upload_dir = __DIR__.'/../uploads/news_images/';  // Ordner, in den die Datei gespeichert werden soll(absolute pfad verwenden) wichtig! 
        $thumbnail_dir =__DIR__. '/../uploads/news_thumbnails/';//absolute pfad verwenden)
        
        // Sicherstellen, dass der Upload-Ordner existiert, andernfalls erstellen
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        if (!is_dir($thumbnail_dir)) {
            mkdir($thumbnail_dir, 0777, true);
        }
    
        $image = $_FILES['image'];
       
        $image_tmp = $image['tmp_name'];
       
        $image_type = mime_content_type($image_tmp); // MIME-Typ prüfen
    
        // 1. Überprüfen, ob das Bild ein JPEG ist
        if ($image_type != 'image/jpeg') {

           //als array auszugeben
            return[
            'success'=> false,
            'message' => 'Nur JPEG-Bilder sind erlaubt.'] ;
        } 
            // 2. Bild speichern im Upload-Ordner und struktur vorgeben, wichitg für db image_path
            $image_path = 'uploads/news_images/' . uniqid('news_', true) . '.jpg'; // Eindeutiger Name für das Bild
            
            //Thumbnail-Pfad nach gleicher Logik,  wichitg für db thumbnail_path
            $thumbnail_path ='uploads/news_thumbnails/' . uniqid('thumb_', true) . '.jpg';
            
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK){
                error_log('Fehler beim Erstellen des Thumbnails für:' . $_FILES['image']['error']);
                    return[
                    
                    'success'=> false,
                    'message' => 'Fehler beim Hochladen: ' . $_FILES['image']['error']
                    ];
                    
            }
            
            /*php funktion move_uploaded_file, __DIR__ ist eine Magic Constant in PHP, die den vollständigen absoluten Pfad des Verzeichnisses zurückgibt, in dem das aktuell ausgeführte Skript liegt.*/
            
            if (!move_uploaded_file($image_tmp, __DIR__ . '/../' . $image_path)) {
                return [
                    'success'=> false,
                    'message' => 'Fehler beim Hochladen des Bilders.'
                ]; 
        
           
        }
        if (createThumbnail(__DIR__ . '/../' . $image_path, __DIR__ . '/../' . $thumbnail_path, 200 ,120)) {

            return[
                
                'success' => true,
                'image_path' => $image_path,
                'thumbnail_path' => $thumbnail_path,
                'message' => 'Der News-Beitrag wurde erfolgreich erstellt!' 

            ];
        } else {

            error_log('Fehler beim Erstellen des Thumbnails für:' .$image_path);
            return [
                'success'=> false,
                'message' => 'Fehler beim Erstellen des Thumbnails.'
            ]; 
        } 
    }
    return [
        'success'=> false,
        'message' => 'Bild ungültig.'
        ];
}
 


// Funktion zum Erstellen eines Thumbnails
function createThumbnail($source_image_path, $thumbnail_path, $thumb_width, $thumb_height) {
    // Sicherstellen, dass die Quelldatei existiert
    if (!file_exists($source_image_path)) {
        error_log("Datei existiert nicht: Fehler beim Laden des Bildes");
        return false; // Datei existiert nicht
    }

    // Originalbild laden
    $source_image = imagecreatefromjpeg($source_image_path);
    if (!$source_image) {

        error_log("Fehler beim Laden des Bildes:$source_image_path");
        return false; // Fehler beim Laden des Bildes
    }

    // Bilddimensionen ermitteln
    list($width, $height) = getimagesize($source_image_path);

    if ($width <= 0 || $height <= 0) {
        error_log("Ungültige Bilddimensionen: $width x $height");
        return false;
    }
    
    // Proportionale Skalierung beibehalten
    $aspect_ratio = $width / $height;
    if ($thumb_width / $thumb_height > $aspect_ratio) {
        //(int)floor verwenden um fehlermeldung wegen genauigkeit umzugehen!
        $new_width =(int) floor($thumb_height * $aspect_ratio);
        $new_height = (int)floor($thumb_height);
    } else {
        $new_height = (int) floor($thumb_width / $aspect_ratio);
        $new_width = (int)floor($thumb_width);
    }

    // Thumbnail erstellen
    $thumbnail = imagecreatetruecolor($thumb_width, $thumb_height);

    // Bild auf das Thumbnail skalieren
    imagecopyresampled($thumbnail, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Thumbnail speichern
    if (!imagejpeg($thumbnail, $thumbnail_path, 90)) {
       
        error_log("Fehler beim Skalieren des Bilders: $source_image_path");
        imagedestroy($source_image);
       
        return false; // Erfolgreich erstellt
    }
    if (imagejpeg($thumbnail, $thumbnail_path, 90)) {
        // Aufräumen
        imagedestroy($source_image);
        imagedestroy($thumbnail);
        return true; // Erfolgreich erstellt
    }

    // Fehler beim Speichern des Thumbnails
    error_log("Fehler beim Speicern des Thumbnails: $thumbnail_path");
    imagedestroy($source_image);
    imagedestroy($thumbnail);
    return false;
   
}
?>