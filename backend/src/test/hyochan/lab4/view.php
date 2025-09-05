<?php

    // id 값 유효성 검사
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    // 유효하지 않는 id 값일 경우
    // 잘못된 접근입니다. -> 게시판 목록 페이지 리다이렉션
    if (empty($id)) {
        header("Refresh: 2; URL='list.php'");
        echo "잘못된 접근입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // 게시물 출력
        // sql문 작성 (SELECT)
        $sql = "SELECT * FROM guestbook where id='$id'";

        // 쿼리 실행
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        // 댓글 출력
        // sql문 작성 (SELECT)
        $commentSql = "SELECT * FROM comment ORDER BY created_at DESC";

        // 쿼리 실행
        $commentResult = $db_conn->query($commentSql);

    } catch (Exception $e) {
        // DB 연결 실패
        echo "DB 오류 발생 <br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 읽기</title>
</head>
<body>
    <!--
    게시물 읽기

    작성자:
    작성일:
    ---------------
    내용:

    댓글
    FORM
    Action: review.php
    Method: post
    입력값: 아이디(account), 비밀번호(pw), 내용(content)
    -->
    <h1>게시물 읽기</h1>

    <fieldset>
        <strong>작성자:</strong> <?= $row['name']; ?><br>
        <strong>작성일:</strong> <?= $row['created_at']; ?>
        <hr>
        <strong>제목:</strong> <?= $row['title']?><br>
        <strong>내용:</strong> <?= $row['msg']; ?>
    </fieldset>
    <br>
    <strong>댓글</strong>
    <form action="review.php?id=<?= $id ?>" method="post">
        <fieldset>
            ID: <input type="text" name="account" required>
            PW: <input type="password" name="pw" required><br><br>
            COMMENT: <br>
            <textarea cols="53" rows="5" name="content" required></textarea><br>
            <button>제출</button>
            <input type="reset" value="초기화">
        </fieldset>
    </form>

    <br>

    <?php

        // 댓글이 없을 경우
        // 댓글이 없습니다.
        if ($commentResult->num_rows <= 0) {
            echo "댓글이 없습니다.";
        } else {   // 댓글이 있을 경우
            // 댓글 출력
            while ($commentRow = $commentResult->fetch_assoc()) {
                echo "<strong>ID: </strong> $commentRow[account] ($commentRow[created_at]) <br>";
                echo "└ $commentRow[content] <br>";
                echo "<form action='review_delete.php?id=$commentRow[postID]' method='post'>";
                echo "<input type='hidden' name='postID' value='$id'>";
                echo "<button>삭제</button>";
                echo "</form>";
                
                echo "<hr>";
            }
        }
    ?>
</body>
</html>