<?php

    try{
        # DB연결
        require_once("./db_connect.php");

        # designer선택할 때 출력하기 위해 select로 designer 잦기
        $sql = "SELECT user_id, name FROM Users WHERE role='designer'";
        $result = $db_conn->query($sql);
    
    } catch(Exception $e){
        echo ''.$e->getMessage().'';
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>예약 페이지</title>
</head>

<body>
    <h1>BOOKING</h1>
    <hr>
    <fieldset>
        <form action="booking_process.php" method="post">
            SERVICE<br>
            <input type="checkbox" name="service_name[]" value="cut">CUT
            <input type="checkbox" name="service_name[]" value="perm">PERM
            <input type="checkbox" name="service_name[]" value="color">COLOR
            <br><br>
            REQUIREMENT<br>
            <textarea name="requirement" cols="30" rows="5"></textarea>
            <br><br>
            DAY<br>
            <input type="date" name="date">
            <br><br>
            time<br>
            <select name="time">
                <?php for($i = 9 ;$i <= 18 ; $i++):?>
                    <option value="<?=$i?>:00"><?=$i?>:00</option>    
                <?php endfor; ?>
            </select>
            <br><br>
            DESIGNER<br>
            <?php while($row = $result->fetch_assoc()):?>
                    <input type="radio" name="designer_id" value="<?=$row['user_id']?>"><?=$row['name']?>            
            <?php endwhile;?>
            <br><br>
            <button>예약</button>
        </form>


    </fieldset>

</body>

</html>