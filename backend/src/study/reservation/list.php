<?php
$host = 'db';
$user = 'root';
$pass = 'root';
$dbname = 'backend';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$client_id = 1;  // 예: ?client_id=1

$sql = "
    SELECT r.reservation_id, r.start_at, r.end_at, r.status,
           u.name AS designer_name,
           s.name AS service_name,
           r.cancelled_at, r.cancel_reason
    FROM Reservation r
    JOIN Users u ON r.designer_id = u.user_id
    JOIN Service s ON r.service_id = s.service_id
    WHERE r.client_id = ?
    ORDER BY r.start_at DESC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $client_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

echo "<h2>📋 내 예약 목록</h2>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style='margin-bottom:20px;'>";
    echo "🆔 예약번호: <b>" . $row['reservation_id'] . "</b><br>";
    echo "💇 디자이너: " . $row['designer_name'] . "<br>";
    echo "🛠 서비스: " . $row['service_name'] . "<br>";
    echo "🕒 시간: " . $row['start_at'] . " ~ " . $row['end_at'] . "<br>";
    echo "📌 상태: <b>" . strtoupper($row['status']) . "</b><br>";

    // 상태별 추가 정보
    if ($row['status'] === 'cancelled') {
        echo "🚫 취소 시각: " . $row['cancelled_at'] . "<br>";
        echo "📝 사유: " . $row['cancel_reason'] . "<br>";
    }

    // 취소 가능한 상태에만 버튼 출력
    if (in_array($row['status'], ['pending', 'confirmed'])) {
        echo "<form method='POST' action='cancel_reservation.php'>";
        echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
        echo "<input type='text' name='reason' placeholder='취소 사유' required>";
        echo "<button type='submit'>❌ 예약 취소</button>";
        echo "</form>";
    }

    echo "</div><hr>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
