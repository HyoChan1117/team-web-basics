<?php

    # sessionスタート
    session_start();
    
    # news_id를 get로 받는다
    $news_id = isset($_GET['news_id']) ? intval($_GET['news_id']) : '';

    if ($news_id == '') {
            header("Refresh: 2; URL='news.php'");    
            echo "잘못한 접근입니다.";
            exit();
        }

    try{
        # DB 연결
        require_once('./db_conn.php');
        
        # News 테이블의 news_id의 내용을 가져 오기
        $sql = "SELECT * FROM News WHERE news_id='$news_id'";
        $result = $db_conn->query($sql);

    } catch(Throwable $e){
        error_log($e->getMessage());
        echo "서버 오류 발생";
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
<body>
    <h1>News > View</h1>
    <hr>
        <?php while($row = $result->fetch_assoc()): ?>
            <?php
                $day = new DateTime($row['created_at']);
                ?>
            <?= $day->format('Y-m-d')?><br>
            <?= $row['title'] ?><br>
            <?= $row['content'] ?><br>
            <?php if ($row['file'] !== 'NULL'): ?>
            <?= $row['file'] ?><br>
            <?php endif; ?>
        <?php endwhile; ?>

        <?php if($_SESSION['role'] == 'manager'): ?>
            <a href="news_modify.php?news_id=<?= $news_id ?>"><button>modify</button></a>
        <?php endif; ?>
    <br><br>
    <a href="news.php">--back--</a>

</body>
</html>