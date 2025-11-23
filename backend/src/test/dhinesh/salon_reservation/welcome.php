<?php
    // session start
    session_start();

    // create a session variable
    $session_name = $_SESSION['user_name'];
    $session_account = $_SESSION['account'];

    $roles = [
        "client",
        "designer",
        "manager"
    ];

    $session_role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <div class="account">
        Welcome, <?="$session_name $session_role"."!" ?>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
