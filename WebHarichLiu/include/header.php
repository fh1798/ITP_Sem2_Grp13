<!-- Diese Datei besteht aus dem Header der HTML Datei, welche nicht nur den Titel der Seite festlegt,
 sondern auch den Style, indem sowohl Bootstrap als auch unsere eigene Datei style.css eingebunden werden. -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <title>Blick & Glück</title>
        <link rel="icon" type="image/x-icon" href="res/assets/favicon.ico" />
        <!-- erst Schriftarten, dann Bootstrap einbinden -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- eigenes stylesheet einbinden -->
        <link href="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['DOCUMENT_ROOT'] . '/hotelprojekt-original/mergedProject/res/css/styles.css'); ?>" rel="stylesheet">
    </head>

<!-- einbinden der navbar, sodass sie auf allen Seiten zu sehen ist -->
<?php include 'navbar.php';?>