<?php

    // 세션 시작
    session_start();

    // 세션 변수 해제
    $_SESSION = [];

    // 세션 파괴
    session_destroy();

    // 페이지 리다이렉션 함수 불러오기
    require_once "./redirection.php";

    // 로그아웃 성공! 로그인 페이지로 돌아갑니다. -> 로그인 페이지 리다이렉션
    redirection("login.php", "로그아웃 성공! 로그인 페이지로 돌아갑니다.");

?>