<?php
$host = 'db';
$user = 'root';
$pass = 'root';
$dbname = 'backend';

// DB 연결
$conn = mysqli_connect($host, $user, $pass, $dbname);

// 연결 실패 시
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

// 입력값 받기
$client_id   = $_POST['client_id'];
$designer_id = $_POST['designer_id'];
$service_id  = $_POST['service_id'];
$date        = $_POST['date'];
$time        = $_POST['time'];

$start_at = $date . " " . $time;
$end_at = date("Y-m-d H:i:s", strtotime("$start_at +60 minutes"));

// ✅ 시간 겹침 검사 (Reservation 테이블 기반)
$check_sql = "
    SELECT reservation_id
    FROM Reservation
    WHERE designer_id = ?
      AND start_at < ?
      AND end_at > ?
";
$stmt = mysqli_prepare($conn, $check_sql);
mysqli_stmt_bind_param($stmt, "iss", $designer_id, $end_at, $start_at);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "<h2>❌ 이미 해당 시간에 예약이 존재합니다. 다른 시간을 선택해주세요.</h2>";
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
}
mysqli_stmt_close($stmt);

// 트랜잭션 시작
mysqli_begin_transaction($conn);

try {
    // 예약 삽입
    $insert_res_sql = "
        INSERT INTO Reservation (client_id, designer_id, service_id, start_at, end_at)
        VALUES (?, ?, ?, ?, ?)
    ";
    $stmt = mysqli_prepare($conn, $insert_res_sql);
    mysqli_stmt_bind_param($stmt, "iiiss", $client_id, $designer_id, $service_id, $start_at, $end_at);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // 커밋
    mysqli_commit($conn);

    echo "<h2>✅ 예약이 성공적으로 완료되었습니다!</h2>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<h2>❌ 오류 발생: " . $e->getMessage() . "</h2>";
}

mysqli_close($conn);
?>
