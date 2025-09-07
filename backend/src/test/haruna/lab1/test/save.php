<?php
    // post로 이름과 메시지 내용을 받기
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $content = isset($_POST["content"]) ? $_POST["content"] : '';

    // 유호성을 검사
    if ($name === '' || $content === '') {
        header("Refresh: 2; URL='form.html'");
        echo "잘못한 접극입니다.";
        exit;
    }

    try {
        // DB 연결
        require_once("./db_conf.php");

        // INSERT 명련 문
        $insertSql = "INSERT INTO guestbook (name, content) VALUES ('$name', '$content')";
        // query 실행
        $insertQuery = $db_conn->query($insertSql);

        // list로 이동
        header("Refresh: 2; URL='list.php'");
        echo "완료 했습니다.";

        // 예외 저리
    } catch (Exception $e){
        echo "DB 연결 오류 발생" . $e;
        exit;
    }

    // DB 연결 종료
    $db_conn->close();

?>