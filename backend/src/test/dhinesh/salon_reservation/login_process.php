<?php
    // validate the user input
    $role = isset($_POST['role']) ? $_POST['role']: '';
    $account = isset($_POST['account']) ? $_POST['account']: '';
    $password = isset($_POST['password']) ? $_POST['password']: '';

    // if the input is empty display a error message
    if(empty($role) || empty($account) || empty($password)){
        header ("refresh: 2; URL= 'login.php'");
        echo "Enter your ID and password";
        exit;
    }

    try{

        // connect to database
        require_once "./db_config.php";

        // sql statement
        $sql = "SELECT * FROM Users WHERE role= '$role' and account= '$account'";

        // sql query
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc(); 

        // if the result is invalid show a error message
        // else redirect to main page
        // next to the login start the session start
        // password verify
        if($result->num_rows <= 0){
            header("refresh: 2; URL= 'login.php'");
            echo "User not found";
            exit;
        }

        if(!password_verify($password, $row['password'])){
            header("refresh: 2; URL= 'login.php'");
            echo "Incorrect password.";
            exit;
        }else{
            session_start();
            header("refresh: 2; URL= 'main.php'");

            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['account'] = $row['account'];
            $_SESSION['role'] = $row['role'];
        }

    }catch(Exception $e){
        // DB error message
        echo "DB error".$e;
    }
    // db close
    $db_conn->close();

?>