<?php
    // 해당 게시글의 id글 GET로 받는다
    $postID = isset($_GET['id']) ? $_GET['id'] : '';

    if (empty($postID)) {
        header("Refresh: 2; list.php");
        echo "잘 못한 접근 입니다.";
        exit;
    }

    try{
        // DB연결 하기
        require_once("./db_connect.php");

        // sql문 작성
        $readSql = "SELECT * FROM board WHERE postID='$postID'";
        // 쿼리 실행
        $readQuery = $db_conn->query($readSql);
        $row = $readQuery->fetch_array();

    } catch (Exception $e) {
        echo "DB오류". $e;
    }

    $db_conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <h1>게시판 목록 < 게시물</h1>    

        <fieldset>
            <strong>작성자:</strong><?= $row['name'] ?><br>
            <strong>작성일:</strong><?= $row['created_at'] ?><br>
            <hr>
            <strong>제목:</strong><?= $row['title'] ?><br>
            <strong>내용:</strong><?= $row['content'] ?><br>
        </fieldset>
        <a href="delet.php"><button>삭제</button></a>
        <br>
        <hr>

</body>
</html>