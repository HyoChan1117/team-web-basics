-- 데이터베이스 생성
CREATE DATABASE IF NOT EXISTS reservation;

-- 데이터베이스 사용
USE reservation;

-- 예약 테이블 생성
-- id, name, gender, service, requirement, date, time, created_at
CREATE TABLE IF NOT EXISTS reservation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    gender VARCHAR(255) NOT NULL,
    service VARCHAR(255) NOT NULL,
    requirement TEXT NOT NULL,
    date VARCHAR(100) NOT NULL,
    time VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);