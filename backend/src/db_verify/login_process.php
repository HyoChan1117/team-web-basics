<?php

    // 로그인 페이지 리다이렉션 함수 정의
    function redirection($msg) {
        header("Refresh: 2; URL='login.php'");
        echo $msg;
        exit;
    }

    // 입력값 유효성 검사
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $account = isset($_POST['account']) ? $_POST['account'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 유효하지 않는 입력값을 받았을 경우
    // 유효하지 않는 입력값입니다. -> 로그인 페이지 리다이렉션
    if (empty($role) || empty($account) || empty($password)) {
        redirection("유효하지 않는 입력값입니다.");
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 실행 (SELECT)
        $sql = "SELECT * FROM Users WHERE role='$role' and account='$account'";

        // 쿼리 실행
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        // 예외 처리
        // 선택한 사용자 역할에 해당 계정이 없을 경우
        // 존재하는 사용자 정보가 없습니다. -> 로그인 페이지 리다이렉션
        if ($result->num_rows <= 0) {
            redirection("존재하는 사용자 정보가 없습니다.");
        }

        // 비밀번호가 일치하지 않을 경우
        // 비밀번호가 일치하지 않습니다. -> 로그인 페이지 리다이렉션
        if (!password_verify($password, $row['password'])) {
            redirection("비밀번호가 일치하지 않습니다.");
        }

        // 로그인에 성공했을 경우
        // 로그인 성공 -> 메인 페이지 리다이렉션
        // 세션 시작
        session_start();

        header("Refresh: 2; URL='main.php'");
        echo "로그인 성공!";
        
        // 세션 변수 저장
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['account'] = $row['account'];
        $_SESSION['role'] = $row['role'];

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>