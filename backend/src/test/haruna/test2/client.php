<?php
    try{
        require_once("./db_conn.php");
        # Reservation테이블에서 select로 $SESSION['user_id']의 예약 정보를 가져 오기
        $rv_sql = "SELECT * FROM Reservation WHERE client_id = '$_SESSION[user_id]'";
        $rv_result = $db_conn->query($rv_sql);
        $rv_row = $rv_result->fetch_assoc();

        # Users에서 designer_id를 사용해서 디자이너 이름 가져오기
        $dr_sql = "SELECT user_name FROM Users WHERE user_id = '$rv_row[designer_id]'";
        $dr_result = $db_conn->query($dr_sql);
        $dr_row = $dr_result->fetch_assoc();
  
        # ReservationService에서 reservation_id를 사용해서 내용을 가져오기
        $rv_sv_sql = "SELECT * FROM ReservationService WHERE reservation_id = '$rv_row[reservation_id]'";
        $rv_sv_result = $db_conn->query($rv_sv_sql);
        $rv_sv_row = $rv_sv_result->fetch_assoc();

        # Service에서 service_id를 사용해서 내용을 가져오기
        $sv_sql = "SELECT * FROM Service WHERE service_id = '$rv_sv_row[service_id]'";
        $sv_result = $db_conn->query($sv_sql);
        

    } catch (Exception $e) {
        echo "서버 오류".$e->getMessage();
    }
    $db_conn->close();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    나의 예약 정보
    <?php if($rv_result->num_rows <= 0) :?>
        <fieldset>예약이 없습니다.</fieldset>
    <?php else:?>
        <table border="2">   
        <th>Day</th>
        <th>Time</th>
        <th>Service</th>
        <th>requirement</th>
        <th>designer</th>     
        <tr>
            <td><?=$rv_row['date']?></td>
            <td><?=$rv_row['start_at']?></td>
            <td><?php while($sv_row = $sv_result->fetch_assoc()):?>
                <?= $sv_row['service_name'] ?>
                <?php endwhile;?></td>
            <td><?=$rv_row['requirement']?></td>
            <td><?=$dr_row['user_name']?></td>    
        </tr>
        <?php endif; ?>
      
    </table>


</body>
</html>