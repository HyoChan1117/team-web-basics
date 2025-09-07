<?php

    // inside the error handling
    try{

        // db address
        require_once "./db_config.php";

        // sql statement
        $sql = "SELECT * FROM guestbook ORDER BY id DESC";

        // Run query
        $result = $db_conn->query($sql);


    }catch(Exception $e){
        // db error message
        echo "DB error" .$e;
    }
    // DB CLOSE
    $db_conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Book List</title>
</head>
<body>
    <h2>Guest Book List</h2>

<!-- create a table tag -->
<table border="2">
    <tr>
        <td>id</td>
        <td>Author</td>
        <td>content</td>
        <td>created_at</td>
    </tr>
    <?php
        // if the result was valid show the post
        // show the error message
        if($result->num_rows <=0){
            echo "No post available";
        } else{
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>$row[id]</td>";
                echo "<td>$row[name]</td>";
                echo "<td>$row[messageArea]</td>";
                echo "<td>$row[created_at]</td>";
                echo "</tr>";

            }
        }
    
    ?>
</table>
    <!--create a button-->
    <a href="form.html">write</a>
</body>
</html>
