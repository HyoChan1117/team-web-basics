<?php
// POST로 전달된 이름과 메시지를 받음
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';

// 유호성을 확인 
if ($name === '' || $content === '') {
    header("Refresh: 2; URL='form.html'");
    echo "모든 빌드를 입력하세요.";
    exit;
}

// DB 연결을 mysqli로 한다.
require_once("./db_conf.php");

// DB(테이블: guestbook)에 저장한다
$insertSql = "INSERT INTO guestbook (name, content) VALUES ('$name', '$content')";
$insertResult = $db_conn->query($insertSql); 

// 저장이 끝나면 list.php로 이동한다.
if($insertResult){
    header("Refresh: 2; URL='list.php'");
    echo "입력이 완료되었습니다.";
    exit;
} else {
    echo "insert 오류";
}

?>