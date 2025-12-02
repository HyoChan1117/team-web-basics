<?php
    // login info
    require_once "./welcome.php";

    // get the user permission function
    require_once "./helper.php";

    require_once "./menu.php";

    // // check the login and role
    // if(!user_permission($_SESSION['role'], 'client')){
    //     echo "Access denied. Client only";
    //     exit;
    // }

    // set the page limi
    $limit = 3;

    // get the page query
    $page = isset($_GET['page'])? $_GET['page']: '1';

    // set the offset
    $offset = ($page - 1) * $limit;

    // create a search query
    $search_type = isset($_GET['search_type'])? $_GET['search_type']: 'title';
    $search_query= isset($_GET['search_query'])? $_GET['search_query']: '';

    // build search string for pagination
    $search = "search_type=$search_type&search_query=$search_query";

    $where = '';

    // validate the search query
    if(!empty($search_query)){
        $where = "WHERE $search_type LIKE '%$search_query%'";
    }
    try{
        // connect DB
        require_once "./db_config.php";

        // sql statement
        $sql = "SELECT * FROM News $where ORDER BY news_id DESC LIMIT $limit OFFSET $offset";

        // sql query
        $result = $db_conn->query($sql);

        // set the page setting
        $total_sql = "SELECT COUNT(*) total FROM News $where";
        $totalResult = $db_conn->query($total_sql);
        $totalRow = ($totalResult->fetch_assoc());
        $total = $totalRow['total'];
        $total_page = ceil($total/$limit);

        // set the block setting
        $page_per_block = 5;
        $current_block = ceil($page / $page_per_block);
        $start_page = ($current_block - 1) * $page_per_block + 1;
        $end_page = min($current_block * $page_per_block, $total_page);

    }catch(Exception $e){
        // DB Error 
        echo "db error".$e;
    }
    // DB close
    $db_conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>news</title>
</head>
<body>
    <h3>news</h3>
    <form action="news.php" method="get">
        <select name="search_type">
            <option value="title">Title</option>
            <option value="content">Content</option>
        </select>
        <input type="search" name="search_query">
        <button>search</button><br><br>
    </form>

    <form action="news.php" method="get">
        <table border="2">
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Content</td>
            <td>Created_at</td>
        </tr>
<?php
    // if the input is valid display error message
    // else show the news
    if($result->num_rows <= 0){
        echo "No Post";
    }
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>$row[news_id]</td>";
        echo "<td>$row[title]</td>";
        echo "<td>$row[content]</td>";
        echo "<td>$row[created_at]</td>";
        echo "</tr>";
    }

?>

        </table>
    </form>

<?php
    // previous block
    $prevPage = $start_page - 1;

    if($current_block != 1){
        echo "<a href='?page=1&$search'><<<</a> ";
        echo "<a href='?page=$prevPage&$search'><</a> ";
    }

    for ($i = $start_page; $i <= $end_page; $i++){
        if($i == $page){
            echo "<a href='?page=$i&$search'><strong>$i</strong></a> ";
        }else{
            echo "<a href='?page=$i&$search'>$i</a> ";

        }
    }

    // next block
    $next_block = $end_page + 1;
    if($end_page != $total_page){
        echo "<a href='?page=$nextBlock&$search'>></a> ";
        echo "<a href='?page=$endPage&$search'>>></a> ";
    }


?>
<?php if ($_SESSION['role'] == 'manager'): ?>
        <br>
        <a href="staff_modify.php"><button>Modify</button></a>
    <?php endif; ?>

</body>
</html>