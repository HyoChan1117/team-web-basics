<?php

    // get the user input
    $name = isset($_POST['Name']) ? ($_POST['Name']): '';
    $messageArea = isset($_POST['messageArea']) ? ($_POST['messageArea']): '';

    // validate the input
    if(empty($name) || empty($messageArea)) {
        header("refresh: 2; URL='form.php'");
        echo "invalid input please try again";
        exit;
    }

    try{
        // db connect
        require_once "./db_config.php";

        // sql statement
        $sql = "INSERT INTO guestbook(name, messageArea) VALUES('$name', '$messageArea')";

        // Run query
        $result = $db_conn->query($sql);

        // display the error message for submit
        if(!$result) {
            header("refresh: 2; URL='form.php'");
            echo "fail to submit";
            exit;

        }
        header("refresh: 2; URL= 'list.php'");
        echo "successfully submitted";
        exit;

    }catch(Exception $e) {
        // db error message
        echo "DB ERROR".$e;
    }
    // db close
    $db_conn->close();

?>