<?php

    // Input Validation
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    // If the input is not valid
    // Redirect to the form.html page
    if (empty($name) || empty($title) || empty($content)) {
        header("Refresh: 2; URL='list.php'");
        echo "Invalid input, please try again.";
        exit;
    }

    try {
        // db address
        require_once "./db_config.php";

        // sql statement (INSERT)
        $sql = "INSERT INTO board (name, title, messageArea) 
                    VALUES ('$name', '$title', '$content')";

        // Run a query
        $result = $db_conn->query($sql);

        // display an error message
        if(!$result) {
            header("refresh: 2; URL= from.html");
            echo "fail to post";
            exit;
        }
        header("Refresh: 2; URL='list.php'");
        echo "Post is complete!";
        exit;

    } catch (Exception $e) {
        // DB error message
        echo "DB error".$e;
        exit;
    }

    // db close
    $db_conn->close();

?>