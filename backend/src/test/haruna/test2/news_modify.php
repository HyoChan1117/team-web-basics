<?php
    # news_id의 기사를 가져옴
    $news_id = isset($_GET['news_id']) ? intval($_GET['news_id']) : '';

    try {
        # DB 연결
        require_once('./db_conn.php');

        $sql = "SELECT * FROM News WHERE news_id='$news_id'";
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

    } catch (Throwable $e) {
        error_log($e->getMessage());
        echo "서버 오류 발생". $e->getMessage();
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
    <h1>News > modify</h1>
    <hr>
    <fieldset>
        <form action="news_modify_process.php?news_id=<?= $row['news_id'] ?>" method="post">
        title<br>
        <input type="text" name="title" value="<?=$row['title']?>" required>
        <br>
        content<br>
        <textarea name="content" cols="60" rows="10" required><?= $row['content'] ?></textarea>
        <br>
        file<br>
        <input type="file" name="file" value="<?=$row['file']?>">
        <br><br>
        <button>submit</button>
        </form>
    </fieldset>
     <a href="news_viwe.php?news_id=<?=$news_id?>">--back--</a>
</body>
</html>