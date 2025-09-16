<?php
// 해당 게시글의 id글 GET로 받는다
$postID = isset($_GET['postID']) ? $_GET['postID'] : '';

if (empty($postID)) {
    header("Refresh: 2; list.php");
    echo "잘 못한 접근 입니다.";
    exit;
}

try {
    // DB연결 하기
    require_once("./db_connect.php");

    // board sql문 작성
    $readSql = "SELECT * FROM board WHERE postID='$postID'";
    // 쿼리 실행
    $readQuery = $db_conn->query($readSql);
    $row = $readQuery->fetch_array();

    // comment sql문작성
    $cmtSql = "SELECT * FROM comment WHERE postID='$postID' ORDER BY created_at DESC";
    $cmtQuery = $db_conn->query($cmtSql);
} catch (Exception $e) {
    echo "DB오류" . $e;
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
            <a href="delet.php?postID=<?= $postID ?>"><button>삭제</button></a>
            <br><br>
            <a href="list.php">돌아가기</a>
            <br>


            <!-- 댓글 기능 추가 -->
            <p><strong>댓글</strong></p>
            <fieldset>
                <br>
                <form action="review2.php?postID=<?= $postID ?>" method="post">
                    이름: <input type="text" name="name">
                    비밀번호: <input type="password" name="pw">
                    <br><br>
                    <textarea name="review" cols="60" rows="5"></textarea>
                    <br>
                    <button>확인</button><button type="reset">초기화</button>
                </form>
                <br>
            </fieldset>

            <br>
            <?php if ($cmtQuery->num_rows > 0): ?>
                <?php while ($cmtRow = $cmtQuery->fetch_assoc()) : ?>
                    <strong><?= $cmtRow['name'] ?></strong> (<?= $cmtRow['created_at'] ?>)
                    <br><?= $cmtRow['review'] ?>
                    <hr><br>
                <?php endwhile; ?>
            <?php else: ?>
                댓글이 없습니다.
            <? endif; ?>


</body>

</html>