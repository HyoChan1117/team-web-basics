<?php

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
        $sql = "SELECT * FROM guestbook $where ORDER BY id DESC";

        // 쿼리 실행
        $result = $db_conn->query($sql);

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

</body>
</html>