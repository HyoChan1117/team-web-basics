<?php

    // get id value through GET method
    $getId = isset($_GET['id']) ? $_GET['id']: '';

    // get the id value validation 
    if(empty($getId)){
        header("refresh: 2; URL= 'list.php'");
        echo "No id";
        exit;
    }

    try{
        // db address
        require_once "./db_config.php";

        // sql statement
        $sql = "SELECT * FROM guestbook WHERE id='$getId'";

        // sql query
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();
    }catch(Exception $e){
        // db error
        echo "db error".$e;
    }
    // db close
    $db_conn->close();
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Book</title>
</head>
<body>
    
</body>
</html>