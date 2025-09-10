<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글쓰기</title>
</head>
<body>
    <!--
    게시판 목록 > 글쓰기

    FORM
    Action: insert_process.php
    Method: post
    입력값: 이름(name), 제목(title), 내용(content)

    게시판 목록으로 돌아가시겠습니까? 돌아가기
    -->
    <h1>게시판 목록 > 글쓰기</h1>
    
    <form action="insert_process.php" method="post">
        <fieldset>
            이름: <input type="text" name="name"><br>
            제목: <input type="text" name="title"><br>
            내용: <br>
            <textarea name="content" cols="27" rows="5"></textarea>
        </fieldset>

        <button>제출</button>
        <input type="reset" value="초기화">
    </form>

    <hr>

    게시판 목록으로 돌아가시겠습니까? <a href="list.php">돌아가기</a>
</body>
</html>