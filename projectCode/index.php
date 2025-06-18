<?php
    // Für Sprint 2
    require_once("config/session.php");
    require_once("config/dbaccess.php");

    $page = $_GET["page"] ?? "home";

    include("includes/basicElements/header.php");
    include("includes/basicElements/navbar.php");
    //include("includes/sites/chatbot.html"); Feature canceled/on pause

    if (isset($_GET['page']) && $_GET['page'] === 'logout') {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?page=home");
        exit();
    }
    

    switch($page){
        case "home":
            include("includes/sites/home.php");
            break;
        case "faq":
            include("includes/sites/faq.php");
            break;
        case "impressum":
            include("includes/sites/impressum.php");
            break;
        case "forum":
            include("includes/sites/forum.php");
            break;
        case "nutzerübersicht":
            include("includes/sites/nutzerdatenübersicht.php");
            break;
        case "nutzerbearbeitung":
            include("includes/sites/nutzerdatenbearbeiten.php");
            break;
        case "artikelübersicht":
            include("includes/sites/artikelübersicht.php");
            break;
        case "artikeldetailansicht":
            include("includes/sites/artikeldetailansicht.php");
            break;
        case "register":
            include("includes/sites/register.php");
            break;
        case "login":
            include("includes/sites/login.php");
            break;
        case "chatroom":
            include("includes/sites/chatroom.php");
            break;
        case "warenkorb":
            include("includes/sites/warenkorb.php");
            break;
        case "nutzerdaten":
            include("includes/sites/nutzerdatenübersicht.php");
            break;
        default:
            include("includes/sites/default.php");
            break;
    }
    include("includes/basicElements/footer.php");
?>
