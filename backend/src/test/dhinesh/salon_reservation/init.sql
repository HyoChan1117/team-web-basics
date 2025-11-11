CREATE DATABASE IF NOT EXISTS reservation;

USE reservation;

CREATE TABLE IF NOT EXISTS Users(
    user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    account VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    user_name VARCHAR(50) NOT NULL,
    role ENUM ('client', 'designer', 'manager') NOT NULL DEFAULT 'client',
    gender VARCHAR(10) NOT NULL,
    phone VARCHAR (15) NOT NULL,
    email VARCHAR(50) NOT NULL,
    birth DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Salon(
    salon_id INT PRIMARY KEY AUTO_INCREMENT,
    image JSON NOT NULL,
    introduction TEXT NOT NULL,
    map VARCHAR(255) NOT NULL,
    traffic JSON NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Service(
    service_id INT PRIMARY KEY AUTO_INCREMENT,
    service_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2)
);

CREATE TABLE IF NOT EXISTS HairStyle(
    hair_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Designer(
    designer_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    experiance INT NOT NULL,
    good_at VARCHAR(255) NOT NULL,
    personality VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON CURRENT_TIMESTAMP
    CONSTRAIN uq_designer_user UNIQUE (user_id),
    CONSTRAIN fk_designer_user FOREIGN KEY (user_id) REFERENCES Users(user_id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Reservation(
    reservation_id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    designer_id INT NOT NULL,
    Service VARCHAR(255) NOT NULL,
    requirement TEXT,
    date DATE NOT NULL,
    start_at TIME NOT NULL,
    end_at TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'checked_in', 'completed', 'cancelled', 'no_show') 
            NOT NULL DEFAULT 'pending',
    cancelled_at DATETIME,
    cancel_reason TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON CURRENT_TIMESTAMP,
    CONSTRAIN fk_reservation_client
        FOREIGN KEY (client_id) REFERENCES Users(user_id)
        ON DELETE CASCADE,
    CONSTRAIN fk_reservation_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id)
);

CREATE TABLE IF NOT EXISTS News(
    news_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    file JSON NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON DEFAULT CURRENT_TIMESTAMP
);

