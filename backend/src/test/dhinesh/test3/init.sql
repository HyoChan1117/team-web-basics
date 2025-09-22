-- create a database --
CREATE DATABASE kin;

-- use database --
USE kin;

-- create table --
CREATE TABLE guestbook(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (50) NOT NULL,
    messageArea TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO guestbook (name, messageArea) VALUES
    ("dhinesh", "test1"),
    ("dhinesh", "this exam is easy"),
    ("dhinesh", "hello"),
    ("dhinesh", "you are nice"),
    ("dhinesh", "hahaha"),
    ("dhinesh", "no more test"),
    ("dhinesh", "bye"),
    ("dhinesh", "im new to korea"),
    ("dhinesh", "holla"),
    ("dhinesh", "test4"),
    ("dhinesh", "test8"),
    ("dhinesh", "test6"),
    ("dhinesh", "test3"),
    ("dhinesh", "test7"),
    ("dhinesh", "this exam is easy"),
    ("ragul", "hello"),
    ("giri", "you are nice"),
    ("sundar", "hahaha"),
    ("steve", "no more test"),
    ("justin", "bye"),
    ("putin", "im new to korea"),
    ("elon", "holla"),
    ("trump", "test4"),
    ("bill", "test8"),
    ("mark", "test6"),
    ("yoon", "test3")
