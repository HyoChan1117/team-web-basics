// forEach (배열 전용 메서드)
// 중간에 break나 continue 사용 불가

const fruits = ["apple", "banana", "cherry"];

fruits.forEach((value, index) => {
  console.log(`${index}: ${value}`);
});


const student = ["haruna", "hyochan", "dhinesh"];

student.forEach(myFunction);

function myFunction(item, index) {
    console.log(`${index}: ${item}`);
}