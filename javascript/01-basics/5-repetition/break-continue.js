// break / continue
// 반복 제어용 키워드

for (let i = 0; i < 10; i++) {
    if (i === 2) continue;  // 2만 건너뛰기
    if (i === 5) break;     // 5에서 종료
    console.log(i);   // 0, 1, 3, 4
}