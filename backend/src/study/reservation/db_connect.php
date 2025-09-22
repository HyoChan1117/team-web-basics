<?php

// 데이터베이스 연결
$hostname = "db";
$username = "root";
$password = "root";
$database = "simple_reservation";

$db_conn = new mysqli($hostname, $username, $password, $database);

// 한글/이모지 대응
$db_conn->set_charset("utf8mb4");

?>
