<?php
declare(strict_types=1);
require_once './db_connect.php';
require_once './validate.php';
require_once './Reservation.php';

$resv = new ReservationMySQLi($db_conn);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $service_id = $_POST['service_id'] ?? '';
  $customer_name = trim($_POST['customer_name'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $reservation_date = $_POST['reservation_date'] ?? '';
  $time_slot = $_POST['time_slot'] ?? '';
  $note = trim($_POST['note'] ?? '');

  if (!required($customer_name)) $errors['customer_name'] = '이름을 입력하세요.';
  if (!phone_like($phone)) $errors['phone'] = '연락처 형식을 확인하세요.';
  if (!ymd($reservation_date)) $errors['reservation_date'] = '날짜 형식(YYYY-MM-DD).';
  if (!time_slot_like($time_slot)) $errors['time_slot'] = '시간 형식(HH:MM).';
  if (!ctype_digit((string)$service_id)) $errors['service_id'] = '서비스를 선택하세요.';

  if (!$errors) {
    try {
      $id = $resv->create([
        'service_id' => $service_id,
        'customer_name' => $customer_name,
        'phone' => $phone,
        'reservation_date' => $reservation_date,
        'time_slot' => $time_slot,
        'note' => $note,
      ]);
      header('Location: /thanks.php?id=' . $id);
      exit;
    } catch (RuntimeException $e) {
      $errors['duplicate'] = $e->getMessage();
    } catch (Throwable $e) {
      http_response_code(500);
      $errors['server'] = '서버 에러가 발생했습니다.';
    }
  }
}

$services = $resv->services();
$date = $_GET['date'] ?? date('Y-m-d');
$serviceIdForSlots = isset($_GET['sid']) && ctype_digit($_GET['sid']) ? (int)$_GET['sid'] : (int)($services[0]['service_id'] ?? 1);
$occupied = $resv->occupiedSlots($date, $serviceIdForSlots);

$timeSlots = ['09:00','09:30','10:00','10:30','11:00','11:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00'];
?>

<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <title>간단 예약</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: system-ui, sans-serif; max-width: 720px; margin: 24px auto; padding: 0 12px; }
    .error { color: #d00; font-size: 0.95rem; }
    label { display:block; margin-top:12px; }
    input, select, textarea { width:100%; padding:10px; box-sizing:border-box; }
    button { margin-top:16px; padding:10px 16px; cursor:pointer; }
    .muted { color:#666; font-size:0.9rem; }
  </style>
</head>
<body>
  <h1>예약하기</h1>

  <?php if ($errors): ?>
    <div class="error">
      <?php foreach ($errors as $msg) echo htmlspecialchars($msg, ENT_QUOTES) . "<br>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" action="thanks.php">
    <label>서비스
      <select name="service_id" required>
        <?php foreach ($services as $s): ?>
          <option value="<?= (int)$s['service_id'] ?>"><?= htmlspecialchars($s['name'], ENT_QUOTES) ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>예약 날짜
      <input type="date" name="reservation_date" value="<?= htmlspecialchars($date, ENT_QUOTES) ?>" required>
    </label>

    <label>시간대
      <select name="time_slot" required>
        <?php foreach ($timeSlots as $t):
          $disabled = in_array($t, $occupied, true);
        ?>
          <option value="<?= $t ?>" <?= $disabled ? 'disabled' : '' ?>>
            <?= $t ?><?= $disabled ? ' (예약 불가)' : '' ?>
          </option>
        <?php endforeach; ?>
      </select>
      <div class="muted">선택 불가능한 시간대는 이미 예약됨</div>
    </label>

    <label>이름
      <input type="text" name="customer_name" required>
    </label>

    <label>연락처
      <input type="text" name="phone" placeholder="010-1234-5678" required>
    </label>

    <label>요청사항(선택)
      <textarea name="note" rows="3" placeholder="예: 짧게, 옆머리 자연스럽게 등"></textarea>
    </label>

    <button type="submit">예약 완료</button>
  </form>

  <p class="muted" style="margin-top:24px;">
    관리용: <a href="/list.php">예약 목록</a>
  </p>
</body>
</html>