<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>sign Up</h2>

    <form action="register_process.php" method= "post">
    <fieldset>
        <label for="user">User Type :</label>
        <input type="radio" id="client" name="role" value="client">
        <label for="client">client</label>
        <input type="radio" id="designer" name="role" value="designer">
        <label for="designer">designer</label>
        <input type="radio" id="manager" name="role" value="manager">
        <label for="manager">manager</label><br><br>

        <label for="name">Name :</label>
        <input type="text" name="user_name" placeholder="Enter your name"><br><br>


        <label for="gender">Gender :</label>
        <input type="radio" name="gender" id="man" value="male">
        <label for="man">male</label>
        <input type="radio" name="gender" id="woman" value="female">
        <label for="woman">female</label><br><br>

        <label for="dob">DOB :</label>
        <input type="date" name="birth" placeholder="DD-MM-YYYY" required><br><br>

        <label for="account">Account :</label>
        <input type="text" name="account" placeholder="Enter you Account" required><br><br>
        
        <label for="password">Password :</label>
        <input type="password" name="password" placeholder="Enter your password" required>
        
        <input type="password" name="pass_valid" id="pass_valid" placeholder="Re-enter password" required><br><br>
        

        <label for="mobile">Mobile Number :</label>
        <input type="tel" name="phone" id="mobile" placeholder="Enter your Mobile Number" required><br><br>

        <button>sign Up</button>
        <input type="reset" value="Reset">
    </fieldset>
    </form>
    <a href="login.php">Already have an account</a>
</body>
</html>