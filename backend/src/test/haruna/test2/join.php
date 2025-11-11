
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 가입</title>
</head>
<body>
    <h1>회원 가입</h1>
    <form action="join_process.php" method="post">
        <fieldset>
            <legend>회원 정보 입력</legend>
        <input type="radio" name="role" value="client">client        
        <input type="radio" name="role" value="designer">designer
        <input type="radio" name="role" value="manager">manager
        <hr>
        👤 Id <br>
        <input type="text" name="account" placeholder="id를 입력하세요."><br><br>
        ♧ Name<br>
        <input type="text" name="user_name" placeholder="이름을 입력하세요."><br><br>
        🗝 Password<br>
        <input type="password" name="password" placeholder="비밀 번호를 입력하세요."><br>
        <input type="password" name="password2" placeholder="비밀 번호를 재입력하세요.">
        <br><br>
        ☏ Phone Number<br>
        <input type="text" name="phone" placeholder="'-'없이 전화번호를 입력하세요."><br><br>
        🎂 Birthday<br>
        <input type="DATE" name="birth" value="<?= date("Y-m-d") ?>" ><br><br>
        🚻 gender <br>
        <input type="radio" name="gender" value="men">men🚹
        <input type="radio" name="gender" value="women">women🚺
        <br><br>
        <button>submit</button>
        </fieldset>
    </form>
    <a href="login.php">-login-</a>
</body>
</html>