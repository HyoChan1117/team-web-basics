<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
<body>
    <h1>News > Write</h1>
    <hr>
    <form action="news_process.php" method="post" enctype="multipart/form-data">
        title<br>
        <input type="text" name="title" required><br>
        content<br>
        <textarea name="content" cols="60" rows="10" required></textarea><br>
        file<br>
        <input type="file" name="file"><br>
        <br>
        <button>submit</button>
    </form>
    <a href="news.php">back</a>
</body>
</html>