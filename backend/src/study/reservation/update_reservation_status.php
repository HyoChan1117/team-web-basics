<?php
$host = 'db';
$user = 'root';
$pass = 'root';
$dbname = 'backend';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$reservation_id = $_POST['reservation_id'];
$new_status     = $_POST['status'];

// 허용된 상태만 변경 가능하도록 화이트리스트 적용
$allowed_statuses = ['confirmed', 'checked_in', 'completed', 'no_show'];

if (!in_array($new_status, $allowed_statuses)) {
    die("⛔ 잘못된 상태 변경 요청입니다.");
}

$sql = "
    UPDATE Reservation
    SET status = ?
    WHERE reservation_id = ?
      AND status NOT IN ('cancelled', 'completed', 'no_show')
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $new_status, $reservation_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<h2>✅ 상태가 '$new_status'로 변경되었습니다.</h2>";
} else {
    echo "<h2>❌ 상태 변경 실패. 이미 처리된 예약일 수 있습니다.</h2>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
