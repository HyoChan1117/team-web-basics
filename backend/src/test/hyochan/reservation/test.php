<?php
    // 날짜 및 예약 시간 설정
    $date = date("Y-m-d");
    $time = ["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];

    try {
        require_once "./db_connect.php";

        // 초기 날짜의 예약 시간만 읽어서 select 옵션 disabled 처리에 사용
        $sql = "SELECT date, time FROM reservation WHERE date = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();

        $booked_init = [];
        while ($row = $result->fetch_assoc()) {
            $booked_init[] = $row['time'];
        }
    } catch (Exception $e) {
        echo "DB 오류 발생<br>".$e;
        exit;
    }

    $db_conn->close();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Document</title>
    <style>
      /* 선택 불가한 시간은 시각적으로도 표시 */
      select[name="time"] option:disabled { color: #999; }
    </style>
</head>
<body>
    <h1>BOOKING</h1>

    <form action="reservation.php" method="post">
        <fieldset>
            <legend>예약 정보 입력</legend>
            
            <p>이름</p>
            <input type="text" name="name" placeholder="이름을 입력하세요." required>

            <p>성별</p>
            <input type="radio" id="man" name="gender" value="남자">
            <label for="man">남자</label><br>
            <input type="radio" id="woman" name="gender" value="여자">
            <label for="woman">여자</label>

            <p>서비스</p>
            <input type="checkbox" id="service1" name="service[]" value="커트">
            <label for="service1">커트</label><br>
            <input type="checkbox" id="service2" name="service[]" value="파마">
            <label for="service2">파마</label><br>
            <input type="checkbox" id="service3" name="service[]" value="염색">
            <label for="service3">염색</label><br>

            <p>요구사항</p>
            <textarea cols="30" rows="5" name="requirement" required></textarea>

            <p>날짜 선택</p>
            <input type="date" id="date" name="date" value="<?= date('Y-m-d')?>">

            <p>시간 선택</p>
            <select name="time" id="time-select">
                <?php
                    foreach ($time as $t) {
                        $disabled = in_array($t, $booked_init) ? "disabled" : "";
                        echo "<option value='$t' $disabled>$t</option>";
                    }
                ?>
            </select>
            <hr>
            <button>예약</button>
            <input type="reset" value="초기화">
        </fieldset>
    </form>

    <hr>

    예약 목록 가기 <a href="list.php">가자</a>

    <script>
      // 전체 타임슬롯 & 초기 예약시간(초기 disabled 반영용)
      const ALL_TIMES   = <?= json_encode($time, JSON_UNESCAPED_UNICODE) ?>;
      const BOOKED_INIT = <?= json_encode($booked_init, JSON_UNESCAPED_UNICODE) ?>;

      const $date = document.getElementById('date');
      const $time = document.getElementById('time-select');

      function applyDisabled(booked) {
        // 옵션 disabled 처리
        Array.from($time.options).forEach(opt => {
          opt.disabled = booked.includes(opt.value);
        });

        // 현재 선택이 비활성화되면 첫 사용가능 시간으로 보정
        if ($time.selectedOptions[0]?.disabled) {
          const firstAvailable = Array.from($time.options).find(o => !o.disabled);
          if (firstAvailable) firstAvailable.selected = true;
        }
      }

      async function loadFor(dateStr) {
        try {
          const res = await fetch('reservations_api.php?date=' + encodeURIComponent(dateStr), {
            headers: { 'Accept': 'application/json' },
            cache: 'no-store'
          });
          if (!res.ok) throw new Error('network');
          const data = await res.json();
          applyDisabled(data.ok ? (data.booked || []) : []);
        } catch (e) {
          console.error(e);
          // 오류 시에는 일단 모두 선택 가능하게(혹은 정책에 맞게 유지)
          applyDisabled([]);
        }
      }

      // 초기 렌더: 서버 결과 반영
      applyDisabled(BOOKED_INIT);

      // 날짜 변경 시 비동기 호출로 disabled 갱신
      $date.addEventListener('change', (e) => {
        loadFor(e.target.value);
      });
    </script>
</body>
</html>
