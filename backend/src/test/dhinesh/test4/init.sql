-- create a database --
CREATE DATABASE lab4;

-- use database --
USE lab4;

-- create a board table --
CREATE TABLE board(
    postID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    title TEXT NOT NULL,
    messageArea TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- create a comment table --
CREATE TABLE comment(
    commentID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    messageArea TEXT NOT NULL,
    postID INT NOT NULL,
    CONSTRAINT FK_postID FOREIGN KEY (postID)
    REFERENCES board (postID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);