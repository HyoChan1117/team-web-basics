<?php

    // 입력값 유효성 검사
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $msg = isset($_POST['msg']) ? $_POST['msg'] : '';

    // 유효하지 않는 입력값일 경우
    // 유효하지 않는 값입니다. -> form.html 리다이렉션
    if (empty($name) || empty($title) || empty($msg)) {
        header("Refresh: 2; URL='form.html'");
        echo "유효하지 않는 값입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (INSERT)
        $sql = "INSERT INTO guestbook (name, title, msg) VALUES ('$name', '$title', '$msg')";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 제출 성공 시
        // 제출 성공! -> list.php 리다이렉션
        header("Refresh: 2; URL='list.php'");
        echo "제출 성공!";

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>