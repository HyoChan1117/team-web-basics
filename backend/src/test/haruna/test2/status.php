<?php

    $reservation_id = isset($_POST['reservation_id']) ? $_POST['reservation_id'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if ($reservation_id == '' || $status == '') {
        header("Refresh: 2; URL='mypage.php'");
        echo "잘못한 접근입니다";
        exit();
    }

    try{
        require_once("./db_conn.php");

        $sql = "UPDATE Reservation 
                SET status = '$status', updated_at = NOW(),
                cancelled_at = CASE WHEN '$status' = 'no_show' THEN NOW()
                                    ELSE cancelled_at
                                END
                WHERE reservation_id='$reservation_id'";
        $result = $db_conn->query($sql);

        header("Location: mypage.php");
        exit;
    } catch(Exception $e){
        echo "서버 오류 발생". $e->getMessage() ."";
        exit();
    }


?>