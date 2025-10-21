CREATE DATABASE IF NOT EXISTS backend;

USE backend;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT,
    account VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    role ENUM ('client', 'designer', 'manager') NOT NULL DEFAULT 'client',
    gender VARCHAR(100) NOT NULL,
    phone VARCHAR(30),
    birth DATE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS Salon (
    salon_id INT AUTO_INCREMENT,
    image JSON NOT NULL COMMENT 'URL 배열 (캐러셀)',
    introduction TEXT NOT NULL,
    information JSON NOT NULL COMMENT 'Address, OpeningHour, Holiday, Phone',
    map VARCHAR(255) NOT NULL,
    traffic JSON NOT NULL COMMENT 'Bus, Parking, Directions',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (salon_id)
);

CREATE TABLE IF NOT EXISTS Service (
    service_id INT AUTO_INCREMENT,
    service_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (service_id)
);

INSERT INTO Service (service_name, price) VALUES
    ('CUT', 10000),
    ('PERM', 30000),
    ('DYEING', 50000)
;

CREATE TABLE IF NOT EXISTS HairStyle (
    hair_id INT AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (hair_id)
);

CREATE TABLE IF NOT EXISTS Designer (
    designer_id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    experience INT NOT NULL,
    good_at VARCHAR(255) NOT NULL,
    personality VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (designer_id),
    CONSTRAINT uq_designer_user UNIQUE (user_id),
    CONSTRAINT fk_designer_user FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Reservation (
    reservation_id INT AUTO_INCREMENT,
    client_id INT NOT NULL,
    designer_id INT NOT NULL,
    service VARCHAR(255) NOT NULL,
    requirement TEXT,
    date DATE NOT NULL,
    start_at TIME NOT NULL,
    end_at TIME NOT NULL,
    status ENUM ('pending', 'confirmed', 'checked_in', 'completed', 'cancelled', 'no_show') NOT NULL DEFAULT 'pending',
    cancelled_at DATETIME,
    cancel_reason TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (reservation_id),
    CONSTRAINT fk_reservation_client 
        FOREIGN KEY (client_id) REFERENCES Users(user_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_reservation_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id)
);

CREATE TABLE IF NOT EXISTS StorePolicy (
    policy_id INT AUTO_INCREMENT,
    cancel_deadline TIME NOT NULL,
    PRIMARY KEY (policy_id)
);

CREATE TABLE IF NOT EXISTS News (
    news_id INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content VARCHAR(100) NOT NULL,
    file VARCHAR(255),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (news_id)
);

CREATE TABLE IF NOT EXISTS TimeOff (
    to_id INT AUTO_INCREMENT,
    designer_id INT NOT NULL,
    start_at DATE NOT NULL,
    end_at DATE NOT NULL,
    PRIMARY KEY (to_id),
    CONSTRAINT fk_timeoff_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id)
);


INSERT INTO TimeOff (designer_id, start_at, end_at) VALUES
('1', '2025-10-02', '2025-10-05');

INSERT INTO TimeOff (designer_id, start_at, end_at) VALUES
('2', '2025-10-04', '2025-10-07');
