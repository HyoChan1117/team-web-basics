<?php
    session_start();
    try {
        require_once("./db_conn.php");

        $sql = "SELECT * FROM Designer WHERE user_id = '$_SESSION[user_id]'";
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

    } catch (Throwable $e) {
        error_log($e->getMessage());
        echo "서버 오류".$e->getMessage();
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
</head>
<body>
    <h1>Staff > modify</h1>
    <hr>

    <fieldset>
        <form action="staff_modify_process.php" method="post">
        <?= $_SESSION['user_name']?><br>
        <?=$row['experience']?>년<br>
        <input type="text" name="good_at" value="<?=$row['good_at']?>" required><br>
        <input type="text" name="personality" value="<?=$row['personality']?>" required><br>
        <textarea name="message" cols="50" rows="4" required><?=$row['message']?></textarea><br>
        <?=$row['created_at']?><br>
        <?=$row['updated_at']?><br>
        <button>submit</button>
        </form>
    </fieldset>
    <br>
    <a href="staff.php">--back--</a>
</body>
</html>