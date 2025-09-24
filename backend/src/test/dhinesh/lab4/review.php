<?php

    // Validate postID
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';

    // Validate input values
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $messageArea = isset($_POST['messageArea']) ? $_POST['messageArea'] : '';

    // If postID or inputs are invalid
    // Show error -> redirect to post list
    if (empty($postID) || empty($name) || empty($password) || empty($messageArea)) {
        header("Refresh: 2; URL='list.php'");
        echo "Invalid access.";
        exit;
    }

    try {
        // Connect to database
        require_once "./db_config.php";

        // Hash the password
        $pw_hash = password_hash($password, PASSWORD_DEFAULT);

        // Write SQL statement (INSERT)
        $sql = "INSERT INTO comment (postID, name, password, messageArea) VALUES (
               '$postID', '$name', '$pw_hash', '$messageArea')";

        // Execute query
        $result = $db_conn->query($sql);

        // If comment was added successfully
        // Redirect to the post page
        header("Location: read.php?postID=$postID");

    } catch (Exception $e) {
        // Database error
        echo "DB error".$e;
    }

    // db close
    $db_conn->close();

?>
