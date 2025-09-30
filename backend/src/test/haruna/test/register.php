<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 가입</title>
</head>
<body>
    <h1>회원 가입</h1>
    <fieldset>
    <form action="register_prosess.php" method="post">
            아이디<br>
            <input type="text" name="account"><br><br>
            사용자 <br>
            <input type="radio" name="role" value="client">client
            <input type="radio" name="role" value="designer">designer
            <input type="radio" name="role" value="manager">manager
            <br><br>
            이름<br>
            <input type="text" name="name"><br><br>
            비밀 번호<br>
            <input type="password" name="password" placeholder="비밀 번호를 입력하세요"><br>
            <input type="password" name="password_check" placeholder="비밀 번호를 재입력하세요"><br><br>
            전화 번호<br>
            <input type="text" name="phone"><br><br>
            생일 월일<br>
            <input type="date" name="birth"><br><br>
            성별:<input type="radio" name="gender" value="men">남 
                <input type="radio" name="gender" value="women">여
            <br><br>
            <button>가입하기</button>
    </form>
    </fieldset>

    
</body>
</html>