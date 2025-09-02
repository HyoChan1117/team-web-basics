<?php

    // 페이지네이션
    $limit = 5;   // 한 페이지에 게시물을 얼마나 출력할 지
    $page = isset($_GET['page']) ? $_GET['page'] : 1;  // 현재 페이지
    $offset = ($page - 1) * $limit;  // limit이 정해졌다면 다음 페이지로 이동 시 얼마만큼 뛰어넘을건지

    // 검색타입, 검색쿼리 유효성 검사
    // 검색타입: 작성자(name) - 기본
    // 검색쿼리: 빈 값 - 기본
    $search_type = isset($_GET['search_type']) ? trim($_GET['search_type']) : 'name';
    $search_query = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';

    // 검색 조건
    $where = '';

    // 검색쿼리가 비어있지 않을 경우
    if (!empty($search_query)) {
        $where = "WHERE $search_type LIKE '%$search_query%'";
    }

    try {
        // 데이터베이스 연결
        require_once './db_connect.php';

        // sql문 작성 (SELECT)
        $sql = "SELECT * FROM guestbook $where ORDER BY id DESC LIMIT $limit OFFSET $offset";

        // 쿼리 실행
        $result = $db_conn->query($sql);

        // sql문 작성 (SELECT COUNT)
        $totalSql = "SELECT COUNT(*) total FROM guestbook $where";

        // 쿼리 실행
        $totalResult = $db_conn->query($totalSql);
        $totalRow = $totalResult->fetch_assoc();

        // 전체 게시물의 개수
        $total = $totalRow['total'];

        // 전체 페이지의 개수
        $totalPages = ceil($total / $limit);

        // 블록 설정
        $pagePerBlock = 5;  // 블록 당 페이지 수
        $currentBlock = ceil($page / $pagePerBlock);  // 현재 블록
        $startPage = ($currentBlock - 1) * $pagePerBlock + 1;  // 현재 블록에서 시작 페이지
        $endPage = min($pagePerBlock * $currentBlock, $totalPages);   // 현재 블록에서 마지막 페이지

    } catch (Exception $e) {
        // DB 오류 발생
        echo "DB 오류 발생<br>".$e;
    }

    // 데이터베이스 종료
    $db_conn->close();

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>방명록 목록</title>
</head>
<body>
    <!--
    방명록 목록

    검색타입 검색쿼리 검색버튼
    Form
    Action: list.php
    Method: get
    입력값: 검색타입(search_type), 검색쿼리(search_query)

    <table>
    번호 작성자 내용
    </table>
    
    글쓰기 버튼 활성화
    -->

    <h1>방명록 목록</h1>

    <form action="list.php" method="get">
        <select name="search_type">
            <option value="name">작성자</option>
            <option value="msg">내용</option>
        </select>

        <input type="search" name="search_query" value="<?= $search_query; ?>">

        <button>검색</button>
    </form>

    <table border="1">
        <tr>
            <th>번호</th>
            <th>작성자</th>
            <th>내용</th>
            <th>작성일</th>
        </tr>

        <?php

            // 게시글이 없을 경우
            // 게시글이 없습니다.
            if ($result->num_rows <= 0) {
                echo "<tr>";
                echo "<td colspan=4>게시글이 없습니다.</td>";
                echo "</tr>";
            }

            // 게시글이 있을 경우
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>$row[id]</td>";
                echo "<td>$row[name]</td>";
                echo "<td>$row[msg]</td>";
                echo "<td>$row[created_at]";
                echo "</tr>";
            }
        ?>
    </table>

    <button onclick="location.href='form.html'">글쓰기</button>

    <?php
        // 검색타입, 검색쿼리 반영
        $search = "search_type=$search_type&search_query=$search_query";

        // 첫 번째 블록일 경우
        // <<, < 출력 X

        // 첫 번째 블록이 아닐 경우
        // <<, < 출력
        $prevPage = $startPage - 1;
        if ($currentBlock != 1) {
            // 첫 페이지 이동
            echo "<a href='list.php?page=1&$search'><<</a> ";

            // 이전 블록 이동
            echo "<a href='list.php?page=$prevPage&$search'><</a> ";
        }

        // 현재 블록 전체 페이지 출력
        for ($i = $startPage; $i <= $endPage ; $i++) {
            // 현재 페이지 굵게
            if ($i == $page) {
                echo "<a href='list.php?page=$i&$search'><strong>$i</strong></a> ";
            } else {  // 현재 페이지 제외하고는 가늘게
                echo "<a href='list.php?page=$i&$search'>$i</a> ";
            }
        }

        // 전체 페이지 수와 마지막 페이지가 같을 경우
        // >, >> 출력 x

        // 전체 페이지 수와 마지막 페이지가 같지 않을 경우
        // >, >> 출력
        $nextPage = $endPage + 1;
        if ($totalPages != $endPage) {
            // 다음 블록 이동
            echo "<a href='list.php?page=$nextPage&$search'>></a> ";

            // 마지막 페이지 이동
            echo "<a href='list.php?page=$totalPages&$search'>>></a> ";
        }
    
    ?>

</body>
</html>