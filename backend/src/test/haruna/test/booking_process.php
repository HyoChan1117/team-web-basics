<?php

    # 메뉴 가격을 리스트에 저장
    $price_list = [
        'cut' => 4500,
        'perm' => 8000,
        'color' => 6000
    ];

    $money_result = [];

    # 서비스 메뉴, 메시지, Day, time, 디지너ID의 값을 받는다 
    $service_name = isset($_POST['service_name']) ? $_POST['service_name'] : '';
    $requirement = isset($_POST['requirement']) ? $_POST['requirement'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $designer_id = isset($_POST['designer_id']) ? intval($_POST['designer_id']) : '';
     

    # 유호성 확인
    if ($service_name == '' || $requirement == '' || $designer_id == '' ||
        $time == '' || $date == '') {
        header("Refresh: 2; URL='booking.php'");
        echo "잘 못한 접근입니다.";
        exit;
    }

    # 서비스를 배열 형태로 받기
    $service_names = implode(", ", $service_name);

    # service_name배열에 있는 메뉴와 price_list랑 비교해서 service_name에 있는 
    # 메뉴 가격을 money_result에 추가 
    foreach($service_name as $value){
        if(isset($price_list[$value])){
            $money_result[$value] = $price_list[$value];
        }
    }    
        
    try {
        # DB연결
        require_once("./db_connect.php");

        # Service Table에 INSERT


        # Reservation테이블에 INSERT
        $sql = "INSERT INTO Reservation (designer_id, ) VALUES ()";

        # query문 

        # 성공하면 mypage로 가기


    } catch (Exception $e) {
        echo $e->getMessage();
    }

    // echo $service_names.' '.$requirement.' '.$designer_id;



?>