<!-- Dies hätte eine Ausgabe der einzelnen Zimmer mit Fotos und Verfügbarkeit werden sollen,
 jede Website braucht schließlich noch Verbesserungspotential, nicht wahr? -->

<?php


include 'fct_session.php';
include 'header.php';
require_once '../config/dbaccess.php' ;
$sql="SELECT *FROM rooms WHERE available = 1 ";


?>