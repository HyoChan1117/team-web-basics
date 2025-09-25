<?php

    // 글 id를 GET로 받기
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';
    // review name pw를 post로 받기
    $review = isset($_POST['review']) ? $_POST['review'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $pw = isset($_POST['pw']) ? $_POST['pw'] : '';
    
    // pw hash 처리
    $pw_hash = password_hash($pw, PASSWORD_DEFAULT);

    // 유호성 확인
    if ($review === '' || $name === '' || $pw === '') {
        header('Refresh: 2; read2.php');
        echo "잘못된 접근입니다.";
        exit;
    }

    try {
        // DB연결
        require_once("./db_connect.php");

        // table에 insert
        $sql = "INSERT INTO comment (name, pw, review, postID) 
                VALUES ('$name', '$pw_hash', '$review', '$postID')";
        $query = $db_conn->query($sql);

        // read2로 가기
        header("Location: read2.php?postID=$postID");

    } catch (Exception $e){
        // 에러 처리
        echo "DB오류 발생";
    }

    $db_conn->close();

?>