// 호이스팅
// 변수 선언이 코드의 맨 위로 끌어올려지는 현상
// var로 선언된 변수는 호이스팅이 일어남
// 호이스팅이 일어날 경우 코드의 모호성 발생
console.log(a);
var a = 10;

// let과 console로 선언된 변수는 호이스팅이 일어나지 않음
// 기본적으로 변수가 선언된 이후에 접근이 가능하게 해야 모호성 없음
console.log(b)
let b = 10;

console.log(c)
const c = 10;