<?php
    // Für Sprint 2
    //require_once("config/session.php");
    //require_once("config/dbaccess.php");

    $page = $_GET["page"] ?? "home";

    include("includes/basicElements/header.php");
    include("includes/basicElements/navbar.php");

    switch($page){
        case "home":
            include("includes/sites/home.php");
            break;
        case "faq":
            include("includes/sites/faq.php");
        case "impressum":
            include("includes/sites/impressum.php");
    }

    include("includes/basicElements/footer.php");
?>
