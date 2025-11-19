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
        $sql = "SELECT * FROM Users WHERE account = '$account'";

        // sql query
        $result = $db_conn->query($sql);
 

        // if the result is invalid show a error message
        // else redirect to main page
        // next to the login start the session start
        // password verify
        if($result->num_rows <= 0){
            header("refresh: 2; URL= 'login.php'");
            echo "User not found";
            exit;
        }
        $row = $result->fetch_assoc(); 
        if(!password_verify($password, $row['password'])){
            header("refresh: 2; URL= 'login.php'");
            echo "Incorrect password.";
            exit;
        }
        session_start();
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['account'] = $row['account'];
        $_SESSION['role'] = $row['role'];

        header("refresh: 2; URL= 'main.php'");
        echo "Login successful!";
        exit;
        
        

    }catch(Exception $e){
        // DB error message
        echo "DB error".$e;
        exit;
    }
    // db close
    $db_conn->close();

?>