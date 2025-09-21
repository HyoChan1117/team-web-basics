<?php

    $date = date("Y-m-d");

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (SELECT)
        $sql = "SELECT * FROM reservation WHERE date='$date' ORDER BY time";

        // 쿼리 실행
        $result = $db_conn->query($sql);

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
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
    <!-- 
    예약 현황

    <table>
        <tr>
            <th>번호</th>
            <th>날짜</th>
            <th>시간</th>
            <th>예약자</th>
            <th>성별</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>작성일자</th>
        </tr>
    </table>
    -->
    <h1>예약 현황</h1>

    <table border='1'>
        <tr>
            <th>번호</th>
            <th>날짜</th>
            <th>시간</th>
            <th>예약자</th>
            <th>성별</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>작성일자</th>
        </tr>
        
        <?php

            $count = 1;

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>$count</td>";
                echo "<td>$row[date]</td>";
                echo "<td>$row[time]</td>";
                echo "<td>$row[name]</td>";
                echo "<td>$row[gender]</td>";
                echo "<td>$row[service]</td>";
                echo "<td>$row[requirement]</td>";
                echo "<td>$row[created_at]</td>";
                echo "</tr>";

                $count++;
            }

        ?>
    </table>

    <hr>

    예약하기 <a href="test.php">가자</a>
</body>
</html>