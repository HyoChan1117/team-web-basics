<?php
// reservations_api.php
header('Content-Type: application/json; charset=UTF-8');

$date = $_GET['date'] ?? '';

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode(['ok' => false, 'error' => 'invalid_date']);
    exit;
}

try {
    require_once "./db_connect.php";

    $sql = "SELECT time FROM reservation WHERE date = ? ORDER BY time";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $booked = [];
    while ($row = $result->fetch_assoc()) {
        $booked[] = $row['time'];
    }

    echo json_encode([
        'ok'     => true,
        'date'   => $date,
        'booked' => $booked
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'db_error']);
} finally {
    if (isset($db_conn)) $db_conn->close();
}
