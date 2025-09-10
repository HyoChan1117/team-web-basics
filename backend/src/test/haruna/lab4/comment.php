<?php

    // 댓글 받기
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $pw = isset($_POST['pw']) ? $_POST['pw'] : '';
    $review = isset($_POST['review']) ? $_POST['review'] : '';

    // 유호성 검사
    if ($name === '' || $pw === '' || $review === '' ) {
            header("Refresh: 2; URL='read.php?postID=$postID'");
            echo "모든 빌드를 입력하세요.";
            exit;
    }

    // pw hash처리
    $pw_hash = password_hash($pw, PASSWORD_DEFAULT);

    try {

        // DB연결
        require_once("./db_connect.php");

        // 댓글 INSERT
        $insertSql = "INSERT INTO comment(name, pw, review, postID, created_at) 
                            VALUES ('$name', '$pw_hash', '$review', '$postID', NOW())";
        $insertQuery = $db_conn->query($insertSql);
        header("Location: read.php?postID=$postID");

    } catch (Exception $e) {
        echo "DB오류" . $e;
        exit;
    }
    $db_conn->close();

    
