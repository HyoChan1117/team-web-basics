<?php

    // 예약 페이지 리다이렉션 함수 정의
    function redirection($msg) {
        header("Refresh: 2; URL='bookings.php'");
        echo $msg;
        exit;
    }

    // 입력값 유효성 검사
    $client = isset($_POST['client']) ? $_POST['client'] : '';
    $service = isset($_POST['service']) ? $_POST['service'] : '';
    $requirement = isset($_POST['requirement']) ? $_POST['requirement'] : '';
    $designer = isset($_POST['designer']) ? $_POST['designer'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $start_at = isset($_POST['start_at']) ? $_POST['start_at'] : '';

    // 유효하지 않는 입력값을 받았을 경우
    // 유효하지 않는 입력값입니다. -> 예약 페이지 리다이렉션
    if (empty($client) || empty($service) || empty($requirement) || empty($designer) || empty($date) || empty($start_at)) {
        redirection("유효하지 않는 입력값입니다.");
    }

    // 배열 값 문자화
    $services = implode(", ", $service);

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (SELECT)
        $sql_to = "SELECT * FROM TimeOff
                   WHERE '$date' BETWEEN start_at AND end_at
                   AND designer_id='$designer'";
        $sql_s = "SELECT * FROM Reservation WHERE designer_id='$designer'";
        
        // 쿼리 실행
        $result_to = $db_conn->query($sql_to); 
        $result_s = $db_conn->query($sql_s);

        // 예외 처리
        // 디자이너 휴무일 예약 불가 처리
        // 해당 디자이너 휴무일입니다. -> 예약 페이지 리다이렉션
        if ($result_to->num_rows > 0) {
            redirection("해당 디자이너 휴무일입니다.");
        }

        // 정기휴무일 예약 불가 처리
        // 매주 일요일은 정기휴일입니다. -> 예약 페이지 리다이렉션
        $holiday = 0;
        $rsv_weekday = date('w', strtotime($date));

        if ($holiday == $rsv_weekday) {
            redirection("매주 일요일은 정기휴일입니다.");
        }

        // 중복 예약 시간 처리
        // 디자이너(designer), 날짜(date), 시간(start_at), 상태(status) - cancel이 아닌 경우 중복처리
        // 중복된 예약 시간입니다. -> 예약 페이지 리다이렉션
        while ($row = $result_s->fetch_assoc()) {
            if ($row['designer_id'] == $designer && $row['date'] == $date && $row['start_at'] == "$start_at:00" && $row['status'] != "cancelled") {
                    redirection("중복된 예약 시간입니다.");
            }
        }

        // sql문 작성 (INSERT)
        $sql_i = "INSERT INTO Reservation (client_id, designer_id, service, requirement, date, start_at, status)
                  VALUES ('$client', '$designer', '$services', '$requirement', '$date', '$start_at', 'pending')";

        // 쿼리 실행
        $result_i = $db_conn->query($sql_i);

        // 예약에 실패했을 경우
        // 예약에 실패했습니다. -> 예약 페이지 리다이렉션
        if (!$result_i) {
            redirection("예약에 실패했습니다.");
        }

        // 예약에 성공했을 경우
        // 예약에 성공했습니다. -> 마이페이지 페이지 리다이렉션
        header("Refresh: 2; URL='mypage.php'");
        echo "예약에 성공했습니다.";
        exit;

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>