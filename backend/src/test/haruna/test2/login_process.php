<?php
    session_start();
    # account, password, role를 받음
    $account = isset($_POST['account']) ? trim($_POST['account']) : '' ;
    $password = isset($_POST['password']) ? trim($_POST['password']) : '' ;
    $role = isset($_POST['role']) ? trim($_POST['role']) : '' ;

    # 유호성 확인
    if ($account == '' || $password == '' || $role == '') {
        header("Refresh: 2; URL='login.php'");
        echo "잘못한 접근입니다.";
        exit;
    }

    try{
        # DB연결
        require_once("./db_conn.php");

        # Users테이블 가져와서 role 초회, account 존재 여부를 확인
        $check_sql = "SELECT * FROM Users WHERE role='$role' AND account='$account'";
        $check_result = $db_conn->query($check_sql);
        $row = $check_result->fetch_assoc();

        # 없으면 login.php로 돌아 가기
        if ($check_result -> num_rows == 0) {
            header("Refresh: 2; URL='login.php'");
            echo "ID가 존재하지 않습니다. ";
            exit;
        }

        # account 있으면 password 확인
        # password 맞으면 SESSION에 account, role, 이름을 저장
        if(password_verify( $password, $row['password'])){
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['account'] = $row['account'];
            $_SESSION['role'] = $row['role'];
            
            # mypage로 이동하기
            header("Refresh: 2; URL='mypage.php'");
            echo "로그인 성공했습니다. Mypage로 이동합니다.";
            exit;
        } else {
            header("Refresh: 2; URL='logn.php'");
            echo "비밀 번호가 틀렸습니다.";
            exit;
        }

    } catch (Exception $e) {
        echo "서버 오류가 발생했습니다." . $e;
    }
?>