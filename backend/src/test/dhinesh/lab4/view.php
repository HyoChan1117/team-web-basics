<?php

    // get id value through GET method
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';

    // validate id value
    if (empty($postID)) {
        header("Refresh: 2; URL='list.php'");
        echo "Invalid access.";
        exit;
    }

    try {
        // db connect
        require_once "./db_config.php";

        // sql statement
        $sql = "SELECT * FROM board WHERE postID='$postID'";

        // sql query
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

    } catch (Exception $e) {
        // db error
        echo "db error".$e;
        exit;
    }

    // db close
    $db_conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Post</title>
</head>
<body>
<?php
    if ($result->num_rows > 0) {
        echo "<strong>ID:</strong> " . $row['postID'] . "<br>";
        echo "<strong>Author:</strong> " . $row['name'] . "<br>";
        echo "<strong>Title:</strong> " . $row['title'] . "<br>";
        echo "<strong>Content:</strong> " . $row['messageArea'] . "<br>";
        echo "<strong>Date:</strong> " . $row['created_at'] . "<br>";
    } else {
        echo "Post not found.";
    }
?>
<br>
<a href="list.php">Back to List</a>
</body>
</html>
