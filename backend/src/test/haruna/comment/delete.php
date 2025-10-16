<?php
    // 글 id를 받기
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';

    // 유호성을 확인
    if (empty($postID)) {
        header("Refresh: 2; URL='read2.php?postID=$postID'");
        echo "잘 못된 접근입니다.";
        exit;
    }

    try {
        // DB 연결
        require_once("./db_connect.php");

        // DELET SQL문실행
        $sql = "DELETE FROM board WHERE postID='$postID'";
        $query = $db_conn->query($sql);

        // list.php로 가기
        header("Refresh: 2; URL='list.php'");
        echo "삭제가 완료 되었습니다. ";
        exit;
        
    // 에러 처리
    } catch (Exception $e) {
        echo "DB오류 발생" . $e;

    }
    $db_conn->close();

?>