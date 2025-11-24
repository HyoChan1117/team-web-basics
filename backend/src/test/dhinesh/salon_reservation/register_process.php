<?php
    // input validation
    $role = isset($_POST['role']) ? $_POST['role']: '';
    $user_name = isset($_POST['user_name']) ? $_POST['user_name']: '';
    $gender = isset($_POST['gender']) ? $_POST['gender']: '';
    $birth = isset($_POST['birth']) ? $_POST['birth']: '';
    $account =isset($_POST['account']) ? $_POST['account']: '';
    $password = isset($_POST['password']) ? $_POST['password']: '';
    $pass_valid = isset($_POST['pass_valid']) ? $_POST['pass_valid']: '';
    $phone = isset($_POST['phone']) ? $_POST['phone']: '';

    // if the input is empty redirect to register page
    if(empty($role) || empty($user_name) || empty($gender) || 
        empty($birth) || empty($account) || empty($password) || 
        empty($pass_valid) || empty($phone)) {
            header("refresh: 2; URL= 'register.php'");
            echo "Invalid Input";
            exit;
    }

    // password check
    if($password != $pass_valid){
        header("refresh:2 ; URL= 'register.php'");
        echo "Password do not match";
        exit;
    }    
    
    try{

        // db address
        require_once "./db_config.php";

        // sql statement for exists account
        $exists_sql = "SELECT * FROM Users WHERE account = '$account'";

        $exists_result = $db_conn->query($exists_sql);

        if($exists_result -> num_rows > 0){
            header("refresh: 2; URL= 'register.php'");
            echo "Duplicate ID";
            exit;
        }
        // password hasing
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // sql statement for new account 
        $sql_insert = "INSERT INTO Users(role, user_name, gender, birth, account, password, phone) 
                        VALUES ('$role', '$user_name', '$gender', '$birth', '$account', '$password_hash', '$phone')";

        $result = $db_conn->query($sql_insert);
        
        // If the result is invalid redirect to register page
        // else display an success message
        if(!$result){
            header("refresh: 2; URL= 'register.php'");
            echo "Fail to submit";
            exit;
        }else{
            header("refresh: 2; URL= 'login.php'");
            echo "Sign-up complete.";
            exit;
        }
        

    }catch(Exception $e){
        // error message
        echo "DB Error".$e;
    }
    // db close
    $db_conn->close();

?>