<?php
    // login info
    require_once "./welcome.php";

    // get the user permission 
    require_once "./helper.php";

    // menu
    require_once "./menu.php";

    // check the login and role
    if(!user_permission($_SESSION['role'], 'designer')){
        echo "Access denied. Designer only";
        exit;
    }
    
?>