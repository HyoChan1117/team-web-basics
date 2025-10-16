<?php
    session_start();

    # session에 들어가있는 정보 다 삭제하
    $_SESSION = [];

    # 쿠키에 저장 되는 것 도 삭제 하기
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    header("Refresh: 2; URL='login.php'");
    echo "로그아웃 처리중.";
    exit;
?>