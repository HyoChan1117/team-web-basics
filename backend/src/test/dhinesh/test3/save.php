<?php

    // get user input
    $name = isset($_POST['Name']) ? $_POST['Name']: '';
    $messageArea = isset($_POST['messageArea']) ? $_POST['messageArea']: '';
    
    // validation user input
    if(empty($name) || empty($messageArea)){
        header("refresh: 2; URL='form.html'");
        echo "Invaild input, please try again";
        exit;
    }

    try{
        // db address
        require_once "./db_config.php";

        // sql statement
        $sql = "INSERT INTO guestbook (name, messageArea) VALUES ('$name', '$messageArea')";
        
        // run a query
        $result = $db_conn->query($sql);

        // check the user input or display an error message
        if(!$result) {
            header("refresh: 2; URL='form.html'");
            echo "Fail to submit";
            exit;
        }
        header("refresh: 2; URL='list.php'");
        echo "successfully submitted";
        exit;

    }catch(Exception $e){
        // db error message
        echo "db error".$e;
    }
    // db close
    $db_conn->close();

?>

