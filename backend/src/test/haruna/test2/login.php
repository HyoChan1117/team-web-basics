<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <h1>login</h1>
    <form action="login_process.php" method="post">
        <fieldset>
            <legend>로그인 정보</legend>
            <input type="radio" name="role" value="client">client        
            <input type="radio" name="role" value="designer">designer
            <input type="radio" name="role" value="manager">manager
            <hr>
            👤 Id <br>
            <input type="text" name="account"><br>
            🗝 Password<br>
            <input type="password" name="password">
            <br>
            <button>send</button>
        </fieldset>
    </form>
</body>
</html>