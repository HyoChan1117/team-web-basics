<?php

    // 예약 시간 리스트
    $time = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00",
             "12:30", "13:00", "13:30", "14:00", "14:30", "15:00",
             "15:30", "16:00", "16:30", "17:00", "17:30", "18:00"];
    
    $date = date("Y-m-d");

    // 로그인 정보 및 사용자 권한 허가 함수 불러오기
    require_once "./header.php";
    require_once "./helper.php";

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (SELECT)
        $sql_to = "SELECT
                   t.*,
                   u.user_name AS designer_name
                   FROM TimeOff AS t
                   JOIN Users AS u
                        ON t.designer_id=u.user_id"
                   ;
        $sql_rsv = "SELECT 
                    r.*,
                    u1.user_name AS client_name,
                    u2.user_name AS designer_name
                    FROM Reservation AS r
                    JOIN Users AS u1
                        ON r.client_id=u1.user_id
                    JOIN Users AS u2
                        ON r.designer_id=u2.user_id
                    ORDER BY date, start_at";
        $sql_client = "SELECT user_id FROM Users WHERE account='$session_account'";
        $sql_designer = "SELECT user_id, user_name FROM Users WHERE role='designer'";

        $sql_service = "SELECT * FROM Service";

        // 쿼리 실행
        $result_to = $db_conn->query($sql_to);
        $result_rsv = $db_conn->query($sql_rsv);
        $result_client = $db_conn->query($sql_client);
        $result_designer = $db_conn->query($sql_designer);
        $result_service = $db_conn->query($sql_service);

        // 고객
        $row_client = $result_client->fetch_assoc();

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
    <title>예약하기</title>
</head>
<body>
    <!--
    BOOKINGS

    예약 현황
    <table>
        <tr>
            <th>번호</th>
            <th>디자이너</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>날짜</th>
            <th>시작시간</th>
            <th>종료시간</th>
            <th>상태</th>
        </tr>
    </table>

    디자이너 휴무
    <table>
        <tr>
            <th>번호</th>
            <th>디자이너</th>
            <th>시작일</th>
            <th>종료일</th>
        </tr>
    </table>

    FORM
    Action: bookings_process.php
    Method: post
    입력값: 성별(gender), 서비스(service), 요구사항(requirement), 디자이너(designer), 시작 시간(start_at)
    -->

    <h2>BOOKINGS</h2>

    <h3>예약 현황</h3>
    <table border="1">
        <tr>
            <th>번호</th>
            <th>디자이너</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>날짜</th>
            <th>시작시간</th>
            <th>종료시간</th>
            <th>상태</th>
        </tr>

        <?php
            $count = 1;
            if ($result_rsv->num_rows <= 0) {
                echo "<tr><td colspan='8'>예약 현황이 없습니다.</td></tr>";
            } else {
                while ($row = $result_rsv->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$count</td>";
                    echo "<td>$row[designer_name]</td>";
                    echo "<td>$row[service]</td>";
                    echo "<td>$row[requirement]</td>";
                    echo "<td>$row[date]</td>";
                    echo "<td>$row[start_at]</td>";
                    echo "<td>$row[end_at]</td>";
                    echo "<td>$row[status]</td>";
                    echo "</tr>";

                    $count++;
                }
            }
        ?>
    </table>

    <br>

    <h3>디자이너 휴무 (휴일: 매주 일요일)</h3>
    <table border='1'>
        <tr>
            <th>번호</th>
            <th>디자이너</th>
            <th>시작일</th>
            <th>종료일</th>
        </tr>

        <?php
            if ($result_to->num_rows <= 0) {
                echo "<tr><td colspan='4'>휴무 예정이 없습니다.</td></tr>";
            }

            $count_to = 1;
            while ($row = $result_to->fetch_assoc()) {
                echo "<tr>";
                echo "<td>$count_to</td>";
                echo "<td>$row[designer_name]</td>";
                echo "<td>$row[start_at]</td>";
                echo "<td>$row[end_at]</td>";
                echo "</tr>";

                $count_to++;
            }
        ?>
    </table>

    <br>

    <?php if (users_permission($_SESSION['role'], "client")):; ?>
    <form action="bookings_process.php" method="post">
        <input type="hidden" name="client" value="<?= $row_client['user_id'] ?>">
        <fieldset>
            <legend>예약 정보 입력</legend>
            <p><strong>SERVICE</strong></p>
            <?php while ($row = $result_service->fetch_assoc()):; ?>
            <input type="checkbox" name="service[]" value="<?= $row['service_name'] ?>"> <?= $row['service_name'] ?>
            <?php endwhile; ?>

            <p><strong>REQUIREMENT</strong></p>
            <textarea name="requirement" cols="30" rows="5"></textarea>

            <p><strong>DESIGNER</strong></p>
            <?php while ($row = $result_designer->fetch_assoc()):; ?>
            <input type="radio" name="designer" value="<?= $row['user_id'] ?>"> <?= $row['user_name'] ?>
            <?php endwhile; ?>

            <p><strong>TIME</strong></p>
            <input type="date" name="date" value="<?= $date ?>">
            <select name="start_at">
                <?php
                    foreach ($time as $t) {
                        echo "<option value='$t'>$t</option>";
                    }
                ?>
            </select>
        </fieldset>
        <button>예약</button>
        <input type="reset" value="초기화">
    </form>
    <?php endif; ?>
</body>
</html>