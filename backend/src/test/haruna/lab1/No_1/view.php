<?php
    // DB 가져오기
    require_once("./db_conf.php");
    
    // 글 id를 받기
    $postId = $_GET['id'];

    // 글 가져오기
    $readSql = "SELECT * FROM guestbook WHERE id='$postId'";
    $readQuery = $db_conn->query($readSql);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자세히 보기</title>
</head>
<body>
    <h1>자세히 보기</h1>

    <?php
        if ($readQuery && $readQuery->num_rows > 0) {
            $row = $readQuery->fetch_assoc();
            echo $row['name'];
            echo "<br>";
            echo $row['content'];
            echo "<br>";
            echo $row['created_at'];
        }
    ?>

</body>
</html>