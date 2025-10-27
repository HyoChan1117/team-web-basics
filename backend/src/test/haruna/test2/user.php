<?php
    
    $session_account = $_SESSION['account'];
    $session_name = $_SESSION['user_name'];
    $session_role = $_SESSION['role'];

    $msg = "안녕하세요! 환영합니다!";
    if ($session_role == 'designer') {
        echo $msg.$session_name."(".$session_account.")"."디자이너님! ";
    }elseif($session_role == 'manager'){
        echo $msg.$session_name."(".$session_account.")"."매니저님! ";    
    }else{
        echo $msg.$session_name."(".$session_account.")"."님! ";    
    }
        
?>