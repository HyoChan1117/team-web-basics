<?php

    // pagination
    $limit = 5; // Number of posts to be displayed on the page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current Page
    $offset = ($page -1) * $limit; // Skip this number, start next

    // create a search query
    $search_type = isset($_GET['search_type']) ? $_GET['search_type']: 'name';
    $search_query = isset($_GET['search_query']) ? $_GET['search_query']: '';
    
    $where = '';

    // search query
    if(!empty($search_query)) {
        $where = "WHERE $search_type LIKE '$search_query%'";
    }

    // inside error handling
    try {
        // db address
        require_once "./db_config.php";
        
        // sql statement
        $sql = "SELECT * FROM guestbook $where ORDER BY id DESC";

        // run query
        $result = $db_conn->query($sql);

        // count post number
        $totalSql = "SELECT COUNT(*) total FROM guestbook";
        $totalResult = $db_conn->query($totalSql);
        $totalRow = $totalResult->fetch_assoc();
        $total = $totalRow['total'];
        $totalPages = ceil($total / $limit);

        // block setting
        $pagePerBlock = 5;
        $currentPage = $page / $pagePerBlock;
        $startPage = ceil($currentPage -1) * $pagePerBlock + 1; 
        $endPage = min($currentPage * $pagePerBlock, $totalPages);

    }catch(Exception $e){
        // db error message
        echo "DB error" .$e;
    }
    // db close
    $db_conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Book</title>
</head>
<body>
    <h2>Guest Book</h2>
<!-- create a select tag -->
<form action="list.php" method= "get">
    <select name="search_type">
        <option value="name">Author</option>
        <option value="messageArea">content</option>
    </select>
    <input type="search" name= "search_query">
    <button>search</button>
</form> 
<!-- create a table tag -->
<form action="list.php" method= "get">
        <table border= "2">
        <tr>
            <th>id</th>
            <th>Author</th>
            <th>content</th>
            <th>created_at</th>
        </tr>
    
<?php
    $count = $result -> num_rows;

    // if the post is valid see the post or display error message
    if($result->num_rows <= 0){
        echo "No post";
    }
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>$count</td>";
        echo "<td>$row[name]</td>";
        echo "<td>$row[messageArea]</td>";
        echo "<td>$row[created_at]</td>";
        echo "</tr>";

        $count--;
    }

?>    
</table>
</form>
<!-- create a anchor-->
<button><a href="form.html">write</a></button><br>

</body>
</html>