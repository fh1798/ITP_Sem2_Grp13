<!-- Diese Datei besteht nur aus der Funktion für die aktive Session. Sie wird auf allen anderen eingebunden -->

<?php
# wir zeigen alle Fehler im Browser an, da wir eh nur lokal arbeiten,
# und Sicherheit nicht so wichtig ist wie schnelles debuggen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# session starten
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

#  prüfen, ob jemand eingeloggt ist, und wenn ja, den Willkommensbutton in der navbar anzeigen
if (isset($_SESSION['role']) || isset($_SESSION['username'])) {
    $welcomeMessage = isset($_SESSION['username']) ? "Willkommen, " . $_SESSION['username'] . "!" : "Willkommen, Gast!";
    $loggedIn = true;
} if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'anonym';
    header("Location:index.php");
    exit();
}
else {
    # $welcomeMessage = "Sie sind nicht eingeloggt.";
    $welcomeMessage = "Session: check!";
    $loggedIn = false;
}
?>