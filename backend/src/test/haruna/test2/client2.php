
<?php
    try{
        require_once("./db_conn.php");
        # Reservation테이블에서 select로 $SESSION['user_id']의 예약 정보를 가져 오기
        $rv_sql = "SELECT
        r.reservation_id,
        r.`date`,
        r.start_at,
        r.end_at,
        (SELECT GROUP_CONCAT(s.service_name ORDER BY s.service_id SEPARATOR ', ')
           FROM Service s
           WHERE FIND_IN_SET(s.service_id, r.service)) AS service_names,
        r.requirement,
        u.user_name AS designer_name
      FROM Reservation r
      JOIN Users u ON u.user_id = r.designer_id
      WHERE r.client_id = $_SESSION[user_id]
      ORDER BY r.`date`, r.start_at
    ";
        $rv_result = $db_conn->query($rv_sql);
        $rv_row = $rv_result->fetch_assoc();
        

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
    <?php if($rv_result->num_rows === 0) :?>
        <fieldset>예약이 없습니다.</fieldset>
    <?php else:?>
        <table border="2">   
        <th>Day</th>
        <th>start_at</th>
        <th>end_at</th> 
        <th>Service</th>
        <th>requirement</th>
        <th>designer</th>     
        <tr>
            <td><?=$rv_row['date']?></td>
            <td><?=$rv_row['start_at']?></td>
            <td><?=$rv_row['end_at']?></td>
            <td><?=$rv_row['service_names']?></td>
            <td><?=$rv_row['requirement']?></td>
            <td><?=$rv_row['designer_name']?></td>    
        </tr>
        <?php endif; ?>
      
    </table>


</body>
</html>