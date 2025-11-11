// 기본 매개변수
function greet(name = "손님") {
    console.log(`안녕하세요, ${name}!`);
}

greet();            // 안녕하세요, 손님!  -> 기본값 사용
greet("매니저님")    // 안녕하세요, 매니저님!

// 인자가 전달되지 않으면 기본값 사용