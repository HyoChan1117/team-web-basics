<?php
    session_start();
    
    $msg = "안녕하세요! 환영합니다!";
    # role에 따라 환영메시지 다르게 표시
    if (!empty($_SESSION['role'])){
        require_once("./user.php");
    } else {
        header("Refresh: 2; URL='login.php'");
        echo "잘못한 접근";
        exit;
    }
?>
<a href="logout.php">-logout-</a>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mypage</title>
</head>
<body>
        <?= $_SESSION['account']. $_SESSION['user_id']. $_SESSION['user_name']. $_SESSION['role'] ; ?>
    <h1>MENU</h1>
    <ul>
        <li><a href="salon.php">salon</a></li>
        <li><a href="service.php">service</a></li>
        <li><a href="hair_style.php">hair style</a></li>
        <li><a href="staff.php">staff</a></li>
        <li><a href="booking1.php">booking</a></li>
        <li><a href="news.php">news</a></li>
        <li><a href="mypage.php">mypage</a></li>
    </ul>
    <h1>MYPAGE</h1>
    <!-- role에 따라 다른 페이지를 my페이지에 출력 -->
    <?php if($_SESSION['role'] == 'client'):?>
        <?php require_once("./client2.php"); ?>
    <?php elseif ($_SESSION['role'] == 'designer'):?>
        <?php require_once("./designer.php"); ?>
    <?php else:?>
        <?php require_once("./manager.php"); ?>    
    <?php endif;?>
    
</body>
</html>