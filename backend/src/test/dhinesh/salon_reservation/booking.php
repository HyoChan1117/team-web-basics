<?php
    // create the time
    $time = ["09.00", "09.30", "10.00", "10.30", "11.00", "11.30",
            "12.00", "12.30", "13.00", "13.30", "14.00", "14.30", 
            "15.00", "15.30","16.00", "16.30", "17.00", "17.30", "18.00"];

    $date = date("D-M-Y");

    // getting the login info and user permission
    require_once "./welcome.php";
    require_once "./helper.php";


    try{

        // db connect
        require_once "./db_config.php";

        // sql statement
        $sql_off = "SELECT 
                    t.*,
                    u.user_name AS designer_name
                    FROM Timeoff as t
                    JOIN Users AS u ON t.designer_id = u.user_id";

        $sql_resv = "SELECT 
                     r.*, 
                     u1.user_name AS client_name,
                     u2.user_name AS designer_name
                     FROM Reservation as r 
                     JOIN Users AS u1 ON r.client_id = u1.user_id
                     JOIN Users AS u2 ON r.designer_id = u2.user_id
                     ORDER BY date, start_at";

        $sql_client = "SELECT user_id FROM Users WHERE account= '$session_account'";
        $sql_designer = "SELECT user_id, user_name FROM Users WHERE role= 'designer'";

        $sql_svr = "SELECT * FROM Service";

        // Execute query
        $result_off = $db_conn->query($sql_off);
        $result_resv = $db_conn->query($sql_resv);
        $result_client = $db_conn->query($sql_client);
        $result_designer = $db_conn->query($sql_designer);
        $result_svr = $db_conn->query($sql_svr);

        // fetch client row
        $row_client = $result_client->fetch_assoc();

    }catch(Exception $e){
        // DB error message
        echo "DB Error".$e;
    }
    // db close
    $db_conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
</head>
<body>
    <h2>Booking</h2>
<form action="booking_process.php" method= "post">
    <table border= 2>
        <tr>
            <th>ID</th>
            <th>designer_name</th>
            <th>Service</th>
            <th>Requirement</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
        </tr>

        <?php
            $count = 1;

            if($result_resv->num_rows <= 0){
                echo "<tr><td colspan='8'>No Reservation</td></tr>";
            }else{
                while($row = $result_resv->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>$count</td>";
                    echo "<td>$row[designer_name]</td>";
                    echo "<td>$row[Service]</td>";
                    echo "<td>$row[requirment]</td>";
                    echo "<td>$row[date]</td>";
                    echo "<td>$row[start_at]</td>";
                    echo "<td>$row[end_at]</td>";
                    echo "<td>$row[status]</td>";
                    echo "</tr>";

                    $count++;
                }
            }

        ?>
    </table><br>


    <h3>Designer Unavailable (Every Sunday)</h3>
    <table border= 1>
        <tr>
            <th>ID</th>
            <th>designer_name</th>
            <th>start_at</th>
            <th>end_at</th>
        </tr>
        <?php
        $count_off = 1;
        
        if($result_off->num_rows <= 0){
            echo "<tr><td colspan='5'>No designer off-day found</td></tr>";
        }else{
            while($row = $result_off->fetch_assoc()){
                echo "<tr>";
                echo "<td>$count_off</td>";
                echo "<td>$row[designer_name]</td>";
                echo "<td>$row[start_at]</td>";
                echo "<td>$row[end_at]</td>";
                echo "</tr>";

                $count_off++;
            }
        }
        
        ?>
    </table>

    <br>

    <?php if (user_permission($_SESSION['role'], "client")):; ?>
    <form action="booking_process.php" method= "post">
        <input type="hidden" name="client" value= "<?= $row_client['user_id'] ?> ">
        <fieldset>
            <legend>Enter Reservation Information</legend>
            <?php while ($row = $result_svr->fetch_assoc()): ?>
            <input type="checkbox" name="service[]" value="<?= $row['service_name'] ?>"> <?= $row['service_name'] ?>
            <?php endwhile; ?><br><br>

            <textarea name="requirement" cols="30" rows="5" placeholder= "Write Your Requirment"></textarea>

            <p><strong>DESIGNER</strong></p>
            <?php while ($row = $result_designer->fetch_assoc()): ?>
            <input type="radio" name="designer" value="<?= $row['user_id'] ?>"> <?= $row['user_name'] ?>
            <?php endwhile; ?>

            <p><strong>TIME</strong></p>
            <input type="date" name="date" value="<?= $date ?>">
            <select name="start_at">
                <?php
                    foreach ($time as $t) {
                        echo "<option value='$t'>$t</option>";
                    }
                ?>
            </select><br><br>

            <button>Reserve</button>
            <input type="reset" value="Reset">


        </fieldset>
    </form>
</form>
<?php endif; ?>
</body>
</html>