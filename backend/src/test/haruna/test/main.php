<?php
    session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mainpage</title>
</head>
<body></body>
    <h1>mainpage</h1>
    <hr>
    <?php if (isset($_SESSION['user_id'])):?>
            황영합니다!<strong> <?=$_SESSION['name']?></strong>(<?=$_SESSION['account']?>)님✨
    <?php endif; ?>

    <br>
    <a href="booking.php">예약 하기</a>
</body>
</html>