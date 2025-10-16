<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    <h1>로그인</h1>

    <form action="login_process.php" method='post'>
        <fieldset>
            <legend>사용자 정보 입력</legend>
            <input type="radio" id="client" name="role" value="client" required>
            <label for="client">고객</label>
            <input type="radio" id="designer" name="role" value="designer" required>
            <label for="designer">디자이너</label>
            <input type="radio" id="manager" name="role" value="manager" required>
            <label for="manager">관리자</label>

            <hr>

            <p><label for="account">아이디:</label> <input type="text" id="account" name="account"></p>
            <p><label for="pw">비밀번호:</label> <input type="password" id="pw" name="pw"></p>

            <button>로그인</button>
            <input type="reset" value="초기화">
        </fieldset>
    </form>
</body>
</html>