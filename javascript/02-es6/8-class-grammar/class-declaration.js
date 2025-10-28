class Person {
    // 생성자
    constructor(name) {
        // 인스턴스 속성
        this.name = name;
    }

    // 인스턴스 메서드
    sayHello() {
        console.log(`안녕, 나는 ${this.name}이야`);
    }

    // 정적 메서드 (python에서는 클래스 메서드)
    static species() {
        console.log("인간");
    }
}

const p1 = new Person("아기고양이");  // 인스턴스 생성
p1.sayHello();    // 인스턴스 메서드 호출
Person.species()  // static 메서드 호출