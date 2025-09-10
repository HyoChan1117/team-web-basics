<?php

    // 글의 postID 받기
    $postID = isset($_GET['id']) ? intval($_GET['id']) : '';

    if (empty($postID)) {
        echo "id 없음";
    }

    // 댓글 name, pw, review를 받기
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $pw = isset($_POST['pw']) ? trim($_POST['pw']) : '';
    $review = isset($_POST['review']) ? $_POST['review'] : '';

    // 유호성 확인
    if ($name === '' || $pw === '' || $review === '') {
        header("Refresh : 2; URL='read.php'");
        echo "잘 못한 접근 입니다.";
        exit;
    }

    try {
        // DB연결 하기
        require_once("./db_connect.php");

        $pw_hash = password_hash($pw, PASSWORD_DEFAULT);

        // INSERT . ( comment table의 postID에 글의 postID를 저장하기 )
        $insertSql = "INSERT INTO comment (name, pw, review, postID) 
                        VALUE ('$name', '$pw_hash', '$review', '$postID')";
        // 쿼리 실행
        $insertQuery = $db_conn->query($insertSql);

        // 성공하면 read.php로 이동하기
        header("Location: read.php?id=$postID");

    } catch (Exception $e) {
        echo "DB오류 발생" . $e;
    }
 
    $db_conn->close();
?>