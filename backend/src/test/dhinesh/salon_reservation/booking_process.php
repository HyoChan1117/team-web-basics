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
        
        // Execute query


    }catch(Exception $e){
        // db error message
        echo "DB error".$e;
    }
    // DB close
    $db_conn->close();

?>