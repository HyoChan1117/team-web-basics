-- create a databases --
CREATE DATABASE bar;

-- use database--
use bar;

-- create table --
CREATE TABLE guestbook(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    messageArea TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
