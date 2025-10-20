// while 문
// 조건이 true인 동안 반복
let i = 0;

while (i < 3) {
    console.log(i);
    i++;
}

let count = 0;
while (true) {

    if (count == 10) {
        console.log("종료")
        break;
    }

    console.log(count);
    count++;
}