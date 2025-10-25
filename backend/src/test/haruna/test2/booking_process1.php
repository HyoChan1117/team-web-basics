<?php
    session_start();
    # service_id, designer_id, day, time, requirement 의 값을 받는다.
    $service_id = $_POST['service_id'] ?? null ;
    $designer_id = isset($_POST['designer_id']) ? $_POST['designer_id'] : '' ;
    $date = isset($_POST['date']) ? $_POST['date'] : '' ;
    $time = isset($_POST['time']) ? $_POST['time'] : '' ;
    $requirement = isset($_POST['requirement']) ? $_POST['requirement'] : '' ;
    
    # 유호성 확인
    if(!is_array($service_id) || count($service_id) === 0 ||
        $designer_id == '' || $date == '' || $time == '' ) {
        header("Refresh: 2; URL='booking.php'");
        echo "잘못한 접근입니다.";
        exit;
    }
    
    # service_id를 
    $service_ids = implode(",",$service_id);

    try {
        # DB연결 하기
        require_once("./db_conn.php");

        # Reservation테이블을 불어와서 date, time의 중복 여부를 확인
        
        
        # data & time이 중복이 없으면 Reservation테이블에 INSERT 하기  
        $rv_sql = "INSERT INTO Reservation
                    (client_id, designer_id, service, requirement, date, start_at, end_at)
                    SELECT '$_SESSION[user_id]', '$designer_id', '$service_ids', '$requirement', 
                    '$date', '$time',ADDTIME('{$time}', SEC_TO_TIME(SUM(s.duration_min*60)))
                    FROM Service s
                    WHERE s.service_id IN ($service_ids)";
        $rv_result = $db_conn->query($rv_sql);
        
        # Reservation의 최신 reservation_id를 가져오
        $rv_id = $db_conn->insert_id; 

        # Service 테이블 price를 가져 오면서 ReservationService 테이블에 
        # reservation_id, service_id, service_price 를 INSERT하기
        // $rv_sv_sql = "INSERT INTO ReservationService (reservation_id, service_id, qty, unit_price )
        //                 SELECT $rv_id , s.service_id ,1 , s.price FROM Service s 
        //                 WHERE service_id IN ($service_ids)";
        // $rv_sv_result = $db_conn->query($rv_sv_sql);

        # 성공하면 mypage로 가기
        header("Refresh: 2; URL='mypage.php'");
        echo "예약이 완료됐습니다!";
        exit;

    } catch (Exception $e) {
        echo "DB오류 발생".$e;
    }
    $db_conn->close();
    

?>