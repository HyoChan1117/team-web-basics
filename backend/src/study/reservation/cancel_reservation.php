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
$reason = $_POST['reason'];

$sql = "
    UPDATE Reservation
    SET status = 'cancelled',
        cancelled_at = NOW(),
        cancel_reason = ?
    WHERE reservation_id = ?
      AND status IN ('pending', 'confirmed')  -- 이미 완료된 예약은 취소 못 하게
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $reason, $reservation_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<h2>✅ 예약이 성공적으로 취소되었습니다.</h2>";
} else {
    echo "<h2>❌ 예약 취소에 실패했습니다. 이미 처리된 예약일 수 있습니다.</h2>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
