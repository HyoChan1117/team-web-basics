<?php

    // 입력값 유효성 검사
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    // 유효하지 않은 입력값일 경우
    // 잘못된 접근입니다. -> 게시판 목록 페이지 리다이렉션
    if (empty($name) || empty($title) || empty($content)) {
        header("Refresh: 2; URL='list.php'");
        echo "잘못된 접근입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (INSERT)
        $sql = "INSERT INTO board (name, title, content)
                VALUES ('$name', '$title', '$content')";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 제출에 성공했을 경우
        // 게시글 작성이 완료되었습니다! -> 게시판 목록 페이지 리다이렉션
        header("Refresh: 2; URL='list.php'");
        echo "게시글 작성이 완료되었습니다!";
        exit;

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생" . $e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>