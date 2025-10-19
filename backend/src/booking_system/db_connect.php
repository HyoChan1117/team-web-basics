<?php

    // 데이터베이스 연결
    $hostname = "db";
    $username = "root";
    $pw = "root";
    $database = "backend";

    $db_conn = new mysqli($hostname, $username, $pw, $database);
    
?>