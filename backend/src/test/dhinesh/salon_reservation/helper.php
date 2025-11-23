<?php

    // validate_permission
    function user_permission($current_user, $needed_user) {
        return $current_user === $needed_user;
    }

?>