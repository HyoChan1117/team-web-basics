<?php

    // 페이지 리다이렉션 함수 불러오기
    require_once "./redirection.php";

    // 입력값 유효성 검사
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $account = isset($_POST['account']) ? $_POST['account'] : '';
    $pw = isset($_POST['pw']) ? $_POST['pw'] : '';

    // 유효하지 않는 입력값일 경우
    // 유효하지 않는 입력값입니다. -> 로그인 페이지 리다이렉션
    if (empty($role) || empty($account) || empty($pw)) {
        redirection('login.php', '로그인 페이지로 돌아갑니다.');
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // sql문 작성 (SELECT)
        $sql = "SELECT * FROM users WHERE role='$role' AND account='$account'";

        // 쿼리 실행
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        // 예외 처리
        // 사용자 정보가 없을 경우
        // 사용자 정보가 없습니다. -> 로그인 페이지 리다이렉션
        if ($result->num_rows <= 0) {
            redirection("login.php", "사용자 정보가 없습니다.");
        }

        // 비밀번호가 틀렸을 경우
        // 비밀번호가 틀렸습니다. -> 로그인 페이지 리다이렉션
        if ($row['pw'] != $pw) {
            redirection("login.php", "비밀번호가 틀렸습니다.");
        }

        // 세션 시작
        session_start();

        // 세션 변수 저장
        $_SESSION['role'] = $row['role'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['account'] = $row['account'];

        // 로그인 성공했을 경우
        // 로그인 성공! -> main.php 페이지 리다이렉션
        redirection("main.php", "로그인 성공!");

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생".$e;
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>