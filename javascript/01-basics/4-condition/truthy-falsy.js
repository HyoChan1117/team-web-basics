// truthy falsy 개념
// falsy
console.log("조건문을 실행시키기 위해 falsy에 ! 씌움");

if (!false) {console.log("falsy");}

if (!0) {console.log("falsy");}

if (!-0) {console.log("falsy");}

if (!"") {console.log("falsy");}

if (!null) {console.log("falsy");}

if (!undefined) {console.log("falsy");}

if (!NaN) {console.log("falsy");}


// truthy - 위에 있는 falsy 빼고 남은거 전부
