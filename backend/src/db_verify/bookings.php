<?php

    // 예약 시간 리스트
    $time = ["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00"];
    $date = date("Y-m-d");

    // 로그인 정보 및 사용자 권한 허가 함수 불러오기
    require_once "./header.php";
    require_once "./helper.php";

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (SELECT)
        $sql = "SELECT 
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
        $sql_designer = "SELECT user_id FROM Users WHERE role='designer'";

        // 쿼리 실행
        $result = $db_conn->query($sql);
        $result_client = $db_conn->query($sql_client);
        $result_designer = $db_conn->query($sql_designer);

        // 고객
        $row_client = $result_client->fetch_assoc();

        // 디자이너
        $designers = array();
        $count_d = 0;
        while ($row = $result_designer->fetch_assoc()) {
            $designers[$count_d] = $row['user_id'];
            $count_d++;
        }

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
            <th>예약자</th>
            <th>디자이너</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>날짜</th>
            <th>시간</th>
            <th>상태</th>
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
            <th>예약자</th>
            <th>디자이너</th>
            <th>서비스</th>
            <th>요구사항</th>
            <th>날짜</th>
            <th>시간</th>
            <th>상태</th>
        </tr>

        <?php

            if ($result->num_rows <= 0) {
                echo "<tr><td colspan='8'>예약 현황이 없습니다.</td></tr>";
            } else {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$row[reservation_id]</td>";
                    echo "<td>$row[client_name]</td>";
                    echo "<td>$row[designer_name]</td>";
                    echo "<td>$row[service]</td>";
                    echo "<td>$row[requirement]</td>";
                    echo "<td>$row[date]</td>";
                    echo "<td>$row[start_at]</td>";
                    echo "<td>$row[status]</td>";
                    echo "</tr>";
                }
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
            <input type="checkbox" id="cut" name="service[]" value="커트">
            <label for="cut">커트</label>
            <input type="checkbox" id="perm" name="service[]" value="펌">
            <label for="perm">펌</label>
            <input type="checkbox" id="dyeing" name="service[]" value="염색">
            <label for="dyeing">염색</label>

            <p><strong>REQUIREMENT</strong></p>
            <textarea name="requirement" cols="30" rows="5"></textarea>

            <p><strong>DESIGNER</strong></p>
            <input type="radio" id="hyochan" name="designer" value="<?= $designers[0] ?>">
            <label for="hyochan">김효찬</label>
            <input type="radio" id="haruna" name="designer" value="<?= $designers[1] ?>">
            <label for="haruna">하루나</label>

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