<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
</head>
<body>
    <!--
    회원가입

    FORM
    Action: register_process.php
    Method: post
    입력값: 사용자(role), 이름(name), 성별(gender), 아이디(account), 비밀번호(password), 생년월일(birth), 전화번호(phone)

    로그인 -> login.php
    -->
    
    <h1>회원가입</h1>

    <form action="register_process.php" method="post">
        <fieldset>
            <legend>정보 입력</legend>
            <p>사용자</p>
            <input type="radio" id="client" name="role" value="client">
            <label for="client">고객</label>
            <input type="radio" id="designer" name="role" value="designer">
            <label for="designer">디자이너</label>
            <input type="radio" id="manager" name="role" value="manager">
            <label for="manager">관리자</label>

            <p>이름</p>
            <input type="text" name="user_name" placeholder="이름을 입력하세요."><br>

            <p>성별</p>
            <input type="radio" id="man" name="gender" value="남자">
            <label for="man">남자</label>
            <input type="radio" id="woman" name="gender" value="여자">
            <label for="woman">여자</label>
            
            <p>아이디</p>
            <input type="text" name="account" placeholder="아이디를 입력하세요.">

            <p>비밀번호</p>
            <input type="password" name="password" placeholder="비밀번호를 입력하세요."><br>
            <input type="password" name="pw_check" placeholder="비밀번호를 확인합니다.">

            <p>생년월일</p>
            <input type="date" name="birth" value="2000-01-01">

            <p>휴대전화</p>
            <input type="text" name="phone" placeholder="'-' 없이 번호를 입력해 주세요.">

        </fieldset>
        <button>회원가입</button>
        <input type="reset" value="초기화">
    </form>

    <hr>

    로그인 페이지로 돌아가기 <a href="login.php">돌아가기</a>
</body>
</html>