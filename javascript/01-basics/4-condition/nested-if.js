// 중첩 if 문
// if문 안에 또 if 문을 넣어서 세밀한 조건 분기 가능
let isMember = true;
let purchase = 12000;

if (isMember) {
    if (purchase >= 10000) {
        console.log("회원 할인 + 무료배송");
    } else {
        console.log("회원 할인만 적용");
    }
} else {
    console.log("비회원 고객입니다.");
}