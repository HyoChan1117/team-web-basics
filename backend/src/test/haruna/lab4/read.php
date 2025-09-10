<?php

// postID 유효성 검사
$postID = isset($_GET['postID']) ? $_GET['postID'] : '';

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

    // 댓글 표시
    $readSql = "SELECT * FROM comment WHERE postID='$postID' ORDER BY created_at DESC";
    $readQuery = $db_conn->query($readSql); 

    // 게시물 출력
    // sql문 작성 (SELECT)
    $sql = "SELECT * FROM board WHERE postID='$postID'";

    // 쿼리 실행
    $result = $db_conn->query($sql);
    $row = $result->fetch_assoc();

    


} catch (Exception $e) {
    // DB 오류 발생
    echo "DB 오류 발생<br>" . $e;
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

            <button onclick="location.href='delete.php?postID=<?= $postID ?>'">삭제</button>

            <hr>

            게시판 목록으로 돌아가시겠습니까? <a href="list.php">돌아가기</a>

            <br><br>

            <p><strong>댓글</strong></p>
            <fieldset>
                <form action="comment.php?postID=<?= $postID ?>" method="post">
                        이름: <input type="text" name="name" required>
                        비밀번호: <input type="password" name="pw" required><br><br>
                        <textarea name=" review" cols="60" rows="5"></textarea><br>
                    <button>제출</button><button type="reset">초기화</button>
            </fieldset>
            </form>
    <br><br>
    <?php if ($readQuery->num_rows > 0):?>
        <?php while ($cmtRow = $readQuery->fetch_assoc()):?>
            <strong><?= $cmtRow['name'] ?></strong>
            ( <?= $cmtRow['created_at'] ?> )
            <br>
            <?= $cmtRow['review'] ?>
            <hr>
            <?php endwhile; ?>
    <?php else:?>
        댓글이 없읍니다
    <?php endif;?>
</body>

</html>