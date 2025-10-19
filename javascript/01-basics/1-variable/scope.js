// 스코프: 변수의 유효 범위
function test() {
    var a = 1;   // 함수 스코프: 함수 내에서만 유효
    let b = 2;   // 블록 스코프: {} 블록 내부에서만 유효
    const c = 3; // 블록 스코프: {} 블록 내부에서만 유효

    console.log(a)  // 함수 내니깐 가능
    console.log(b)  // {} 블록 내니깐 가능
    console.log(c)  // {} 블록 내니깐 가능
}

test()  // 호출 시 a, b, c 출력

// console.log(a)  // 에러
// console.log(b)  // 에러
// console.log(c)  // 에러