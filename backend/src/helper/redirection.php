<?php

    // 페이지 리다이렉션 함수 정의
    function redirection($file, $msg) {
        header("Refresh: 2; URL='$file'");
        echo $msg;
        exit;
    }

?>