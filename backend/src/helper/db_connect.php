<?php

    // 데이터베이스 연결
    $hostname = 'db';
    $username = 'root';
    $password = 'root';
    $database = 'helper';

    $db_conn = new mysqli($hostname, $username, $password, $database);

?>