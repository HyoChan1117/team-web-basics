<?php
    # news_id, title, content, file 정보를 받는다
    $news_id = isset($_GET['news_id']) ? intval($_GET['news_id']) : '' ;
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    if ($news_id == '' || $title == '' || $content == '') {
        header("Refresh: 2; URL='news_modify.php?news_id=$news_id'");
        echo "잘못한 접근입니다.";
        exit;
    }

    try {
        # DB 연결
        require_once("./db_conn.php");
        $sql = "UPDATE News SET 
                title = '$title', content = '$content' ,updated_at = NOW()
                WHERE news_id='$news_id'";
        $resul = $db_conn->query($sql);

        header("Refresh: 2; URL='news_modify.php?news_id=$news_id");
        echo "수종 완료했습니다.";
        exit;

    } catch (Throwable $e) {
        error_log($e->getMessage());
        echo "서버 오류 발생". $e->getMessage();
    }
    $db_conn->close();


?>