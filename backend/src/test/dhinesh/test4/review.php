<?php
    // get the postID
    $postID = isset($_GET['postID']) ? $_GET['postID']: '';

    // post the name, password, content
    $name = isset($_POST['name']) ? $_POST['name']: '';
    $password = isset($_POST['password']) ? $_POST['password']: '';
    $content = isset($_POST['messageArea']) ? $_POST['messageArea']: '';

    // validate the user input
    if(empty($name) || empty($password) || empty($content)){
        header("refresh: 2; URL= 'list.php'");
        echo "Invalid input";
        exit;
    }

    try{
        // db address
        require_once "./db_config.php";

        // password hashing
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        // sql statement
        $sql = "INSERT INTO comment(postID, name, password, messageArea)
                    VALUES ('$postID', '$name', '$pass_hash', '$content')";
        // Run query
        $result = $db_conn->query($sql);

        // if the input is show an error message
        // Redirect to the list.php page.
        header("location: read.php?postID=$postID");
        
    }catch(Exception$e){
        // db error
        echo "db error".$e;
    }
    // db close
    $db_conn->close();

?>
