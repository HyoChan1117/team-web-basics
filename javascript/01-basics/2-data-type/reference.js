// 1. Object (객체)
// key-value 형태로 여러 데이터를 묶는 구조
const user = {
    name: "아기고양이",
    age: 21,
    hobby: "코딩",
    introduce: function() {
        console.log(`안녕하세요! 저는 ${this.name}입니다.`);
    }
};

console.log(user.name);
user.introduce();


// 2. Array (배열)
// 순서가 있는 데이터 리스트 (0부터 인덱스 시작)
const fruits = ["apple", "banana", "cherry"];

console.log(fruits[0]);      // "apple"
fruits.push("mango");        // 마지막 원소에 추가
console.log(fruits.length);  // 4
console.log(fruits.join(", "));  // "apple, banana, cherry, mango"


// 3. Function (함수)
// 실행 가능한 객체, 다른 변수처럼 다룰 수 있음
function greet(name) {
    return `Hello, ${name}!`;
}

const sayHi = greet;  // 함수도 변수에 저장 가능
console.log(sayHi("아기고양이"));  // "Hello, 아기고양이!"


// 4. Date (날짜와 시간)
// 현재 시각 또는 특정 날짜 객체 생성
const now = new Date();
console.log(now);  // 현재 날짜와 시간 출력

const birthday = new Date("2004-07-25");
console.log(birthday.getFullYear());   // 2004
console.log(birthday.getMonth() + 1);  // 7 (0부터 시작하므로 +1)
console.log(birthday.getDate());       // 25

