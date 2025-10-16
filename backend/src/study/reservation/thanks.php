<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>

<!doctype html>
<html lang="ko"><head><meta charset="utf-8"><title>예약 완료</title></head>
<body>
  <h1>예약이 완료되었습니다 🎉</h1>
  <p>예약번호: <?= $id ?></p>
  <p><a href="/index.php">돌아가기</a> · <a href="/list.php">예약 목록 보기</a></p>
</body></html>
