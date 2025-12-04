<?php
// login info
require_once "./welcome.php";

// get the user permission 
require_once "./helper.php";

// menu
require_once "./menu.php";

// check the login and role
if(!user_permission($_SESSION['role'], 'designer')){
    echo "Access denied. Designer only";
    exit;
}

// get the designer account
$designer_account = $_SESSION['account'];

// set the page limit
$limit = 5;

// GET the page query
$page = isset($_GET['page'])? $_GET['page']: '1';

// set the offset
$offset = ($page - 1) * $limit;

try {
    // Connect the DB
    require "./db_config.php";

    // ---------------------------------------------------
    // 1) LOAD DESIGNER PROFILE USING ACCOUNT
    // ---------------------------------------------------
    $sql_profile = "
        SELECT d.*, u.user_name
        FROM Designer AS d
        JOIN Users AS u ON d.user_id = u.user_id
        WHERE u.account = '$designer_account'
    ";

    $result_profile = $db_conn->query($sql_profile);
    $designer_info = $result_profile->fetch_assoc();

    if (!$designer_info) {
        echo "<h3>No Designer Profile Found</h3>";
        exit;
    }

    // ---------------------------------------------------
    // 2) LOAD HISTORY RESERVATION
    // ---------------------------------------------------
    $sql = "
        SELECT r.*, 
               u.user_name AS client_name,
               d.user_name AS designer_name,
               (
                    SELECT GROUP_CONCAT(s.service_name SEPARATOR ', ')
                    FROM Service AS s
                    WHERE FIND_IN_SET(s.service_id, r.service)
               ) AS service_name
        FROM Reservation AS r
        JOIN Users AS u ON r.client_id = u.user_id
        JOIN Users AS d ON r.designer_id = d.user_id
        WHERE r.status IN ('completed', 'cancelled')
        AND d.user_id = '{$designer_info['user_id']}'
        ORDER BY r.date, r.start_at
        LIMIT $limit OFFSET $offset
    ";

    $result = $db_conn->query($sql);

    // pagination count
    $sql_count = "
        SELECT COUNT(*) AS total
        FROM Reservation AS r
        JOIN Users AS d ON r.designer_id = d.user_id
        WHERE r.status IN ('completed','cancelled')
        AND d.user_id = '{$designer_info['user_id']}'
    ";

    $total = $db_conn->query($sql_count)->fetch_assoc()['total'];
    $total_page = ceil($total / $limit);

} catch (Exception $e) {
    echo "DB error ".$e;
}

$db_conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Designer My Page</title>
</head>
<body>

<h3>My Profile</h3>

<table border="2">
    <tr>
        <th>Name</th>
        <th>Experience</th>
        <th>Good At</th>
        <th>Personality</th>
        <th>Message</th>
    </tr>
    <tr>
        <td><?= $designer_info['user_name']; ?></td>
        <td><?= $designer_info['experience']; ?> years</td>
        <td><?= $designer_info['good_at']; ?></td>
        <td><?= $designer_info['personality']; ?></td>
        <td><?= $designer_info['message']; ?></td>
    </tr>
</table>
<?php if ($_SESSION['role'] == 'designer'): ?>
    <br>
    <a href="designer_modify.php"><button>Modify Profile</button></a>
<?php endif; ?>


<hr>

<h3>History Reservation</h3>

<table border="2">
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Designer</th>
        <th>Service</th>
        <th>Requirement</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Status</th>
    </tr>

<?php
$count = $offset;

if ($result->num_rows <= 0) {
    echo "<tr><td colspan='9'>No History</td></tr>";
}

while ($row = $result->fetch_assoc()) {
    $count++;
    echo "<tr>";
    echo "<td>$count</td>";
    echo "<td>{$row['client_name']}</td>";
    echo "<td>{$row['designer_name']}</td>";
    echo "<td>{$row['service_name']}</td>";
    echo "<td>{$row['requirement']}</td>";
    echo "<td>{$row['date']}</td>";
    echo "<td>{$row['start_at']}</td>";
    echo "<td>{$row['end_at']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "</tr>";
}
?>
</table>

<br>

<?php
// pagination
for ($i = 1; $i <= $total_page; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> ";
    } else {
        echo "<a href='designer_mp.php?page=$i'>$i</a> ";
    }
}
?>

</body>
</html>
