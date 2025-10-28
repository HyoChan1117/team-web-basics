function outer() {
    let count = 0;  // 외부 함수의 지역 변수

    function inner() {
        count++;  // 외부 변수에 접근
        console.log(count);
    }

    return inner;  // 내부 함수를 반환
}

const counter = outer();  // outer 실행 -> inner 반환
counter();  // 1
counter();  // 2
counter();  // 3