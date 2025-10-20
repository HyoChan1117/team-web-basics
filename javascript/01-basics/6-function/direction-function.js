// 화살표 함수
// 1. function 키워드 생략 가능
// 2. 한 줄일 때는 {}와 return도 생략 가능
// 3. this를 바인딩하지 않음
const greet = (name) => `안녕, ${name}`;

console.log(greet("강아지"));



// 같은 의미
function test(name) {
    return `안녕, ${name}`;
}

console.log(test("강아지"));