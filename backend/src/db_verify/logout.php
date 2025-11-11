<?php

    // 세션 시작
    session_start();

    // 세션 변수 해제
    $_SESSION = [];

    // 세션 파괴
    session_destroy();

    // 로그아웃 성공! -> 로그인 페이지 리다이렉션
    header("Refresh: 2; URL='login.php'");
    echo "로그아웃 성공!";
    exit;
?>