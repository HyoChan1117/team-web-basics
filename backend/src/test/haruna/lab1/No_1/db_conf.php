<?php

class db_info {
    const DB_HOST = 'db';
    const DB_USER = 'root';
    const DB_PASSWORD = 'root';
    const DB_NAME = 'level_up';
}


$db_conn = new mysqli(
    db_info::DB_HOST,
    db_info::DB_USER,
    db_info::DB_PASSWORD,
    db_info::DB_NAME,
);
// 에러 처리
if ($db_conn->connect_errno) {
    echo "DB 연결 오류";
    exit;
}


?>