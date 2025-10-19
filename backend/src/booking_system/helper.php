<?php

    // 사용자 권한 허가 함수 정의
    function users_permission($current_user, $needed_user) {
        return $current_user === $needed_user;
    }
    
?>