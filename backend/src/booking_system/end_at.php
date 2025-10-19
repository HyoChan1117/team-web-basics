<?php

    // 마이페이지 리다이렉션 함수
    function redirection($msg) {
        header("Refresh: 2; URL='mypage.php'");
        echo $msg;
        exit;
    }

    // 입력값 유효성 검사
    $reservation_id = isset($_GET['reservation_id']) ? $_GET['reservation_id'] : '';
    $time = isset($_GET['time']) ? $_GET['time'] : '';

    // 유효하지 않는 입력값일 경우
    // 유효하지 않는 입력값입니다. -> 마이페이지 리다이렉션
    if (empty($reservation_id) || empty($time)) {
        redirection("유효하지 않는 입력값입니다.");
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성
        $sql_s = "SELECT start_at, end_at FROM Reservation WHERE reservation_id='$reservation_id' AND start_at < end_at";

        // 쿼리 실행
        $result_s = $db_conn->query($sql_s);

        // 예외 처리
        // 시작 시간이 종료 시간보다 늦는 경우
        // 시작 시간이 종료 시간보다 늦습니다. -> 마이페이지 리다이렉션
        if ($result_s->num_rows <= 0) {
            redirection("시작 시간이 종료 시간보다 늦습니다.");
        }

        // sql문 작성
        $sql_u = "UPDATE Reservation SET end_at='$time', status='confirmed' WHERE reservation_id='$reservation_id'";

        // 쿼리 실행
        $result_u = $db_conn->query($sql_u);

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생.<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>