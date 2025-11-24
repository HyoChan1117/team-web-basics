<?php
    // session start
    session_start();

    // unset the session variable
    $_SESSION = [];
    
    // if it's desires to kill the session, and alse delete the session and cookie.
    if(ini_get("session.use.cookies")) {
        $param = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // final destroy session
    session_destroy();

    header("refresh: 2; URL= 'login.php'");
    echo "logout success";
    exit;
?>