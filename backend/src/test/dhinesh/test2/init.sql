-- create a databases --
CREATE DATABASE foo;

-- use database --
use foo;

-- create a table --
CREATE TABLE guestbook (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    messageArea VARCHAR(300) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);