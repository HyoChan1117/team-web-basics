<?php

    // pagination
    $limit = 5; // set the page limit
    $page = isset($_GET['page']) ? $_GET['page']: '1';
    $offset = ($page - 1) * $limit;

    // get search query
    $search_type = isset($_GET['search_type']) ? $_GET['search_type']: 'name';
    $search_query = isset($_GET['search_query']) ? $_GET['search_query']: '';

    $where = '';

    // search query
    if(!empty($search_query)){
        $where = "WHERE $search_type LIKE '$search_query%'";
    }

    // inside a error handling
    try{

        // db address
        require_once "./db_config.php";

        // sql statement
        $sql = "SELECT * FROM board $where ORDER BY postID DESC LIMIT $limit OFFSET $offset";

        // Run query
        $result = $db_conn->query($sql);

        // count post 
        $totalSql = "SELECT COUNT(*) total FROM board";
        $totalResult = $db_conn->query($totalSql);
        $totalRow = $totalResult->fetch_assoc();
        $total = $totalRow ['total'];
        $totalPage = ceil($total / $limit);

        // setting block
        $pagePerBlock = 5;
        $currentBlock = ceil($page / $pagePerBlock);
        $startPage = ($currentBlock - 1) * $pagePerBlock + 1; 
        $endPage = min($currentBlock * $pagePerBlock, $totalPage);

    }catch(Exception $e) {
        // db error
        echo "DB erro".$e;
    }
    // db close
    $db_conn-> close();

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

<form action="list.php" method= "get">
    <select name="search_type">
        <option value="name">Author</option>
        <option value="messageArea">content</option>
    </select>
    <input type="search" name= "search_query">
    <button>search</button>
</form>    


<!-- create a table tag-->
<form action="list.php" method= "get">
        <table border= 2>
            <tr>
                <th>id</th>
                <th>Author</th>
                <th>content</th>
                <th>created_at</th>
            </tr>
       
<?php
    // if the post is valid see the post or display an error message
    if($result->num_rows <= 0){
        echo "no post";
    }else{
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>$row[postID]</td>";
            echo "<td>$row[name]</td>";
            echo "<td><a href='read.php?postID=$row[postID]'>$row[messageArea]</a></td>";
            echo "<td>$row[created_at]</td>";
            echo "</tr>";
        }
    }

?>
</table>
</form>
<!-- create a anchor -->
 <a href="form.html">write</a><br><br>

<?php

    // pagination
    $search = "search_type=$search_type&search_query=$search_query";

    // previous page
    $prevPage = $startPage - 1;

    // next block
    $nextBlock = $endPage + 1;

    // previous block
    if($currentBlock != 1) {
        echo "<a href ='?page=1&$search'><<</a> ";
        echo "<a href ='?page=$prevPage&$search'><</a> ";
    }

    // display the current block page
    for ($i = $startPage; $i <= $endPage; $i++) {
        if($i == $page) {
            echo "<a href ='?page=$i&$search'><strong>$i</strong></a> ";
        }else {
            echo "<a href='?page=$i&$search'>$i</a> ";
        }
    }

    // next block
    if($endPage != $totalPage) {
        echo "<a href ='?page=$nextBlock&$search'>></a> ";
        echo "<a href ='?page=$totalPage&$search'>>></a> ";
    }
?>

</body>
</html>