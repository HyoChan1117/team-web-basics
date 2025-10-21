// 부모 클래스
class A {
    constructor(name) {
        console.log(`안녕하세요. ${name}님!`);
    }
}

// 자식 클래스
class B extends A {
    constructor(age) {
        // 부모 클래스의 생성자
        super("아기고양이");
        console.log(`나는 ${age}살입니다.`);
    }
}

obj = new B(26);