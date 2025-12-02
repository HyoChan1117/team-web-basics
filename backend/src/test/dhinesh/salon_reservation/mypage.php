<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Refresh: 2; URL='login.php'");
    echo "Please login first.";
    exit;
}

$role = $_SESSION['role'];

if ($role === "client") {
    header("Location: client_mp.php");
    exit;

} elseif ($role === "designer") {
    header("Location: designer_mp.php");
    exit;

} elseif ($role === "manager") {
    header("Location: manager_mp.php");
    exit;

} else {
    echo "Invalid role.";
    exit;
}
?>
