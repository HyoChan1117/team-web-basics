<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>

<body>
    <h1>로그인</h1>
    <fieldset>
        <form action="login_prosecc.php" method="post">
            사용자<br>
            <input type="radio" name="role" value="client">client
            <input type="radio" name="role" value="designer">designer
            <input type="radio" name="role" value="manager">manager
            <br><br>
            아이디<input type="text" name="account"><br>
            비밀 번호<input type="password" name="password">
            <br>
            <button>로그인</button>
        </form>
    </fieldset>
    <a href="register.php">회원가입 하기</a>
</body>

</html>