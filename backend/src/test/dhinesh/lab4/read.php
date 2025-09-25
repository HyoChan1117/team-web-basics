<?php

    // Validate postID
    $postID = isset($_GET['postID']) ? $_GET['postID'] : '';

    // If postID is invalid
    // Show error -> redirect to post list
    if (empty($postID)) {
        header("Refresh: 2; URL='list.php'");
        echo "Invalid Input.";
        exit;
    }

    try {
        // Connect to database
        require_once "./db_config.php";

        // Get the post (SELECT)
        $sql = "SELECT * FROM board WHERE postID='$postID'";

        // Execute query
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        // Get comments (SELECT)
        $commentSql = "SELECT * FROM comment WHERE postID='$postID' ORDER BY commentID DESC";

        // Execute query
        $commentResult = $db_conn->query($commentSql);

    } catch (Exception $e) {
        // Database error
        echo "DB error".$e;
        exit;
    }

    // Close database
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
    
    <h1>Post List < Post</h1>

    <fieldset>
        <strong>Author: </strong><?= $row['name'] ?> <br>
        <strong>Date: </strong><?= $row['created_at'] ?> <br>
        <hr>
        <strong>Title: </strong><?= $row['title'] ?> <br>
        <strong>Content: </strong><?= $row['messageArea'] ?>
    </fieldset>

    <button onclick="location.href='delete.php?postID=<?= $postID ?>'">Delete</button>

    <hr>
    
    <a href="list.php">Go Back</a>

    <h3>Comment</h3>
    <form action="review.php?postID=<?= $postID ?>" method="post">
        <fieldset>
            Name: <input type="text" name="name" placeholder="Enter your name">
            Password: <input type="password" name="password" placeholder="Enter your password"><br>
            <br>
            <textarea name="messageArea" rows="5" cols="60" placeholder="Write your comment"></textarea><br>
            <button>Submit</button>
            <input type="reset" value="Reset">
        </fieldset>
    </form>
    <br>
    <?php

        // If no comments
        if ($commentResult->num_rows <= 0) {
            echo "No comments.";
        } else {   // If there are comments
            while ($commentRow = $commentResult->fetch_assoc()) {
                echo "<strong>$commentRow[name]</strong> ($commentRow[created_at])<br>";
                echo "└ $commentRow[messageArea]";
                echo "<hr>";
            }
        }

    ?>
</body>
</html>
