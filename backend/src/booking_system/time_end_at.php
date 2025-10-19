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
        $sql_s = "SELECT start_at FROM Reservation WHERE reservation_id='$reservation_id'";

        // 쿼리 실행
        $result_s = $db_conn->query($sql_s);
        $row_s = $result_s->fetch_assoc();

        // 예외 처리
        // 종료 시간이 시작 시간보다 빠른 경우
        // 종료 시간이 시작 시간보다 빠릅니다. -> 마이페이지 리다이렉션
        if (strtotime($row_s['start_at']) > strtotime($time)) {
            redirection("종료 시간이 시작 시간보다 빠릅니다.");
        }

        // sql문 작성
        $sql_u = "UPDATE Reservation SET end_at='$time', status='confirmed' WHERE reservation_id='$reservation_id'";

        // 쿼리 실행
        $result_u = $db_conn->query($sql_u);

        // 업데이트에 실패했을 경우
        // 종료 시간이 설정되지 않았습니다. -> 마이페이지 리다이렉션
        if (!$result_u) {
            redirection("종료 시간이 설정되지 않았습니다.");
        }

        // 업데이트에 성공했을 경우
        // 종료 시간이 설정되었습니다.
        redirection("종료 시간이 설정되었습니다.");

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생.<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>