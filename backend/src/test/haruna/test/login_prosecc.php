<?php
    function redirect($msg, $file){
        header("Refresh: 2; URL='$file.php'");
        echo "$msg";
    }

    # account, pw, role받기
    $account = isset($_POST['account']) ? $_POST['account'] : '';
    $pw = isset($_POST['password']) ? trim($_POST['password']) : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    # 유호성을 확인
    if ($account == '' || $pw == '' || $role == '') {
        redirect("잘 못한 접근 입니다.","login");
        exit;
    }

    try{
        # DB연결
        require_once("./db_connect.php");

        # SELECT문으로 정보 가져 오기
        # 받는 account랑 role가 DB에 있는지 확인
        $sql = "SELECT * FROM Users WHERE account = '$account' AND role = '$role'";

        # 쿼리 실행
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();

        # num_rows로 0보다 작다 -> 해당 ID 없음 
        # 해당 ID 없음 -> login.php로 돌아가기
        if ($result->num_rows <= 0) {
            redirect("해당ID가 없습니다.", "login");
            exit;
        } 
           
        # 해당 ID 있으면 pw가 맞는지 확인
        # pw 맞다 -> 예약 페이지로 이동하기
        if (password_verify($pw, $row['password'])){
            redirect("로그인 성공!", "main");
            ;
            exit;
        }else{  
        # pw 안맞다 -> 오류 표시하고 login.php로 돌아가기
            redirect("비밀 번호가 들렸습니다.", "login");
            exit;      
        }

    } catch (Exception $e) {
        echo"DB오류 발생". $e;
    }

    $db_conn->close();

?>