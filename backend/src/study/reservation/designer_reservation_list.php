<?php
$host = 'db';
$user = 'root';
$pass = 'root';
$dbname = 'backend';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$designer_id = 2;  // 예: ?designer_id=2

$sql = "
    SELECT r.reservation_id, r.client_id, r.start_at, r.end_at, r.status,
           u.name AS client_name,
           s.name AS service_name
    FROM Reservation r
    JOIN Users u ON r.client_id = u.user_id
    JOIN Service s ON r.service_id = s.service_id
    WHERE r.designer_id = ?
    ORDER BY r.start_at DESC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $designer_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

echo "<h2>✂ 디자이너 예약 목록</h2>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style='margin-bottom:20px;'>";
    echo "🆔 예약번호: " . $row['reservation_id'] . "<br>";
    echo "👤 고객: " . $row['client_name'] . " (ID: " . $row['client_id'] . ")<br>";
    echo "🛠 서비스: " . $row['service_name'] . "<br>";
    echo "🕒 시간: " . $row['start_at'] . " ~ " . $row['end_at'] . "<br>";
    echo "📌 상태: <b>" . strtoupper($row['status']) . "</b><br>";

    // 상태 변경 가능한 경우만 버튼 출력
    if ($row['status'] === 'pending') {
        echo "<form method='POST' action='update_reservation_status.php'>";
        echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
        echo "<input type='hidden' name='status' value='confirmed'>";
        echo "<button type='submit'>✅ 확정하기</button>";
        echo "</form>";
    } elseif ($row['status'] === 'confirmed') {
        echo "<form method='POST' action='update_reservation_status.php'>";
        echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
        echo "<input type='hidden' name='status' value='checked_in'>";
        echo "<button type='submit'>🟢 체크인 처리</button>";
        echo "</form>";
    } elseif ($row['status'] === 'checked_in') {
        echo "<form method='POST' action='update_reservation_status.php' style='display:inline;'>";
        echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
        echo "<input type='hidden' name='status' value='completed'>";
        echo "<button type='submit'>🏁 완료 처리</button>";
        echo "</form> ";

        echo "<form method='POST' action='update_reservation_status.php' style='display:inline;'>";
        echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
        echo "<input type='hidden' name='status' value='no_show'>";
        echo "<button type='submit'>❌ 노쇼 처리</button>";
        echo "</form>";
    }

    echo "</div><hr>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
