<?php
    // get the POSTID
    $postID = isset($_GET['postID']) ? $_GET['postID']: '';

    // if the postID is invalid -> redirect to list page
    if(empty($postID)){
        header("refresh: 2; URL= 'list.php'");
        echo "Invalid input";
        exit;
    }

    try{
        // db address
        require_once "./db_config.php";

        // sql statement (SELECT)
        $sql = "SELECT * FROM board WHERE postID= '$postID'";

        // Run a query
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        // comment Sql statement
        $commentSql = "SELECT * FROM comment WHERE postID= '$postID' ORDER BY commentID DESC";

        // Run a comment query
        $commentResult = $db_conn->query($commentSql);

    }catch(Exception $e){
        // db error
        echo "DB error".$e;
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
    <h3>Post List < post</h3>
    <fieldset>
        <strong>Author : </strong><?= $row['name'] ?><br>
        <strong>Date : </strong><?= $row['created_at'] ?><br>
        <hr>
        <strong>Title : </strong><?= $row['title'] ?><br>
        <strong>Content : </strong><?= $row['messageArea'] ?><br>

    </fieldset>
    <!-- create a delete button-->
    <button onclick="location.href= 'delete.php?postID=<?= $postID?>'">Delete</button>
    <a href="list.php">Go Back</a>
    <hr>

    <h3>comment</h3>
    <form action="review.php?postID=<?= $postID ?>" method= "post">
    <fieldset>
        Name : <input type="text" name= "name" placeholder= "Enter your Name">
        password : <input type="password" name= "password" placeholder= "Enter your Password"><br><br>
        <textarea name="messageArea" cols="30" rows="10" placeholder= "Write your content"></textarea><br>
        <button>submit</button>
    </fieldset>
    </form>
    <br>
    <?php
        // if the input is valid display error message
        if($commentResult->num_rows <= 0){
            echo "no comment";
        }else{
            while($commentRow = $commentResult->fetch_assoc()){
                echo "<strong>$commentRow[name]</strong> ($commentRow[created_at])<br>";
                echo "$commentRow[messageArea]";
                echo "<hr>";
            }
        }
    ?>
</body>
</html>