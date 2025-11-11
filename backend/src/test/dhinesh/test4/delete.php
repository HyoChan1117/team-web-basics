<?php
    $postID = isset($_GET['postID']) ? $_GET['postID']: '';

    if (empty($postID)){
        header("Refresh: 2; URL= list.php");
        echo "Invaild input";
        exit;
    }

    try{
        // db address
        require_once "./db_config.php";

        // sql statement (DELETE)
        $sql = "DELETE FROM board WHERE postID= '$postID'";

        // Run a query
        $result = $db_conn->query($sql);

        // if the post was deleted show an message
        header("refresh: 2; URL= list.php");
        echo "Post deleted!";
        exit;

    }catch(Exception $e){
        // db error message
        echo "DB error".$e;
        exit;
    }
    // db close
    $db_conn->close();

?>