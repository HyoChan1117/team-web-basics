<?php

    // Receice the input values and validate 
    $client = isset($_POST['client'])? $_POST['client']: '';
    $service = isset($_POST['service'])? $_POST['service']: '';
    $requirement = isset($_POST['requirement'])? $_POST['requirement']: '';
    $designer = isset($_POST['designer'])? $_POST['designer']: '';
    $date = isset($_POST['date'])? $_POST['date']: '';
    $start_at = isset($_POST['start_at'])? $_POST['start_at']: '';

    // check the empty values
    if(empty($client) || empty($service) || empty($requirement) || empty($designer) || empty($date) || empty($start_at)){
        header("refresh: 2; URL= 'booking.php'");
        echo "Invalid Input";
        exit;
    }

    // change the array value into string
    $service = implode(",", $service);

    try{

        // DB connect
        require_once "./db_config.php";

        // sql statement
        $sql_off = "SELECT * FROM Timeoff 
                    WHERE '$date' BETWEEN start_at AND end_at 
                    AND designer_id = 'designer_id'";

        $sql_resv = "SELECT * FROM Reservation
                    WHERE designer_id = '$designer'
                    AND start_at <= '$start_at'
                    AND end_at < '$start_at'
                    AND status != 'cancelled'";

        $sql_inst = "INSERT INTO Reservation (client_id, designer_id, Service, requirement, date, start_at, end_at, status) 
                    VALUES ('$client', '$designer', '$service', '$requirement', '$date', '$start_at', '$start_at', 'pending')";
        
        
        // Execute query
        $result_off = $db_conn->query($sql_off);
        $result_resv = $db_conn->query($sql_resv);
        $result_inst = $db_conn->query($sql_inst);

        // create a default no reservation on sunday -> redirect to booking.php
        $holiday = 0;
        $resv_weekday = date('w', strtotime($date));

        // execute the result 
        if($result_off->num_rows > 0)
            header("refresh: 2; URL= 'booking.php'");
            echo "Designer unavailable";
            exit;

        if($holiday == $resv_weekday);
            header("refresh: 2; URL= 'booking.php'");
            echo "Every week sunday is Holiday";
            exit;

        if(!$result_inst){
            header("refresh: 2; ULR= 'booking.php'");
            echo "Reservation Failed";
            exit;
        }

    }catch(Exception $e){
        // db error message
        echo "DB error".$e;
    }
    // DB close
    $db_conn->close();

?>