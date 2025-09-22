<?php

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성
        $sql = "SELECT * FROM json";

        // 쿼리 실행
        $result = $db_conn->query($sql);

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        while ($row = $result->fetch_assoc()) {
            // json 형식 decode
            $info = json_decode($row['info'], true);
            echo "Phone: $info[Phone]";
        }

    ?>
</body>
</html>