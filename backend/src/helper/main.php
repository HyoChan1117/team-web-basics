<?php

    // 사용자 정보 불러오기
    require_once "./header.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인 페이지</title>
</head>
<body>
    <?php if ($_SESSION['role'] == 'client'): ?>
        <p>나는 고객입니다.</p>
    <?php endif ?>

    <?php if ($_SESSION['role'] == 'designer'): ?>
        <p>나는 디자이너입니다.</p>
    <?php endif ?>

    <?php if ($_SESSION['role'] == 'manager'): ?>
        <p>나는 관리자입니다.</p>
    <?php endif ?>

    <p>나는 전체 이용자가 모두 볼 수 있는 글입니다.</p>
</body>
</html>