<?php

    require_once "./header.php";
    require_once "./helper.php";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        if (users_permission($_SESSION['role'], "client")) {
            echo "hi";
        }
    ?>
</body>
</html>