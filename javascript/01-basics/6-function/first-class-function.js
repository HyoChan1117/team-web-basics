// 일급 객체
// 함수는 변수에 저장하거나, 인자로 넘기거나, 반환할 수도 있음
function hello() {
    console.log("안녕!");
}

function execute(fn) {
    fn();  // 전달된 함수 실행
}

execute(hello);  // 안녕!