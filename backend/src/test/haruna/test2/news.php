<?php
    session_start();

    # serch query 받기
    $search_type = isset($_GET['serch_type']) ? $_GET['serch_type'] : 'title';
    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

    # page네이션 만들기
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 5; # 한 페이지에 출력하는 글의 개수
    $offset = ($page - 1) * $limit; # 다음 페이지에 몇개 씩 글을 넘어서 가는지

    # serch 내용 sql문
    $where = '';
    if (!empty($search_query)) {
        $where = "WHERE $search_type LIKE '%$search_query%'";
    }

    try{
        # db 연결
        require_once("./db_conn.php");

        # total계시글 수 가져 오기
        $total_sql = "SELECT COUNT(*) AS total FROM News";
        $total_result = $db_conn->query($total_sql);
        $total_row = $total_result->fetch_assoc();
        $total = $total_row["total"];

        # total page 
        $total_page = ceil($total / $limit);

        # 블록 계산
        $blockpage = 5; # 한 블록에 몇개 페이지를 표시하는지 
        $curryblock = ceil($page / $blockpage); # 현재 블록
        $start_page = ($curryblock - 1) * $blockpage + 1; # 한 블록의 start 숫자
        $end_page = (min($total_page,$blockpage * $curryblock)); # 한 블록의 마지막 숫자

        # News 테이블에 데이터를 가져오기
        $sql = "SELECT * 
                FROM News $where ORDER BY news_id DESC 
                LIMIT $limit OFFSET $offset";
        $result = $db_conn->query($sql);


    } catch (Throwable $e) {
        error_log($e->getMessage());
        echo "DB오류". $e->getMessage() ."";
        exit;
    }
    $db_conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
<body>
    <h1>News</h1>
    <form action="news.php" method="get">
    <select name="search_type">
        <option value="title">title</option>
        <option value="content">content</option>
    </select>
        <input type="search" name="search_query">
        <button>serch</button>
    </form>
    
    <hr>

    <?php while($row = $result->fetch_assoc()): ?>
        <?= $row['news_id'] ?>
        <a href="news_viwe.php?news_id=<?= $row['news_id']?>"><?= $row['title'] ?></a>
        <br>
        <?= $row['created_at'] ?>
        <hr>
    <?php endwhile; ?>

    <?php 
        $fromblock = $start_page - 1;
        $nextblock = $end_page + 1;
    ?>

    <?php if($curryblock != 1): ?>
        <!-- '<<' 첫 번째 블록으로 감 -->
        <a href="news.php?page=1"><<</a>
        <!-- '<' 전 블록으로 감 -->
        <a href="news.php?page=<?=$fromblock?>"><</a>
    <?php endif; ?>

    <!-- page 수 표시 -->
        <?php for($i = $start_page; $i <= $end_page; $i++): ?>
            <?php if ($i == $page): ?>
                <strong><a href="news.php?page=<?=$i?>"><?=$i?></a></strong>
            <?php else: ?>
                <a href="news.php?page=<?=$i?>"><?=$i?></a>
            <?php endif; ?>
        <?php endfor; ?>

    <!-- '>' 다음 블록으로 감 -->
    <?php if($end_page != $total_page): ?>
        <a href="news.php?page=<?=$nextblock?>">></a>
        <a href="news.php?page=<?=$total_page?>">>></a>
    <?php endif; ?>



    <!-- manerger만 볼 수 있도록 권한  -->
    <br>
    <?php if($_SESSION['role'] == 'manager'): ?>
        <a href="made_news.php"><button>WRITE</button></a>
    <?php endif; ?>
    <br>
    <a href="mypage.php">--mypage--</a>
    
</body>
</html>