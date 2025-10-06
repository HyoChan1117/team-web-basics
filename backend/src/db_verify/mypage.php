<?php

    // 로그인 정보 불러오기
    require_once "./header.php";

    // 사용자 권한 허가 함수 불러오기
    require_once "./helper.php";

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // 사용자에 따른 권한 부여
        $where = "";

        // 고객
        if (users_permission($_SESSION['role'], 'client')) {
            $where = "WHERE u1.role='client' AND u1.account='$session_account'";
        }
        
        // 디자이너
        if (users_permission($_SESSION['role'], 'designer')) {
            $where = "WHERE u2.role='designer' AND u2.account='$session_account'";
        }

        // sql문 작성
        $sql = "SELECT 
                r.*,
                u1.user_name AS client_name,
                u2.user_name AS designer_name
                FROM Reservation AS r
                JOIN Users AS u1
                    ON r.client_id=u1.user_id
                JOIN Users AS u2
                    ON r.designer_id=u2.user_id
                $where
                ORDER BY date, start_at
                ";

        // 쿼리 실행
        $result = $db_conn->query($sql);
    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
        exit;
    }
    
    // 데이터베이스 종료
    $db_conn->close();

    // 메뉴판 불러오기
    require_once "./menu.html";

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지</title>
</head>
    <!--
    마이페이지

    나의 예약 현황 (사용자에 따라 다른 출력)

    <table>
        <tr>
            <th>번호</th>
            <th>예약자</th>
            <th>디자이너</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>날짜</th>
            <th>시작시간</th>
            <th>종료시간</th>
            <th>상태</th>
        </tr>
    </table>

    -->
    <h2>MYPAGE</h2>

    <h3>나의 예약 현황</h3>

    <table border="1">
        <tr>
            <th>번호</th>
            <th>예약자</th>
            <th>디자이너</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>날짜</th>
            <th>시작시간</th>
            <th>종료시간</th>
            <th>상태</th>
        </tr>

        <!-- 사용자에 따라 다른 출력 -->
        <?php
            $count = 0;

            // 고객 출력
            if (users_permission($_SESSION['role'], 'client')) {
                // 나의 예약이 없을 경우
                // 현재 예약 현황이 없습니다.
                if ($row = $result->num_rows <= 0) {
                    echo "<tr><td colspan='9'>현재 예약 현황이 없습니다.</td></tr>";
                }

                // 예약이 있을 경우
                while ($row = $result->fetch_assoc()) {
                    $count++;

                    echo "<tr>";
                    echo "<td>$count</td>";
                    echo "<td>$row[client_name]</td>";
                    echo "<td>$row[designer_name]</td>";
                    echo "<td>$row[service]</td>";
                    echo "<td>$row[requirement]</td>";
                    echo "<td>$row[date]</td>";
                    echo "<td>$row[start_at]</td>";
                    echo "<td>$row[end_at]</td>";
                    echo "<td>$row[status]</td>";
                    echo "</tr>";

                }
            }

            // 디자이너 출력
            if (users_permission($_SESSION['role'], 'designer')) {
                // 나의 예약이 없을 경우
                // 현재 예약 현황이 없습니다.
                if ($row = $result->num_rows <= 0) {
                    echo "<tr><td>현재 예약 현황이 없습니다.</td></tr>";
                }

                // 예약이 있을 경우
                $rsv_id = array();
                while ($row = $result->fetch_assoc()) {
                    $count++;

                    echo "<tr>";
                    echo "<td>$count</td>";
                    echo "<td>$row[client_name]</td>";
                    echo "<td>$row[designer_name]</td>";
                    echo "<td>$row[service]</td>";
                    echo "<td>$row[requirement]</td>";
                    echo "<td>$row[date]</td>";
                    echo "<td>$row[start_at]</td>";
                    echo "<td>$row[end_at]</td>";
                    echo "<td>$row[status]</td>";
                    echo "</tr>";

                    $rsv_id[$count - 1] = $row['reservation_id'];
                }

                echo "</table><br>";

                // 종료 시간 설정
                echo "<form action='end_at.php' method='get'>";
                echo "<fieldset>";
                echo "<legend>종료 시간 설정</legend>";
                echo "<p>예약 선택</p>";
                for ($i = 0; $i < $count; $i++) {
                    echo "<input type='radio' name='reservation_id' value='$rsv_id[$i]'> ". $i + 1 . "번 ";
                }
                echo "<p>시간 선택</p>";
                echo "<input type='time' name='time' value='09:00'>";
                echo "</fieldset>";
                echo "<button>제출</button>";
                echo "<input type='reset' value='초기화'>";
                echo "</form>";
            }
        ?>
</body>
</html>