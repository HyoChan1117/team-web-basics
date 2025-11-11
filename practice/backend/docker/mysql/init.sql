SET NAMES utf8mb4 COLLATE utf8mb4_general_ci;

-- 데이터베이스 생성 (존재하지 않으면)
CREATE DATABASE IF NOT EXISTS gsc CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- gsc 데이터베이스 사용
USE gsc;

-- student 테이블 생성
CREATE TABLE IF NOT EXISTS student (
    std_id CHAR(7) PRIMARY KEY,                       -- 학번 (문자형)
    email VARCHAR(100) NOT NULL UNIQUE,               -- 이메일(ID)
    password VARCHAR(255) NOT NULL,                   -- 비밀번호 (해싱 저장)
    name VARCHAR(50) NOT NULL,                        -- 이름
    birth DATE NOT NULL,                              -- 생년월일
    gender ENUM('M', 'F') NOT NULL,                   -- 성별(M: 남성, F: 여성)
    admission_year YEAR NOT NULL,                     -- 입학년도 (예: 2023)
    current_year TINYINT UNSIGNED NOT NULL,           -- 현재 학년 (1~4)
    status ENUM('재학', '휴학', '졸업', '제적', '자퇴') NOT NULL DEFAULT '재학',  -- 학적 상태
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- mock 데이터 삽입
INSERT INTO student (std_id, email, password, name, birth, gender, admission_year, current_year, status) VALUES
(2023001,'kim@example.com',SHA2('password1',256),'배찬승','2003-05-14','M',2023,2,'재학'),
(2023002,'lee@example.com',SHA2('password2',256),'김영욱','2004-01-22','F',2023,2,'재학'),
(2023003,'park@example.com',SHA2('password3',256),'이재현','2002-11-03','F',2022,3,'휴학');
