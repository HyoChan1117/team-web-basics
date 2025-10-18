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
        $msg = "안녕하세요! 황영합니다!";
        if (!empty($_SESSION['account'])){
            if ($_SESSION['account'] == 'designer') {
                echo $msg.$_SESSION['name']."(".$_SESSION['account'].")"."디자이너님! ";
            }elseif($_SESSION['account'] == 'manager'){
                echo $msg.$_SESSION['name']."(".$_SESSION['account'].")"."매니저님! ";    
            }else{
                echo $msg.$_SESSION['name']."(".$_SESSION['account'].")"."님! ";    
            }
        }
    ?><a href="logout.php">-logout-</a>
    <h1>MENU</h1>
    <ul>
        <li><a href="salon.html">salon</a></li>
        <li><a href="service.html">service</a></li>
        <li><a href="hair_style.html">hair style</a></li>
        <li><a href="staff.html">staff</a></li>
        <li><a href="bookings.html">bookings</a></li>
        <li><a href="news.php">news</a></li>
        <li><a href="mypage.php">mypage</a></li>
    </ul>
    <h1>MYPAGE</h1>
    <br>
    <?php if($_SESSION['role'] == 'clien'):?>
        <fieldset>
            <?php  ?>
        </fieldset>
    <?php endif;?>
    
</body>
</html>