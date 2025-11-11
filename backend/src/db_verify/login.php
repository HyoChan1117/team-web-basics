<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <style>
        .find {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!--
    로그인

    FORM
    Action: login_process.php
    Method: post
    입력값: 사용자(role), 아이디(account), 비밀번호(password)

    회원가입 -> register.php
    -->

    <h1>로그인</h1>

    <form action="login_process.php" method="post">
        
        <fieldset>
            <legend>사용자 정보 입력</legend>
            <p>사용자</p>
            <input type="radio" id="client" name="role" value="client">
            <label for="client">고객</label>
            <input type="radio" id="designer" name="role" value="designer">
            <label for="designer">디자이너</label>
            <input type="radio" id="manager" name="role" value="manager">
            <label for="manager">관리자</label>

            <hr>

            <p>아이디: <input type="text" name="account"></p>
            <p>비밀번호: <input type="password" name="password"></p>
            <button>로그인</button>
            <input type="reset" value="초기화">
        </fieldset>
    </form>

    <div class="find">
        <a href="find_account.php">아이디 찾기</a>
        <a href="find_password.php">비밀번호 찾기</a>
    </div>

    <hr>

    아직 계정이 없으십니까? <a href="register.php">회원가입</a>
</body>
</html>