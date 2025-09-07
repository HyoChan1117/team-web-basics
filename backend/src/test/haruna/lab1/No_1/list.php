<?php
// DB블어오기
require_once("./db_conf.php");


// 검색 입력값 유효성 검사
$searchType = isset($_GET['search_type']) ? $_GET['search_type'] : 'name'; // 검색타입: 작성자(name) - 기본
$searchQuery = isset($_GET['search_query']) ? trim($_GET['search_query']) : ''; // 검색쿼리: 빈 값 - 기본

$where = '';
// 검색쿼리가 비어있지 않을 경우 검색 조건 실행
if (!empty($searchQuery)) {
    $where = "WHERE $searchType LIKE '%$searchQuery%'";
}

// 페이지네이션
$page = isset($_GET['page']) ? $_GET['page'] : 1; // 요청 파라미터 (GET) page: 1 이상의 정수 (기본 1)
$limit = 5; // limit: 한 페이지에서 보여줄 게시물 개수 설정
$offset = ($page - 1) * $limit;  // Offset: 얼마만큼 글 쓰기를 건너 뛰는지

// sql문 작성 (SELECT)
$totalSql = "SELECT COUNT(*) total FROM guestbook"; // 총 게시물 개수 조회: SELECT COUNT(*) 사용

// 쿼리 실행
$totalResult = $db_conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow["total"]; // total게시글 가져오기
$totalPages = ceil($total / $limit); // total 페이지 수

// 블록 설정 
$pagePerBlock = 5; // 한 블록 당 페이지 수 ex) 1 블록의 페이지 1 2 3 4 5 > >> 총 5 페이지 
$currentBlock = ceil($page / $pagePerBlock); // 현재 블록
$startPage = ($currentBlock - 1) * $pagePerBlock + 1; // 현재 블록의 start 페이지
$endPage = min($pagePerBlock * $currentBlock, $totalPages);  // 현재 블록의 end 페이지


// DB에 저장된 모든 이름과 메시지를 최신순(내림차순: DESC)으로 불러와 화면에 출력한다.
$listSql = "SELECT * FROM guestbook $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
$listResult = $db_conn->query($listSql);

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
    <!--검색 form 작성
    검색타입: 작성자(name), 내용(msg)
    입력값은 GET 방식으로 list.php로 전달한다.-->
    <form action="list.php" method="get">
        <!-- 검색타입은 select 사용 -->
        <select name="search_type">
            <option value="name">작성자</option>
            <option value="content">내용</option>
        </select>
        <!-- 검색쿼리는 input type=“search” 사용 -->
        <input type="search" name="search_query">
        <!-- 검색 버튼 활성화-->
        <button>검색</button>
    </form>

    <table border="2">
        <th>번호</th>
        <th>작성자</th>
        <th>내용</th>
        <th>작성일</th>
        <tr></tr>
        <a href=""></a>
        <?php
        if ($listResult && $listResult->num_rows > 0) {
            while ($row = $listResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . "{$row['id']}" . "</td>";
                echo "<td>" . "{$row['name']}" . "</td>";
                echo "<td>" . "<a href='view.php?id={$row['id']}'>{$row['content']}</a>" . "</td>";
                echo "<td>" . "{$row['created_at']}" . "</td>";
                echo "</tr>";
            }
            // 게시물이 없을 경우 “게시글이 없습니다.” 출력
        } else {
            echo "<td colspan='4'>" . "게시글이 없습니다." . "</td>";
        }

        ?>
    </table>
    <!--방명록 작성을 위한 글쓰기 버튼을 활성화한다.-->
    <a href="form.html"><button>글쓰기</button></a>
    <br>



    <?php
    $nextPage = $endPage + 1; # totalpage === endpage -> 다음 블록 버튼 출력하지 말것
    $prevPage = $startPage - 1; # 현재 블록이 1 때는 < 출력하지 말 것

    # 이전 블록 이동
    if ($currentBlock != 1) {
        echo "<a href='?page=1'><<</a> ";
        echo "<a href='?page=$prevPage'><</a> ";
    }

    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $page) {
            echo "<a href='?page=$i'><strong>$i</strong></a> ";
        } else {
            echo "<a href='?page=$i'>$i</a> ";
        }
    }

    if ($totalPages != $endPage) {
        echo "<a href='?page=$nextPage'>></a> ";
        echo "<a href='?page=$totalPages'> >></a> ";
    }
    # 다음 블록 이동
    ?>


</body>

</html>