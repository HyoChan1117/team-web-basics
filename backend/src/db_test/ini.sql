CREATE DATABASE IF NOT EXISTS test;

USE test;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL UNIQUE,
    account VARCHAR(255) NOT NULL,
    pw VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS Designer (
    designer_id INT AUTO_INCREMENT,
    career VARCHAR(100) NOT NULL,
    user_id INT,
    PRIMARY KEY (designer_id),
    CONSTRAINT fk_designer_user FOREIGN KEY (user_id) REFERENCES Users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

INSERT INTO Users (user_name, account, pw) VALUES
    ('HARUNA', 'haruna', 'haruna'),
    ('HYOCHAN', 'hyochan', 'hyochan'),
    ('DHINESH', 'dhinesh', 'dhinesh')
;

INSERT INTO Designer (career, user_id) VALUES
    ("1년", 1),
    ("2년", 2),
    ("3년", 3)
;