<?php
    # 선택된 서비스 메뉴, 메시지, Day, time, 디지너ID의 값을 받아서 출력
    $service_id = isset($_POST['service_id']) ? $_POST['service_id'] : '';
    $requirement = isset($_POST['requirement']) ? $_POST['requirement'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $designer_id = isset($_POST['designer_id']) ? intval($_POST['designer_id']) : '';

    $service_ids = implode(',' , $service_id);

    try{
        # DB 연결
        require_once("./db_connect.php");
        
        # servicetable 잠조하고 menu, 가격, total가격을 블어 오기 & 계산
        $sql = "SELECT service_name, price FROM Service 
                WHERE service_id IN ($service_ids)";
        $result = $db_conn->query($sql);

        $price = "SELECT IFNULL(SUM(price), 0) AS total FROM Service 
                    WHERE service_id IN ($service_ids)";
        $price_result = $db_conn->query($price);
        $sum_row = $price_result->fetch_assoc();
        $total = $sum_row['total'];

        # designer이름을 블어 오기
        $designer = "SELECT name FROM Users WHERE user_id = '$designer_id'";
        $designer_result = $db_conn->query($designer);
        $dr = $designer_result->fetch_assoc();

    } catch (Exception $e) {
        echo "". $e->getMessage() ."";
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>예약 확인</title>
</head>
<body>
    <h1>예약 확인</h1>
    <hr>
        < menu >
        <br>
        <?php while ($row = $result->fetch_assoc()):?>
            <?=$row['service_name']?>￥ <?=$row['price']?>
            <br>
        <?php endwhile; ?>
            <strong>￥ <?= $total ?></strong>
        <br>
        <br>< day ><br>
        <?=$date?>
        <br><br>
        < time ><br>
        <?=$time?>
        <br><br>
        < requirement ><br>
        <?php if(!isset($requirement)): ?>
            없음
        <?php else: ?>
            <?= $requirement ?>
        <?php endif; ?>
        <br><br>
        < designer ><br>
        <?= $dr['name'] ?><br>
        <br><hr>
     <!-- 예약 확인 버튼 누르면 예약 완료  -->
    <form action="booking_process.php" method="post">
        <?php foreach ($service_id as $service): ?>
            <input type="hidden" name="service_id[]" value="<?=$service?>">
        <?php endforeach; ?>
        <input type="hidden" name="requirement" value="<?=$requirement?>">
        <input type="hidden" name="date" value="<?=$date?>">
        <input type="hidden" name="time" value="<?=$time?>">
        <input type="hidden" name="designer_id" value="<?=$designer_id?>">
        <button>확인</button>
    </form>
</body>
</html>