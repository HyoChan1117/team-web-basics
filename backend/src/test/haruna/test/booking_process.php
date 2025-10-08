<?php
    session_start();

    # 서비스 메뉴, 메시지, Day, time, 디지너ID의 값을 받는다 
    $service_id = isset($_POST['service_id']) ? $_POST['service_id'] : '';
    $requirement = isset($_POST['requirement']) ? $_POST['requirement'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $designer_id = isset($_POST['designer_id']) ? intval($_POST['designer_id']) : '';
     
    
    # 유호성 확인
    if ($service_id == '' || $requirement == '' || $designer_id == '' ||
        $time == '' || $date == '') {
        header("Refresh: 2; URL='booking.php'");
        echo "잘 못한 접근입니다.";
        exit;
    }
    
    # implode => 배열을 문자열으로 바꾸는 함수
    $service_ids = implode(",", $service_id);

        
    try {
        # DB연결
        require_once("./db_connect.php");

        # Reservation Table에 INSERT하기
        $rsv_sql = "INSERT INTO Reservation (client_id, designer_id, date, start_at, end_at, status, requirement) 
                    VALUES('$_SESSION[user_id]', '$designer_id', '$date', '$time', '10:00', 'pending', '$requirement' )";
        $rsv_query = $db_conn->query($rsv_sql);
        # 직전 INSERT의 AUTO_INCREMENT 취특하기
        $rsv_id = $db_conn->insert_id;


        # 선택된 service의 내용(메뉴 이름, 가격)을 가져 오기
        $service_serach = "SELECT service_name, price FROM Service WHERE service_id IN ($service_ids)";
        $service_serach_query = $db_conn->query($service_serach);
        
        while($row = $service_serach_query->fetch_assoc())

        # ReservationService 테이블에 INSERT
        $sql = "INSERT INTO ReservationService (reservation_id, service_id, qty, unit_price) 
                SELECT $rsv_id, s.service_id, 1, s.price FROM Service s 
                WHERE s.service_id IN ($service_ids)"; 
        # query문 
        $query = $db_conn->query($sql);

        # 성공하면 main로 가기
        header("Refresh: 2; URL='main.php'");
        echo "예약이 완료했습니다. ";


    } catch (Exception $e) {
        echo $e->getMessage();
    }
    $db_conn->close();

?>