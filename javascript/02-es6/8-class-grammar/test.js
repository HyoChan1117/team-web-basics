// 부모 클래스
class A {
    // 생성자(이름)
    constructor(name) {
        this.name = name;
    }
}

// 자식 클래스(부모)
class B extends A {
    // 생성자(나이)
    constructor(name, age) {
        super(name);
        this.age = age;
    }

    prt() {
        console.log(`안녕하세요. ${this.name}입니다. 나이는 ${this.age}입니다.`);
    }
}

// 인스턴스 생성
obj = new B("김효찬", 13);

// 출력 메서드 호출
obj.prt();