<?php

    // postID 유효성 검사
    $postID = isset($_GET['id']) ? $_GET['id'] : '';

    // 유효하지 않는 id값일 경우
    // 잘못된 접근입니다. -> 게시판 목록 페이지 리다이렉션
    if (empty($postID)) {
        header("Refresh: 2; URL='list.php'");
        echo "잘못된 접근입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // 게시물 출력
        // sql문 작성 (SELECT)
        $sql = "SELECT * FROM board WHERE postID='$postID'";

        // 쿼리 실행
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        // 댓글 출력
        // sql문 작성 (SELECT)
        $commentSql = "SELECT * FROM comment WHERE postID='$postID' ORDER BY commentID DESC";

        // 쿼리 실행
        $commentResult = $db_conn->query($commentSql);

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 읽기</title>
</head>
<body>
    <!--
    게시판 목록 > 게시물

    작성자: name
    작성일: created_at
    ------------------
    제목: title
    내용: content

    게시판 목록으로 돌아가시겠습니까? 돌아가기

    댓글 작성
    이름, 비밀번호, 댓글 창

    댓글 보기
    -->
    
    <h1>게시판 목록 < 게시물</h1>

    <fieldset>
        <strong>작성자: </strong><?= $row['name'] ?> <br>
        <strong>작성일: </strong><?= $row['created_at'] ?> <br>
        <hr>
        <strong>제목: </strong><?= $row['title'] ?> <br>
        <strong>내용: </strong><?= $row['content'] ?>
    </fieldset>

    <button onclick="location.href='delete.php?id=<?= $postID ?>'">삭제</button>

    <hr>
    
    게시판 목록으로 돌아가시겠습니까? <a href="list.php">돌아가기</a>

    <h3>댓글</h3>
    <form action="review.php?id=<?= $postID ?>" method="post">
        <fieldset>
            이름: <input type="text" name="name" placeholder="이름을 입력하세요.">
            비밀번호: <input type="password" name="pw" placeholder="비밀번호를 입력하세요."><br>
            <br>
            <textarea name="review" rows="5" cols="60" placeholder="댓글을 입력해 주세요."></textarea><br>
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
            while ($commentRow = $commentResult->fetch_assoc()) {
                echo "<strong>$commentRow[name]</strong> ($commentRow[created_at])<br>";
                echo "└ $commentRow[review]";
                echo "<hr>";
            }
        }

    ?>
</body>
</html>