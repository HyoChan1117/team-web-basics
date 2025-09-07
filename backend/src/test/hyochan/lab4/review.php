<?php

    // postID값 유효성 검사
    $postID = isset($_GET['id']) ? $_GET['id'] : '';

    // 입력값 유효성 검사
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $pw = isset($_POST['pw']) ? $_POST['pw'] : '';
    $review = isset($_POST['review']) ? $_POST['review'] : '';

    // 유효하지 않은 postID값이나 입력값일 경우
    // 잘못된 접근입니다. -> 게시판 목록 리다이렉션
    if (empty($postID) || empty($name) || empty($pw) || empty($review)) {
        header("Refresh: 2; URL='list.php'");
        echo "잘못된 접근입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // 비밀번호 해싱
        $pw_hash = password_hash($pw, PASSWORD_DEFAULT);

        // sql문 작성 (INSERT)
        $sql = "INSERT INTO comment (postID, name, pw, review) VALUES (
               '$postID', '$name', '$pw_hash', '$review')";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 댓글 작성에 성공했을 경우
        // 해당 게시글 페이지 리다이렉션
        header("Location: read.php?id=$postID");

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>