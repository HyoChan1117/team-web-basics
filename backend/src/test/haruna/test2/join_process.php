<?php
    # 입력 정보를 POST로 받기
    $account = isset($_POST['account']) ? trim($_POST['account']) :'';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $birth = isset($_POST['birth']) ? $_POST['birth'] : '';

    # 유호성 확인
    # 잘못된 접근은 오류 표시하고 join.php로 돌아 가기
    if ($account == '' || $password == '' || $name == '' || 
            $gender == '' || $role == '' || $birth == '') {
        header("Refresh: 2; URL='join.php'");
        echo '잘못한 접근입니다';
        exit;
    }

    try {
    # DB 연결하기
    require_once("./db_conn.php");

    # pw hash 저리
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);

    # Usertable에 INSERT하기
    $sql = "INSERT INTO Users (account, password, name, gender, role, phone, birth) 
                VALUES ('$account','$pw_hash','$name','$gender','$role','$phone', '$birth')";
    $result = $db_conn->query($sql);

    # SESSION에 이름, role, account, 정보 저장하기
    $_SESSION['name'] = $name;
    $_SESSION['account'] = $account;
    $_SESSION['role'] = $role;

    # 성공하면 login으로 이동하기
    header("Refresh: 2; URL='login.php'");
    
    } catch(Throwable $e) {
        echo "서버 오류 발생".$e;
    } 

    


?>