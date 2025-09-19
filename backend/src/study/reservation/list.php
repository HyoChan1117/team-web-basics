<?php
declare(strict_types=1);
require __DIR__ . '/../src/db_connect.php';
require __DIR__ . '/../src/Reservation_mysqli.php';

$resv = new ReservationMySQLi($db_conn);
$date = $_GET['date'] ?? null;
$list = $resv->all($date);
?>

<!doctype html>
<html lang="ko">
<head><meta charset="utf-8"><title>예약 목록</title>
<style>table{border-collapse:collapse;width:100%}td,th{border:1px solid #ddd;padding:8px}</style>
</head>
<body>
  <h1>예약 목록</h1>
  <form method="get">
    <label>날짜 필터: <input type="date" name="date" value="<?= htmlspecialchars($date ?? '', ENT_QUOTES) ?>"></label>
    <button>조회</button>
  </form>
  <table>
    <thead>
      <tr><th>일자</th><th>시간</th><th>서비스</th><th>고객</th><th>연락처</th><th>요청사항</th><th>생성</th></tr>
    </thead>
    <tbody>
      <?php foreach ($list as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['reservation_date'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($r['time_slot'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($r['service_name'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($r['customer_name'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($r['phone'], ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($r['note'] ?? '', ENT_QUOTES) ?></td>
          <td><?= htmlspecialchars($r['created_at'], ENT_QUOTES) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p><a href="/index.php">예약 페이지로</a></p>
</body>
</html>
