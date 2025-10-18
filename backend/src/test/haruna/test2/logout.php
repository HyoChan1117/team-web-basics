<?php
  session_start();
  
  $_SESSION = [];

  if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(), "", time() - 42000 ,
    $params['path'], $params['secure'], 
    $params['httponly'], $params['domain']);
  }
  
  session_destroy();

  header("Refresh: 2; URL='login.php'");
  echo "로그아웃중";


?>