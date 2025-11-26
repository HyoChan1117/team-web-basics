<?php

    // login info
    require_once "./welcome.php";

    // get the user permission function
    require_once "./helper.php";

    require_once "./menu.php";

    // check the login and role
    if(!user_permission($_SESSION['role'], 'client')){
        echo "Access denied. Client only";
        exit;
    }

    try{
        // connect DB
        require_once "./db_config.php";

        // show only the logged-in client's reservation
        $where = "WHERE u1.role='client' AND u1.account='$session_account'";

        // sql statememt
        $sql = "SELECT 
                r.*,
                u1.user_name AS client_name,
                u2.user_name AS designer_name
                FROM Reservation AS r
                JOIN Users AS u1
                    ON r.client_id=u1.user_id
                JOIN Users AS u2
                    ON r.designer_id=u2.user_id
                $where
                ORDER BY date, start_at
                ";
        
        // Execute query
        $result = $db_conn->query($sql);

    }catch(Exception $e){
        // DB error
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
    <title>My page</title>
</head>
<body>
    <h2>My Page</h2>

    <h3>My Appointments</h3>
    <table border= "2">
        <tr>
            <th>ID</th>
            <th>client</th>
            <th>Designer</th>
            <th>Service</th>
            <th>Requirement</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>status</th>
        </tr>
<?php
    $count = 0;

    // Process and validate client data. 
    // On success: output reservation details.
    // On failure: display an error message to the user.
    if($result-> num_rows <= 0){
        echo "No Reservations";
    }else{
        while($row = $result->fetch_assoc()){
            $count++;

            echo "<tr>";
            echo "<td>$count</td>";
            echo "<td>$row[client_name]</td>";
            echo "<td>$row[designer_name]</td>";
            echo "<td>$row[Service]</td>";
            echo "<td>$row[requirement]</td>";
            echo "<td>$row[date]</td>";
            echo "<td>$row[start_at]</td>";
            echo "<td>$row[end_at]</td>";
            echo "<td>$row[status]</td>";
            echo "</tr>";
        }
    }



?>
    </table>

</body>
</html>