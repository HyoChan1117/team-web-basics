<?php

    $id = 1;
    $title = "hi";

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성
        $sql = "SELECT * FROM board WHERE postID = ? AND title = ?";

        // 쿼리 실행
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("is", $id, $title);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

    } catch (Exception $e) {
        echo "DB 오류 발생<br>".$e;
    }

    // 출력
    echo $row['name']." ".$row['content'];

?>