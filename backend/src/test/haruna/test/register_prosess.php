<?php

    # account, pw, name, gender, role, phone, birth, 정보 받기
    $account = isset($_POST['account']) ? trim($_POST['account']) : '';
    $pw = isset($_POST['password']) ? trim($_POST['password']) : '';
    $pw_check = isset($_POST['password_check']) ? trim($_POST['password_check']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $birth = isset($_POST['birth']) ? $_POST['birth'] : '';
    
    # 유호성 확인
    if ($account == '' || $pw == '' || $pw_check == '' || $name == '' || $gender == '' || 
        $phone == '' || $role == '' || $birth == '') {
            header("Refresh: 2; URL='register.php'");
            echo "잘 못한 접근입니다.";
            exit;
    }

    try{

        # DB연결
        require_once("./db_connect.php");

        # select문으로 Users정보를 블어오기
        # ID중복 여부 확인
        $sql = "SELECT * FROM Users WHERE account='$account'";
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        # num_rows로 아이디 중복 여부 확인 (0 -> 중복 없습)
        # 중복이 되면 register.php로 돌아가기
        if ($result->num_rows > 0) {
            header("Refresh: 2; URL='register.php'");
            echo "중복되는 아이디 입니다.";
            exit;
        }

        # 중복이 없으면 
        # password 재입력이랑 맞는지 확인
        # 안 맞으면 register.php으로 돌아가기
        if ($pw != $pw_check) {
            header("Refresh: 2; URL='register.php'");
            echo "비밀번호가 맞지 않습니다.";
            exit;
        }
        
        # 맞으면 password_hush하기
        $pw_hash = password_hash($pw, PASSWORD_DEFAULT);

        # insert SQL문
        $insert_sql = "INSERT INTO Users (account, password, name, gender, role, phone, birth) 
                        VALUES ('$account', '$pw_hash', '$name', '$gender', '$role', '$phone', '$birth')";

        # 실행 쿼리
        $insert_query = $db_conn->query($insert_sql);

        header("Refresh: 2; URL='login.php'");
        echo "회원 가입 성공했습니다.";

    }catch(Exception $e){
        echo "DB오류 발생" . $e;
    }

    $db_conn->close();

?>