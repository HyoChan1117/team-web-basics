<?php

    try{
        # DB연결 하기
        require_once("./db_conn.php");

        # $_SESSION['user_id']를 사용해서 Reservation에 있는 자신의 고객 예약 상황을 검색
        $sql = "SELECT 
                r.*,
                u.user_name AS client_name
                FROM Reservation AS r
                JOIN Users AS u
                ON r.client_id = u.user_id
                WHERE r.designer_id='$_SESSION[user_id]'";
        $result = $db_conn->query($sql);
 
    } catch(Exception $e){
        echo "DB오류 발생".$e->getMessage();
    }
    $db_conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>designer</title>
</head>
<body>
    고객 예약 상황
    <br>
    <?php if($result->num_rows <= 0): ?>
        <fieldset>
        예약이 없습니다.
        </fieldset>
    <?php else:?>
                                           
    <?php $count = 1 ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <table border="2">
            <th>예약번호</th>
            <th>고객 이름</th>
            <th>메뉴</th>
            <th>day</th>
            <th>start_at</th>
            <th>end_at</th>
            <th>멘트</th>
            <th>status</th>
            <th>cancelled_at</th>
            <th>cancel_reason</th>
            <th>created_at</th>
            <th>updated_at</th>  
        <tr>
        <td><?= $count?></td>
        <?php $count += 1?>
        <td><?= $row['client_name'] ?></td>
        <td><?= $row['service'] ?></td>
        <td><?= $row['date'] ?></td>
        <td><?= $row['start_at'] ?></td>
        <td><?= $row['end_at'] ?></td>
        <td><?= $row['requirement'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['cancelled_at'] ?></td>
        <td><?= $row['cancel_reason'] ?></td>
        <td><?= $row['created_at'] ?></td>
        <td><?= $row['updated_at'] ?></td>
        </tr>     
        </table>
            status
            <form action="status.php" method="post">
            <input type="hidden" name="reservation_id" value="<?=$row['reservation_id']?>">
            <select name="status">
            <option value="checked_in">checked_in</option>
            <option value="completed">completed</option>
            <option value="no_show">no_show</option>
            </select>
            <button>submit</button>
            <hr>
            <br>
    <?php endwhile; ?>
    <?php endif; ?>
    </form>

 
</body>
</html>