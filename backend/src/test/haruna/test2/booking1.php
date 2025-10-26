<?php
    $times = ["09:00","09:30","10:00","10:30","11:00","11:30", "12:00", 
                "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30",
                "16:00", "16:30", "17:00", "17:30", "18:00"];

    try{
        # DB연결하기
        require_once("./db_conn.php");
        # service 내용을 가져 오기
        $sv_check = "SELECT * FROM Service";
        $sv_result = $db_conn->query($sv_check);
        
        # User테이블에서 designer의 이름, user_id 정보를 가져 오기
        $dr_check = "SELECT user_id, user_name FROM Users WHERE role = 'designer'";
        $dr_result = $db_conn->query($dr_check);

    } catch (Throwable $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo "DB오류 발생". $e;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKING</title>
</head>
<body>  
    <h1>BOOKING</h1>
    <!--예약 정보 입력 받기-->
    <!--service, designer, day, time, requirement-->
    <fieldset>
        <form action="booking_process1.php" method="post">
        ✂ Service <br>
        <?php while ($sv_row = $sv_result->fetch_assoc()):?>
            <input type="checkbox" name="service_id[]" value="<?= $sv_row['service_id']?>"><?=$sv_row['service_name'] ?>        
            ₩ <?= $sv_row['price']?>
            <br>
            <?php endwhile; ?>
        <br>
        👤 designer<br>
        <?php while ($dr_row = $dr_result->fetch_assoc()): ?>
            <input type="radio" name="designer_id" value="<?= $dr_row['user_id']?>"><?=$dr_row['user_name'] ?>        
        <?php endwhile; ?>
        <br><br>
        📅 day<br>
        <input type="date" name="date" value="<?= date("Y-m-d") ?>" required>
        <br><br>
        🕘 time<br>
        <select name="time">
            <?php foreach($times as $t): ?>
                <option value="<?=$t?>"><?=$t?></option>          
            <?php endforeach; ?>
        </select>
        <br><br>
        📋 requirement
        <br>
        <textarea name="requirement" cols="50" rows="5" ></textarea>
        <br><br>
        <button>confirm</button>
        </form>
    </fieldset>
    <a href="mypage.php">--Mypage--</a>
</body>
</html>