<?php

    // 입력값 check
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $msg = isset($_POST['msg']) ? $_POST['msg'] : '';

    // 예외 처리 - 값이 제대로 넘어오지 않았을 때
    if (empty($name) || empty($msg)) {
        header("Refresh: 2; URL='form.html'");
        echo "유효하지 않는 값입니다.";
        exit;
    }

    try {
        // 데이터베이스 연결
        $hostname = 'db';
        $username = 'root';
        $password = 'root';
        $database = 'bar';

        $db_conn = new mysqli($hostname, $username, $password, $database);

        // sql문 작성 (INSERT)
        $sql = "INSERT INTO bar (name, msg) VALUES ('$name', '$msg')";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 제출 실패했을 경우
        if (!$result) {
            header("Refresh: 2; URL='form.html'");
            echo "제출 실패";
            exit;
        }

        // 제출 성공했을 경우
        header("Refresh: 2; URL='list.php'");
        echo "제출 성공";
        exit;

    } catch (Exception $e) {
        // DB 오류 발생
        header("Refresh: 2; URL='form.html'");
        echo "DB error".$e;
    }

    // 데이터베이스 종료
    $db_conn->close();
?>