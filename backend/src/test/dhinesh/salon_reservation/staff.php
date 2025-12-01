<?php
    require_once "./welcome.php";

    require_once "./helper.php";

    require_once "./menu.php";

try {
    // connect DB
    require_once "./db_config.php";
    
    // SQL statement
    $sql = "SELECT d.*,
                   u.user_name AS designer_name
            FROM Designer AS d
            JOIN Users AS u
               ON u.user_id = d.user_id";

    // Execute query
    $result = $db_conn->query($sql);

} catch (Exception $e) {
    echo "DB error" . $e;
}

// close DB
$db_conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
</head>
<body>
    <h3>Staff</h3>
    <hr>

    <table border="2">
        <tr>
            <th>Designer</th>
            <th>Experience</th>
            <th>Good At</th>
            <th>Personality</th>
            <th>Message</th>
        </tr>

        <?php
        // Show all designers
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>$row[designer_name]</td>";
            echo "<td>$row[experience]</td>";
            echo "<td>$row[good_at]</td>";
            echo "<td>$row[personality]</td>";
            echo "<td>$row[message]</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php if ($_SESSION['role'] == 'designer'): ?>
        <br>
        <a href="staff_modify.php"><button>Modify</button></a>
    <?php endif; ?>

</body>
</html>
