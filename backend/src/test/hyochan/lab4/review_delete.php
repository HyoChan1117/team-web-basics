<?php

    // id 유효성 검사
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    // 유효하지 않는 id 값일 경우
    // 유효하지 않는 id 값입니다.
    if (empty($id)) {
        echo "유효하지 않는 id 값입니다.";
        exit;
    }

    try {
        // 데이터베이스 종료
        require_once "./db_connect.php";

        // sql문 작성 (DELETE)
        $sql = "DELETE FROM comment WHERE postID='$id'";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 삭제 성공했을 경우
        // 게시물 읽기 페이지 리다이렉션
        if ($result) {
            header("Location: view.php?id=");
            exit;
        }
       
    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생 <br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>