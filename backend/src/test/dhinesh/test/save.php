<?php

    // get the user input
    $name = isset($_POST['name']) ? $_POST['name']: '';
    $messageArea = isset($_POST['messageArea']) ? $_POST['messageArea']: '';

    // validate the user input
    if(empty($name) || empty($messageArea)){
        header ("refresh:2 ; URL= 'form.html'");
        echo "fail to submit";
        exit;
    }

    try{
        // db address
        require_once "./db_config.php";

        // sql statement
        $sql = "INSERT INTO guestbook (name, messageArea) VALUES ('$name', '$messageArea')";

        // Run query
        $result = $db_conn->query($sql);

        // show error message
        if(!$result){
            header("refresh: 2; URL= form.html");
            echo "no post available";
            exit;
        }
        header("refresh: 2; URL= list.php");
        echo "successfully submitted";
        exit;

    }catch(Exception $e){
        // db error message
        echo "DB error".$e;
    }
    // close db
    $db_conn->close();

?>