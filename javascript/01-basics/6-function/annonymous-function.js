// 익명 함수 & 콜백 함수 예제
// 익명 함수
// 이름이 없는 함수 = 함수 이름을 생략한 함수
// 호이스팅 불가능 -> 선언 후에만 호출 가능

// greet("아기고양이");  -> 익명 함수는 선언 후 호출 가능

const greet = function(name) {
    console.log(`안녕, ${name}!`);
}

greet("아기고양이");


// 기본 함수는 호이스팅 가능 -> 선언 전에도 호출 가능
test("아기강아지");

function test(name) {
    console.log(`안녕, ${name}!`);
}

test("아기강아지");