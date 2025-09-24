-- Create database --
CREATE DATABASE lab4;

-- use db --
use lab4;

-- create table -- 
CREATE TABLE board(
    postID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    title TEXT NOT NULL,
    messageArea TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE comment(
    commentID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    messageArea TEXT NOT NULL,
    postID INT NOT NULL,
    CONSTRAINT FK_postID FOREIGN KEY (postID)
    REFERENCES board (postID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

INSERT INTO board (name, messageArea) VALUES
    ("dhinesh", "hi"),
    ("kim", "no"),
    ("yoon", "yes"),
    ("park", "bye")
    
