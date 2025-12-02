<?php
    require_once "./welcome.php";

    require_once "./helper.php";

    require_once "./menu.php";

    try {
        // connect DB
        require_once "./db_config.php";

        // sql statement
        $sql = "SELECT * FROM Service";

        // Execute query
        $result = $db_conn->query($sql);
    }catch(Exception $e){
        // DB error 
        echo "DB error".$e;
    }
    // DB close
    $db_conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>service</title>
</head>
<body>
    <h3>service</h3>
    <table border="2">
        <tr>
            <th>Service Name</th>
            <th>Price</th>
        </tr>
        <?php 
            while($row = $result->fetch_assoc()){
                echo "<tr>";
            echo "<td>$row[service_name]</td>";
            echo "<td>$row[price]</td>";
            echo "</tr>";
            }
        ?>

    </table>
</body>
</html>