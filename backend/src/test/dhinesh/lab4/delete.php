<?php

    // Validate postID value
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';

    // If postID is invalid
    // Invalid access -> Redirect to post list
    if (empty($postID)) {
        header("Refresh: 2; URL='list.php'");
        echo "Invalid access.";
        exit;
    }

    try {
        // Connect to database
        require_once "./db_config.php";

        // Write SQL (DELETE)
        $sql = "DELETE FROM board WHERE postID='$postID'";

        // Execute query
        $result = $db_conn->query($sql);

        // If deletion is successful
        // Success message -> Redirect to post list
        header("Refresh: 2; URL='list.php'");
        echo "Delete successful!";
        exit;

    } catch (Exception $e) {
        // Database error
        echo "DB error".$e;
        exit;
    }

    // db close
    $db_conn->close();

?>
