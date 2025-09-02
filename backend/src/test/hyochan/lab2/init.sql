-- 데이터베이스 생성
CREATE DATABASE test;

-- 데이터베이스 사용
USE test;

-- 방명록 테이블 생성
CREATE TABLE IF NOT EXISTS guestbook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    msg VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 예시 데이터
INSERT INTO guestbook (name, msg) VALUES
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye'),
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye'),
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye'),
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye'),
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye'),
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye'),
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye'),
    ('Hyochan', 'hi'),
    ('Haruna', 'hello'),
    ('dhinesh', 'bye')
;

