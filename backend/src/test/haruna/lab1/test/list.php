<?php
    // 페이지네이션 기능 추가
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // 현재 페이지를 GET로 받기    
    $limit = 5; // 한 페이지에 게시글을 표시하는 수 
    $offset = ($page - 1) * $limit; // 다음페이지는 게시글을 건너 뛰는 수 $offset

    // 검색 기능 추가
    // get로 검색 키워드 받기
    $searchType = isset($_GET['search_type']) ? $_GET['search_type'] : 'name'; // 기본은 이름
    $searchQuery = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    $where = '';

    // if 문을 써서 검색 키워드가 있으면 $where변수에 저장하기
    if (!empty($searchQuery)) {
        $where = "WHERE $searchType LIKE '%$searchQuery%'";
    }

    try {
        // DB연결하기
        require_once("./db_conf.php");
        
        // total 게시글 수
        $totalSQl = "SELECT COUNT(*) total FROM guestbook $where";
        $totalQuery = $db_conn->query($totalSQl);
        $totalRow = $totalQuery->fetch_assoc();
        $total = $totalRow['total'];

        // totalpage수
        $totalPage = ceil($total / $limit);

        // 블록
        $block = 5; // 한 페이지에 표시하는 블록 수
        $currentBlock = ceil($page / $block);// 현재 블록 
        $startPage = ($currentBlock - 1) * $block + 1;// 블록의 startpage
        $endPage = min($block * $currentBlock, $totalPage); // 블록의 endpage

        // 검색 조건을 포함하는 SELECT 문 작성하기
        
        $readSql = "SELECT * FROM guestbook $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        // 쿼리 실행
        $resdQuery = $db_conn->query($readSql);

    } catch (Exception $e){
        echo "DB 오류 발생" . $e;
        exit;
    }
    $db_conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>방명록 목록</title>
</head>
<body>
    <h1>방명록 목록</h1>

    <!-- 검색 기능 추가-->
    <!-- 검색 type: 이름 or 내용 -->
    <!-- 검색 키워드: -->
     <form action="" method="get">
     <search>
        <select name="search_type">
            <option value="name">이름</option>
            <option value="content">내용</option>
        </select>
        <input type="search" name="search_query" value="<?= $searchQuery ?>">
        <button>검색</button>
     </search>
     </form>
    
    <table border="2">
        <th>번호</th>
        <th>작성자</th>
        <th>내용</th>
        <th>작성일</th>

        <?php 
            if ($resdQuery && $resdQuery->num_rows > 0) {
                while ($row = $resdQuery->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>". $row['id'] . "</td>";
                    echo "<td>". $row['name'] . "</td>";
                    echo "<td><a href='view.php?id=$row[id]'>$row[content]</a></td>";
                    echo "<td>". $row['created_at'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "<td colspan='4'>글이 없습니다.</td>";
                echo "</tr>";
            }
        ?>
    </table> 
    <a href="form.html"><button>글쓰기</button></a>

    <?php
    // 페이지 네이션
    $prevBlock = $startPage - 1; // 이전 블록에 이동하는 변수를 설정
    $nextBlock = $endPage + 1; // 다음 블록에 이동하는 변수를 설정
    $search = "&search_type=$searchType&search_query=$searchQuery";
    
    // 1블록은 '<', '<<' 를 출력하지 않다
    if ($startPage != 1) {
        echo "<a href='?page=1$search'><<</a> ";
        echo "<a href='?page=$prevBlock$search'><</a> ";
    }
    
    // 블록 페이지 출력
    for ($i = $startPage ; $i <= $endPage; $i++) {
        if ($i == $page) {
        echo "<a href='?page=$i$search'><strong>$i</strong></a> ";
        } else {
            echo "<a href='?page=$i$search'>$i</a> ";
        }
    }

    // 마지막 블록은 '>', '>>' 를 출력하지 않다
    if ($totalPage != $endPage) {
        echo "<a href='?page=$nextBlock$search'>></a> ";
        echo "<a href='?page=$totalPage$search'>>></a> ";
    }
    
    ?>
</body>
</html>