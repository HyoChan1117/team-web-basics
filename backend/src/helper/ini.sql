-- 데이터베이스 생성
CREATE DATABASE IF NOT EXISTS helper;

-- 데이터베이스 사용
USE helper;

-- 사용자 테이블 생성
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    account VARCHAR(255) NOT NULL UNIQUE,
    pw VARCHAR(255) NOT NULL,
    role ENUM('client', 'designer', 'manager') NOT NULL,
    PRIMARY KEY (user_id)
);

-- 사용자 정보 입력
INSERT INTO users (name, account, pw, role) VALUES
    ('haruna', 'haruna', 'haruna', 'client'),
    ('hyochan', 'hyochan', 'hyochan', 'designer'),
    ('dhinesh', 'dhinesh', 'dhinesh', 'manager')
;
    