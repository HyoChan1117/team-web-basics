<?php

    // 입력값 유효성 검사
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : '';
    $service = isset($_POST["service"]) ? $_POST["service"] : '';
    $requirement = isset($_POST["requirement"]) ? $_POST["requirement"] : '';
    $date = isset($_POST["date"]) ? $_POST["date"] : '';
    $time = isset($_POST["time"]) ? $_POST["time"] : '';

    // 유효하지 않는 값이 넘어왔을 경우
    // 유효하지 않는 값입니다. -> 예약 페이지 리다이렉션
    if (empty($name) || empty($gender) || empty($service) || empty($requirement) || empty($date) || empty($time)) {
        header("Refresh: 2; URL='test.php'");
        echo "유효하지 않는 값입니다.";
        exit;
    }

    // 배열형 입력값 문자열 반환
    $service = implode(", ", $service);

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 실행 (SELECT)
        $sql_sel = "SELECT * FROM reservation";

        // 쿼리 실행
        $result_sel = $db_conn->query($sql_sel);

        // 예외 처리
        // 날짜 & 시간이 겹치는 경우
        // 중복되는 예약이 있습니다. -> 예약 페이지 리다이렉션
        while ($row = $result_sel->fetch_assoc()) {
            if ($row['date'] == $date && $row['time'] == $time) {
                header("Refresh: 2; URL='test.php'");
                echo "중복되는 예약이 있습니다.";
                exit;
            }
        }

        // sql문 실행 (INSERT)
        $sql = "INSERT INTO reservation (name, gender, service, requirement, date, time)
                VALUES ('$name', '$gender', '$service', '$requirement', '$date', '$time')";
        
        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 삽입 실패했을 경우
        // 예약에 실패했습니다. -> 예약 페이지 리다이렉션
        if (!$result) {
            header("Refresh: 2; URL='test.php'");
            echo "예약에 실패했습니다.";
            exit;
        } else {
        // 삽입 성공했을 경우
        // 예약에 성공했습니다. -> 예약 목록 페이지 리다이렉션
        header("Refresh: 2; URL='list.php'");
        echo "예약에 성공했습니다.";
        exit;
        }
    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>