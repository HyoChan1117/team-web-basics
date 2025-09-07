-- 1. 데이터베이스 생성
CREATE DATABASE lab4;

-- 2. 데이터베이스 사용
USE lab4;

-- 3. 게시물 저장할 테이블(부모) 생성
-- postID(PK), name, title, content, created_at
CREATE TABLE IF NOT EXISTS board (
    postID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. 댓글 저장할 테이블(자식) 생성 (외래키: postID)
-- id(PK), name, pw, review, postID(FK)
-- ON DELETE CASCADE(삭제 허용), ON UPDATE CASCADE(수정 허용)


-----------------------------------------------------------------
-- 게시글 데이터
INSERT INTO board (name, title, content) VALUES
    ('hyochan', 'hi', 'hello'),
    ('haruna', 'hi', 'hello'),
    ('dhinesh', 'hi', 'hello'),
    ('hyochan', 'hi', 'hello'),
    ('haruna', 'hi', 'hello'),
    ('dhinesh', 'hi', 'hello'),
    ('hyochan', 'hi', 'hello'),
    ('haruna', 'hi', 'hello'),
    ('dhinesh', 'hi', 'hello'),
    ('hyochan', 'hi', 'hello'),
    ('haruna', 'hi', 'hello'),
    ('dhinesh', 'hi', 'hello'),
    ('hyochan', 'hi', 'hello'),
    ('haruna', 'hi', 'hello'),
    ('dhinesh', 'hi', 'hello'),
    ('hyochan', 'hi', 'hello'),
    ('haruna', 'hi', 'hello'),
    ('dhinesh', 'hi', 'hello')
;