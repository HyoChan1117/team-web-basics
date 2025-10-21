<?php

// 데이터베이스 연결
$hostname = 'db';
$username = 'root';
$password = 'root';
$database = 'test';

$db_conn = new mysqli($hostname, $username, $password, $database);

$designer_id = 3;

// Designer 테이블을 읽어오는데 User에 있는 user_name 가져오기
// sql문 작성
$sql = "SELECT
        u.user_name AS designer_name,
        d.career
        FROM Designer AS d
        JOIN Users AS u
            ON d.designer_id=u.user_id
        WHERE designer_id='$designer_id'";

// 쿼리 실행
$result = $db_conn->query($sql);
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo "<h1>이름: $row[designer_name]</h1>"; ?>
    <?php echo "<h1>경력: $row[career]년</h1>"; ?>
</body>
</html>