
<?php
$date = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>BOOKING</h1>
    <fieldset>
        <form action="booking_process.php" method="post">
        GENDER<br>    
        남성<input type="radio" name="grnder" value="men">
        여성<input type="radio" name="grnder" value="women">
        <br><br>
        SERVICE
        <br>
        <input type="checkbox" name="service[]" value="cut">
        Cut <br>
        <input type="checkbox" name="service[]" value="parm">
        Parm <br>
        <input type="checkbox" name="service[]" value="color">
        Color
        <br><br>
        요구 사항<br>
        <textarea name="requirement" cols="60" rows="5"></textarea>
        <br><br>
        <input type="date" name="date" value="<?= $date ?>">
        

        </form>
    </fieldset>
</body>
</html>