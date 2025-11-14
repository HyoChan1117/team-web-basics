<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form action="login_process.php" method= 'POST'>
        <fieldset>
        <h2>Kimhadii salon</h2>
        <label for="user">User :</label>
        <input type="radio" id="client" name="role" value="client">
        <label for="client">client</label>
        <input type="radio" id="designer" name="role" value="designer">
        <label for="designer">designer</label>
        
        <hr>

        <input type="text" name="account" placeholder="Username" style="display:block; margin-bottom:12px; padding:8px;">
        <input type="password" name="password" placeholder="Password" style="display:block; padding:8px;"><br>

        <button>login</button>

        <a href="find_id.php">Find ID</a>
        <a href="find_pwd.php">Find password</a><br><br>

        <a href="register.php">sign Up</a>

        </fieldset>
    </form>
</body>
</html>