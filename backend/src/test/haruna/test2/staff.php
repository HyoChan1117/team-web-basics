<?php

    require_once("./db_conn.php");

    # staff table정보 가져 오기
    $sql = "SELECT d.*, 
            u.user_name AS designer_name
            FROM Designer AS d
            JOIN Users AS u
            ON d.user_id = u.user_id";
    $result = $db_conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
</head>
<body>
    <h1>Staff</h1>
    <hr>
    <table border="2">
        <th>designer</th>
        <th>experience</th>
        <th>good_at</th>
        <th>personality </th>
        <th>message</th>
    <?php while($row = $result->fetch_assoc()): ?>
        
        <tr>
        <td><?= $row['designer_name'] ?></td>
        <td><?= $row['experience'] ?>year</td>
        <td><?= $row['good_at'] ?></td>
        <td><?= $row['personality'] ?></td>
        <td><?= $row['message'] ?></td>
        </tr>
    <?php endwhile; ?>
    </table>
    <a href="mypage.php">--mypage--</a>
</body>
</html>