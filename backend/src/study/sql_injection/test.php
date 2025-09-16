<?php

    $id = 1;
    $title = "hi";

    require_once "./db_connect.php";

    $sql = "
            SELECT * FROM board
            WHERE postID = ? AND title = ?
            ";

    $stmt = $db_conn->prepare($sql);   // 서버에 준비문(Prepared Statement) 생성
    $stmt->bind_param('is', $id, $title);   // placeholder(?)에 int값, string값 바인딩
    $stmt->execute();   // 바인딩 된 값으로 쿼리 실행
    $result = $stmt->get_result();  // 실행 결과 가져오기
    $row = $result->fetch_assoc();  

    echo $row['name'];
    
?>