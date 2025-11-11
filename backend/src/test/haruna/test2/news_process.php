<?php
      
    # title, content, file의 값을 받는다
    $title = isset($_POST['title']) ? $_POST['title'] :'';
    $content = isset($_POST['content']) ? $_POST['content'] :'';
    
 
    # file 데이터 받기
    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $storedPath = null;
    if(!empty($_FILES['file']['name'])){
        $name = time() . '_' . basename($_FILES['file']['name']);
        $dest = $uploadDir . '/' . $name;
        move_uploaded_file($_FILES['file']['tmp_name'], $dest);
        $storedPath = './uploads/' . $name;
    }

    try {
        # DB 연결
        require_once('./db_conn.php');

        $fileEsc = $storedPath ? ($db_conn->real_escape_string($storedPath)) : "NULL";
        $sql = "INSERT INTO News (title, content, file) VALUES ('$title','$content','$fileEsc')";
        $result = $db_conn->query($sql);

        header("Refresh: 2; URL='news.php'");
        echo "기사 올리기 성공!";

    } catch (Throwable $e) {
        error_log($e->getMessage());
        echo $e->getMessage();
        exit;
    }
    $db_conn->close();
    



?>