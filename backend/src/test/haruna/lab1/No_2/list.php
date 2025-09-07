<?php

    // 검색 type, 키워드 GET로 받기
    $searchType = isset($_GET['search_type']) ? $_GET['search_type'] : 'name'; // type : 기본 -> name
    $searchQuery = isset($_GET['search_query']) ? $_GET['search_query'] : ''; // 키워드 : 기본 -> '' 

    $page = isset($_GET['page']) ? $_GET['page'] : 1 ; // 현재 페이지 page를 GET로 받기
    $limit = 5; // 한페이지에 출력 하는 게시글 수
    $offset = ($page - 1) * $limit;// 다음 페이지에 이동할 때 얼마만큼 건너 뛰는지
   
    try {
        // DB 연결
        require_once("./db_conf.php");

        // 페이지네이션 구현
        $totalSql = "SELECT COUNT(*) total FROM guestbook";// total 게시글 수
        $totalQuery = $db_conn->query($totalSql);
        $totalRow = $totalQuery->fetch_assoc();
        $total = $totalRow['total']; 
        $totalPage = ceil($total / $limit);// total 페이지 수
        
        // 블록
        $pagePerBlock = 5; // 한 블록에 몇개 페이지 수 를 표시하는지
        $currentBlock = ceil($page / $pagePerBlock);// 현재 블록
        $startPage = ($currentBlock - 1) * $pagePerBlock + 1;// startPage
        $endPage = min($pagePerBlock * $currentBlock , $totalPage);// endPage
        $where = '';

        // 퀴워드 있으면 검색 조건을  $WHERE 변수에 저장
        if (!empty($searchQuery)) {
            $where = "WHERE $searchType LIKE '%$searchQuery%'";
        }

        // SELECT sql문 작성하기 
        $readSql = "SELECT * FROM guestbook $where ORDER BY id DESC LIMIT $limit OFFSET $offset"; 
        $readResult = $db_conn->query($readSql); // 쿼리 실행


    } catch (Exception $e) {
        echo "DB오류" . $e;
    }


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

    <!-- 검색 기능 구현-->
    <!--검색 타입(search_type)과 키워드(search_qery) 입력을 받는다-->
    <form action="list.php" method="get">
        <select name="search_type">
            <option value="name">이름</option>
            <option value="content">내용</option>
        </select>
        <input type="search" name="search_query">
        <button>검색</button>
    </form>

    <table border="2">
        <th>번호</th>
        <th>작성자</th>
        <th>내용</th>
        <th>작성일</th>

        <?php
        if ($readResult && $readResult->num_rows > 0) {
            while ($row = $readResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'];
                echo "<td>" . $row['name'];
                echo "<td>" . $row['content'];
                echo "<td>" . $row['created_at'];
                echo "</tr>";
            }
        } else {
            echo "<tr colspace 4>";
            echo "<td>" . "게시물이 없습니다." . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="form.html"><button>글쓰기</button></a>

    <?php
        $nextBlockPage = $endPage + 1; // 다음 블록 이동하는 변수 저장
        $prevBlockPage = $startPage - 1; // 이전 블록 이동하는 변수 저장

        // "<<" -> 1페이지에 이동하기
        // "<" -> 전 페이지에 이동하기
        if ($startPage != 1) {
            echo "<a href=?page=1><<</a> ";
            echo "<a href=?page=$prevBlockPage><</a> ";
        }
        
        // 페이지 표시
        for ($i = $startPage ; $i <= $endPage ; $i++) {
            if ($page == $i) {
                echo "<a href=?page=$i><strong>$i</strong></a> ";
            } else {
                echo "<a href=?page=$i>$i</a> ";
            }
        }
        
        // ">" -> 다음 블록 이동
        // ">>" -> 마지막 페이지에 이동하기
        if ($endPage != $totalPage) {
            echo "<a href=?page=$nextBlockPage>></a> ";
            echo "<a href=?page=$totalPage>>></a>";
        }
        
    ?>
</body>

</html>