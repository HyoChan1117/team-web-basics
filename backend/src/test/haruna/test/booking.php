<?php

    try{
        # DB연결
        require_once("./db_connect.php");

        # designer선택할 때 출력하기 위해 select로 designer 잦기
        $sql = "SELECT user_id, name FROM Users WHERE role='designer'";
        $result = $db_conn->query($sql);

        # service Table 정보 가져 오기
        $service_sql = "SELECT * FROM Service";
        $service_query = $db_conn->query($service_sql);
    
    } catch(Exception $e){
        echo ''.$e->getMessage().'';
    }

    // DB 종료
    $db_conn->close();

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
        <form action="booking_check.php" method="post">
            SERVICE<br>
            <?php if($service_query && $service_query->num_rows > 0): ?>
                <?php while ($sr = $service_query->fetch_assoc()):?>
                    <input type="checkbox" name="service_id[]" value="<?=$sr['service_id']?>">
                    <?= $sr['service_name'] ?>￥<?= $sr['price'] ?>
                    <br>
                    <?php endwhile; ?>
            <?php endif; ?>
            <br>
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
            <button>확인</button>
        </form>
    </fieldset>

    <a href="main.php"><button>main</button></a>

</body>

</html>