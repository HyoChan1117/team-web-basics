<?php

    // get the user input
    $name = isset($_POST['Name']) ? $_POST['Name']: '';
    $messageArea = isset($_POST['messageArea']) ? $_POST['messageArea']: '';

    // validate the input
    if(empty($name) || empty($messageArea)){
        header("refresh: 2; URL= 'form.html'");
        echo "Invaild input please try again";
        exit;
    }

    try{
        // db address
        require_once "./db_config.php";

        // sql statement
        $sql = "INSERT INTO board (name, messageArea) VALUES ('$name','$messageArea')";

        // run sql
        $result = $db_conn->query($sql);

        // display an error message
        if(!$result) {
            header("refresh: 2; URL= 'form.html'");
            echo "Fail to submit";
            exit;
        }
        header("refresh:2; URL= 'list.php'");
        echo "sucessfully submitted";
        exit;

    }catch(Exception $e) {
        // db error 
        echo "DB error".$e;
    }
    // db close
    $db_conn->close();
?>