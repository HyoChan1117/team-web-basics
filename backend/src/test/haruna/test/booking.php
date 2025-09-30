<?php

    # DB연결 

    # designer선택할 때 출력하기 위해 select로 designer 잦기

    # 배열 안에 


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
            <input type="checkbox" name="service_name" value="CUT">CUT
            <input type="checkbox" name="service_name" value="perm">PERM
            <input type="checkbox" name="service_name" value="color">COLOR
            <br><br>
            REQUIREMENT<br>
            <textarea name="" id="" cols="30" rows="5"></textarea>
            <br><br>
            DESIGNER<br>
            <input type="radio" name="designer_id">하루나

        </form>


    </fieldset>

</body>

</html>