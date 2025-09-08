<?php

    // 글 id를 GET로 받기
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';

    try {
        // DB 연결하기
        require_once("./db_conf.php");

        // SELECT로 글 내용을 가져 오기
        $readSql = "SELECT * FROM guestbook WHERE id='$id'";
        // 쿼리 실행하기
        $readQuery = $db_conn->query($readSql);
        $row = $readQuery->fetch_assoc();

    } catch (Exception $e) {
        echo "DB연결 오류." . $e;
        exit;
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자세히 보기</title>
</head>
<body>
    <h1>방명록 목록 > 자세히 보기</h1>
    
    <!-- 글 내용을 표시 -->
    <?php
      


            echo "이름: ". $row['name'];

   
    ?>
    

</body>
</html>