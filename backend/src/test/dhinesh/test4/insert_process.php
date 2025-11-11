<?php
    // input validation
    $name = isset($_POST['name']) ? $_POST['name']: '';
    $title = isset($_POST['title']) ? $_POST['title']: '';
    $content = isset($_POST['messageArea']) ? $_POST['messageArea']: '';
    
    // if the is invalid redirect to the form.html page
    if(empty($name) || empty($title) || empty($content)){
        header("refresh: 2; URL='list.php'");
        echo "Invaild input";
        exit;
    }
    try{
        // db address
        require_once "./db_config.php";

        // sql statement
        $sql = "INSERT INTO board (name, title, messageArea) 
                    VALUES('$name', '$title', '$content')";

        // run a query
        $result = $db_conn->query($sql);
        
        // if the result was correct go to the list.php
        // Or display an error message
        if(!$result){
            header("refresh: 2; URL='form.html'");
            echo"Fail to submit the post";
            exit;
        }else{
            header("refresh: 2; URL= list.php");
            echo "successfully submitted";
            exit;
        }

    }catch(Exception $e){
        // db error message
        echo "DB error".$e;
    }
    // db close
    $db_conn->close();



?>