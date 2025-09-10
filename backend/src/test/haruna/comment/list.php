<?php

    // 페이지네이션
    $limit = 5;  // 한 페이지 당 게시글 개수
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // 검색 유효성 검사
    $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'title';
    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

    // 검색 조건
    $where = '';

    // 검색 쿼리가 비어있지 않을 경우
    if (!empty($search_query)) {
        $where = "WHERE $search_type LIKE '%$search_query%'";
    }

    try {
        // 데이터베이스 연결
        require_once "./db_connect.php";

        // 게시글 목록 출력
        // sql문 작성 (SELECT)
        $sql = "SELECT * FROM board $where ORDER BY postID DESC LIMIT $limit OFFSET $offset";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // 게시글 개수 세기
        // sql문 작성 (SELECT COUNT(*))
        $totalSql = "SELECT COUNT(*) total FROM board $where";

        // 쿼리 실행
        $totalResult = $db_conn->query($totalSql);
        $totalRow = $totalResult->fetch_assoc();
        $total = $totalRow['total'];   // 전체 게시글 수
        $totalPages = ceil($total / $limit);  // 전체 페이지 수

        // 블록 설정
        $pagePerBlock = 5;  // 한 블록 당 페이지 수
        $currentBlock = ceil($page / $pagePerBlock);   // 현재 블록
        $startPage = ($currentBlock - 1) * $pagePerBlock + 1;  // 현재 블록 시작 페이지
        $endPage = min($currentBlock * $pagePerBlock, $totalPages);  // 현재 블록 마지막 페이지
        $prevBlock = $startPage - 1;  // 이전 블록
        $nextBlock =  $endPage + 1;   // 다음 블록

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생";
        exit;
    }

    // 데이터베이스 종료
    $db_conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록</title>
</head>
<body>
    <!--
    게시판 목록

    검색타입 검색쿼리 검색버튼

    <table>
    번호 작성자 제목 작성일
    postID name title created_at
    </table>

    글쓰기 버튼 -> insert.php

    페이지네이션
    -->
    <h1>게시판 목록</h1>

    <form action="list.php" method="get">
        <select name="search_type">
            <option value="title">제목</option>
            <option value="content">내용</option>
            <option value="name">작성자</option>
        </select>

        <input type="search" name="search_query">

        <button>검색</button>
    </form>

    <br>

    <table border='1'>
        <tr>
            <th>번호</th>
            <th>작성자</th>
            <th>제목</th>
            <th>작성일</th>
        </tr>

        <?php
            
            // 게시물이 없을 경우
            // 게시물이 없습니다.
            $count = $total;   // 게시물 개수 세기

            if ($result->num_rows <= 0) {
                echo "<tr><td colspan='4'>게시물이 없습니다.</td></tr>";
            } else {   // 게시물이 있을 경우
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$row[postID]</td>";
                    echo "<td>$row[name]</td>";
                    echo "<td><a href='read2.php?id=$row[postID]'>$row[title]</a></td>";
                    echo "<td>$row[created_at]</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>

    <button onclick="location.href='insert.php'">글쓰기</button>

    <?php
        // 검색 결과 반영
        $search = "&search_type=$search_type&search_query=$search_query";

        // 이전 블록 이동
        // 현재 블록이 1이 아니면 이전 블록 이동 버튼 출력
        if ($currentBlock != 1) {
            echo "<a href='?page=1$search'><<</a> ";
            echo "<a href='?page=$prevBlock$search'><</a> ";
        }

        // 현재 블록 페이지 출력
        // 현재 페이지는 진하게 출력
        for ($i = $startPage ; $i <= $endPage ; $i++) {
            if ($page == $i) {
                echo "<a href='?page=$i$search'><strong>$i</strong></a> ";
            } else {
                echo "<a href='?page=$i$search'>$i</a> ";
            }
        }

        // 다음 블록 이동
        // 전체 페이지와 현재 블록 마지막 페이지가 같지 않으면 다음 블록 이동 버튼 출력
        if ($totalPages != $endPage) {
            echo "<a href='?page=$nextBlock$search'>></a> ";
            echo "<a href='?page=$totalPages$search'>>></a> ";
        }
    ?>
</body>
</html>