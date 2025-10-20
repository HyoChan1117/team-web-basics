<?php
    session_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mypage</title>
</head>
<body>
    <?php
        $msg = "안녕하세요! 환영합니다!";
        if (!empty($_SESSION['account'])){
            require_once("./user.php");
        }
    ?><a href="logout.php">-logout-</a>
    <h1>MENU</h1>
    <ul>
        <li><a href="salon.php">salon</a></li>
        <li><a href="service.php">service</a></li>
        <li><a href="hair_style.php">hair style</a></li>
        <li><a href="staff.php">staff</a></li>
        <li><a href="booking.php">booking</a></li>
        <li><a href="news.php">news</a></li>
        <li><a href="mypage.php">mypage</a></li>
    </ul>
    <h1>MYPAGE</h1>
    <?php if($_SESSION['role'] == 'client'):?>
        <?php require_once("./client.php"); ?>
    <?php endif;?>
    
</body>
</html>