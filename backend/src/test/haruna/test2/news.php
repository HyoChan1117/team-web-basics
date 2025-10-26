<?php
    session_start();

    try{
        # db 연결
        require_once("./db_conn.php");

        # News 테이블에 데이터를 가져오기
        $sql = "SELECT * FROM News";
        $result = $db_conn->query($sql);

    } catch (Throwable $e) {
        error_log($e->getMessage());
        echo "DB오류". $e->getMessage() ."";
        exit;
    }
    $db_conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
<body>
    <h1>News</h1>
    <select name="serch">
        <option value="serch_title">title</option>
        <option value="serch_content">content</option>
        <input type="text" name="serch_query">
        <button>serch</button>
    </select>
    <hr>

    <?php while($row = $result->fetch_assoc()): ?>
        <a href="news_viwe.php"><?= $row['title'] ?></a>
        <br>
        <?= $row['created_at'] ?>
        <hr>
    <?php endwhile; ?>

    <!-- manerger만 볼 수 있도록 권한  -->
    <?php if($_SESSION['role'] == 'manager'): ?>
        <a href="made_news.php"><button>WRITE</button></a>
    <?php endif; ?>
    <br>
    <a href="mypage.php">--mypage--</a>
    
</body>
</html>