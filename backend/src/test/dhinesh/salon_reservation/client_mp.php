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

    // set the page limit
    $limit = 3;

    $page = isset($_GET['page'])? $_GET['page']: '1';

    // set the offset
    $offset = ($page - 1) * $limit;

    $view = isset($_GET['view'])? $_GET['view']: "current";

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
                WHERE u1.account = '$session_account'
                AND r.status IN ('pending','approved')
                ORDER BY r.date, r.start_at
                LIMIT $limit OFFSET $offset
                ";

        $sql_history = "SELECT 
                        r.*,
                        u1.user_name AS client_name,
                        u2.user_name AS designer_name
                        FROM Reservation AS r
                        JOIN Users AS u1
                            ON r.client_id=u1.user_id
                        JOIN Users AS u2
                            ON r.designer_id=u2.user_id
                        WHERE u1.account = '$session_account' 
                        AND r.status IN ('completed','cancelled')
                        ORDER BY r.date DESC, r.start_at DESC
                        LIMIT $limit OFFSET $offset";
        
        // Execute query
        $result = $db_conn->query($sql);

        // Execute history query
        $result_history = $db_conn->query($sql_history);

        // count total rows for pagination
        $sql_count = "SELECT COUNT(*)AS total
                      FROM Reservation AS r
                      JOIN Users AS u1
                         ON r.client_id = u1.user_id
                      WHERE u1.account = '$session_account'
                      AND r.status IN ('pending', 'approved')
                      ";

        $total_result = $db_conn->query($sql_count);
        $total_row = ($total_result->fetch_assoc());
        $total_page = ceil($total_row['total'] / $limit);
        
        $sql_count_history = "SELECT COUNT(*)AS total
                      FROM Reservation AS r
                      JOIN Users AS u1
                         ON r.client_id = u1.user_id
                      WHERE u1.account = '$session_account'
                      AND r.status IN ('completed','cancelled')
                      ";

        $total_result_history = $db_conn->query($sql_count_history);
        $count_history = $total_result_history->fetch_assoc();
        $total_history_page = ceil($count_history['total'] / $limit);


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
    <form method="get" action="client_mp.php">
        <button name="view" value="current" <?= $view=="current" ?>>
        Current Reservation
        </button>
    </form>

    <?php if($view == "current"): ?>
        
        <h3>Current Reservation</h3>

    <table border= "2">
        <tr>
            
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
    $count = $offset + 0;

    // Process and validate client data. 
    // On success: output reservation details.
    // On failure: display an error message to the user.
    if($result-> num_rows <= 0){
        echo "No Reservations";
    }else{
        while($row = $result->fetch_assoc()){
            $count++;

            echo "<tr>";
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
<?php
    // pagination
    for ($i = 1; $i <= $total_page; $i++){
        if($i == $page){
            echo "<strong>$i</strong> ";
        }else{
            echo "<a href= 'client_mp.php?page=$i&view=current'>$i</a> ";
        }
    }
?><br><br>

<form method="get" action="client_mp.php">
    <button name="view" value="history" <? $view=="history"?>>
        History Reservation
        </button>
</form>

<?php elseif ($view == "history"): ?>

    <h3>History</h3>

<table border="2">
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
        $count = $offset + 0;

        if($result_history->num_rows <= 0) {
            echo "<tr><td colspan='9'>No History</td></tr>";
        }
        while($row = $result_history->fetch_assoc()){
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
    
    ?>

</table>
<?php 
    for ($i = 1; $i <= $total_history_page; $i++) {
        if($i == $page)
            echo "<strong>$i</strong> ";
    }
    echo "<a href= 'client_mp.php?page=$i&view=history'>$i</a> ";
?>

<?php endif; ?>

</body>
</html>