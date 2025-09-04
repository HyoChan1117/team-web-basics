<?php

    // 입력값 유효성 검사
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $account = isset($_POST['account']) ? $_POST['account'] : '';
    $pw = isset($_POST['pw']) ? $_POST['pw'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    // 유효하지 않는 입력값일 경우,
    // 잘못된 접근입니다. -> 게시물 읽기 페이지 리다이렉션
    if (empty($id) || empty($account) || empty($pw) || empty($content)) {
        header("Refresh: 2; URL='view.php?id=$id'");
        echo "잘못된 접근입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (INSERT)
        $sql = "INSERT INTO comment (account, pw, content) VALUES ('$account', '$pw', '$content')";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 입력에 성공했을 경우
        // 게시물 읽기 페이지 리다이렉션
        header("Location: view.php?id=$id");

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생 <br>".$e;
    }

    // 데이터베이스 종료
    $db_conn->close();
?>