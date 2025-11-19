<?php
    // db config
    $hostname = 'db';
    $username = 'root';
    $pass_wrd = 'root';
    $database = 'reservation';

    // db connect
    $db_conn = new mysqli($hostname, $username, $pass_wrd, $database);   

?>