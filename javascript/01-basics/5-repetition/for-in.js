// for in 문
// 객체의 key(속성 이름)를 순회
// 배열은 사용 가능하지만, 인덱스가 꼬일 수 있으므로 사용 X
const user = { name: "아기고양이", age: 21, hobby: "고양이"}

for (const key in user) {
    console.log(`${key} -> ${user[key]}`);
}