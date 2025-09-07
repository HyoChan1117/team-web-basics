<?php
    // post로 입력 값을 받는다
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    // 잘 못한 접극은 오류 표시
    if ($name === '' || $content === '') {
        header("Refresh: 2; URL='form.html'");
        echo "잘 못한 접극입니다.";
        exit;
    }

    try{
        // DB연결
        require_once("./db_conf.php");

        // DB에 INSERT
        $Sql = "INSERT INTO guestbook (name, content) VALUES ('$name', '$content')";
        $result = $db_conn->query($Sql);
        
        // 완료하면 list.php로 이동
        header("Refresh: 2; URL='list.php'");
        echo "입력 완료됐습니다.";

    } catch (Exception $e){
        echo "DB 오류 발생" . $e;
        exit;
    }

    // DB close
    $db_conn->close();

?>