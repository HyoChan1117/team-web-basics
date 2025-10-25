<?php

    # DB연결
    require_once("./db_conn.php");

    # Service 정보 가져오기
    $sql = "SELECT * FROM Service";
    $result = $db_conn->query(($sql));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service</title>
</head>
<body>
    <h1>Service</h1>
    <?php while($row = $result->fetch_assoc()): ?>
        <?= $row['service_name'] ?>
        ₩<?= $row['price'] ?>
        <br>
    <?php endwhile; ?>
    <a href="mypage.php">-mypage-</a>
</body>
</html>