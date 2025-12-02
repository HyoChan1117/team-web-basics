CREATE DATABASE IF NOT EXISTS reservation;

USE reservation;

CREATE TABLE IF NOT EXISTS Users(
    user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    account VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_name VARCHAR(50) NOT NULL,
    role ENUM ('client', 'designer', 'manager') NOT NULL DEFAULT 'client',
    gender VARCHAR(10) NOT NULL,
    phone VARCHAR (15) NOT NULL,
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
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Service(
    service_id INT PRIMARY KEY AUTO_INCREMENT,
    service_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2)
);

INSERT INTO Service (service_name, price) VALUES
    ('CUT', 10000),
    ('PERM', 30000),
    ('DYEING', 50000)
;

CREATE TABLE IF NOT EXISTS HairStyle(
    hair_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Designer(
    designer_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    experience INT NOT NULL,
    good_at VARCHAR(255) NOT NULL,
    personality VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_designer_user UNIQUE (user_id),
    CONSTRAINT fk_designer_user FOREIGN KEY (user_id) REFERENCES Users(user_id)
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
    end_at TIME,
    status ENUM('pending', 'confirmed', 'checked_in', 'completed', 'cancelled', 'no_show') 
            NOT NULL DEFAULT 'pending',
    cancelled_at DATETIME,
    cancel_reason TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_reservation_client
        FOREIGN KEY (client_id) REFERENCES Users(user_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_reservation_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id)
);

CREATE TABLE IF NOT EXISTS News(
    news_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    file JSON NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Timeoff(
    to_id INT PRIMARY KEY AUTO_INCREMENT,
    designer_id INT NOT NULL,
    start_at DATE NOT NULL,
    end_at DATE NOT NULL,
    CONSTRAINT fk_timeoff_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id)
);
