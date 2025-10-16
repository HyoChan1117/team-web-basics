<?php

    // 세션 시작
    session_start();

    // 세션 변수 저장
    $session_name = $_SESSION['name'];
    $session_account = $_SESSION['account'];

    // 역할 세션 변수 저장
    if ($_SESSION['role'] == 'client') {
        $session_role = '고객';
    } elseif ($_SESSION['role'] == 'designer') {
        $session_role = '디자이너';
    } else {
        $session_role = '관리자';
    }

?>

<!DOCTYPE html>
<html lang="ko">
<head>
</head>
<body>
    <?= "<p>환영합니다 $session_name($session_account) $session_role 님! <a href='logout.php'>로그아웃</a></p>" ?>
</body>
</html>