<?php

    // 회원가입 페이지 리다이렉션 함수 정의
    function redirection($msg) {
        header("Refresh: 2; URL='register.php'");
        echo $msg;
        exit;
    }

    // 입력값 유효성 검사
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $account = isset($_POST['account']) ? $_POST['account'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $pw_check = isset($_POST['pw_check']) ? $_POST['pw_check'] : '';
    $birth = isset($_POST['birth']) ? $_POST['birth'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // 유효하지 않는 입력값이 넘어올 경우
    // 유효하지 않는 입력값입니다. -> 회원가입 페이지 리다이렉션
    if (empty($role) || empty($user_name) || empty($gender) || 
        empty($account) || empty($password) || empty($pw_check) || 
        empty($birth) || empty($phone)) {
        redirection("유효하지 않는 입력값입니다.");
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (SELECT)
        $sql_s = "SELECT account FROM Users WHERE account='$account'";

        // 쿼리 실행
        $result_s = $db_conn->query($sql_s);
        // 중복되는 아이디가 있을 경우
        // 중복되는 계정이 존재합니다. -> 회원가입 페이지 리다이렉션
        if ($result_s -> num_rows < 0) {
            redirection("중복되는 계정이 존재합니다.");
        }

        // 비밀번호가 일치하지 않을 경우
        // 비밀번호가 일치하지 않습니다. -> 회원가입 페이지 리다이렉션
        if ($password != $pw_check) {
            redirection("비밀번호가 일치하지 않습니다.");
        }

        // 비밀번호 해싱
        $pw_hash = password_hash($password, PASSWORD_DEFAULT);

        // sql문 작성 (INSERT)
        $sql_i = "INSERT INTO Users (role, user_name, gender, account, password, birth, phone)
                  VALUES ('$role', '$user_name', '$gender', '$account', '$pw_hash', '$birth', '$phone')";

        // 쿼리 실행
        $result_i = $db_conn->query($sql_i);

        // 회원가입에 실패했을 경우
        // 회원가입에 실패했습니다. -> 회원가입 페이지 리다이렉션
        if (!$result_i) {
            redirection("");
        }

        // 회원가입에 성공했을 경우
        // 회원가입에 성공했습니다. -> 로그인 페이지 리다이렉션
        header("Refresh: 2; URL='login.php'");
        echo "회원가입에 성공했습니다.";
        exit;

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>