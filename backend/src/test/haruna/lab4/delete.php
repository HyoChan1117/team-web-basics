<?php

    // postID값 유효성 검사
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';

    // 유효하지 않은 id값일 경우
    // 잘못된 접근입니다. -> 게시물 목록 리다이렉션
    if (empty($postID)) {
        header("Refresh: 2; URL='list.php'");
        echo "잘못된 접근입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (DELETE)
        $sql = "DELETE FROM board WHERE postID='$postID'";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 삭제 성공했을 경우
        // 삭제 성공! -> 게시판 목록 리다이렉션
        header("Refresh: 2; URL='list.php'");
        echo "삭제 성공!";
        exit;

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>