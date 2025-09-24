CREATE DATABASE IF NOT EXISTS backend;

USE backend;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    account VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM ('client', 'designer', 'manager') NOT NULL DEFAULT 'client',
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
    name VARCHAR(255) NOT NULL,
    gender VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (service_id)
);

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
    service_id INT NOT NULL,
    start_at DATETIME NOT NULL,
    end_at DATETIME NOT NULL,
    status ENUM ('pending', 'confirmed', 'checked_in', 'completed', 'cancelled', 'no_show') NOT NULL DEFAULT 'pending',
    cancelled_at DATETIME,
    cancel_reason TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (reservation_id),
    CONSTRAINT fk_reservation_client FOREIGN KEY (client_id) REFERENCES Users(user_id),
    CONSTRAINT fk_reservation_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id),
    CONSTRAINT fk_reservation_service FOREIGN KEY (service_id) REFERENCES Service(service_id)
);

CREATE TABLE IF NOT EXISTS ReservationSlot (
    reservation_id INT,
    slot_date DATE NOT NULL,
    slot_time TIME NOT NULL,
    designer_id INT NOT NULL,
    PRIMARY KEY (reservation_id),
    CONSTRAINT fk_slot_reservation FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id) ON DELETE CASCADE,
    CONSTRAINT fk_slot_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id),
    CONSTRAINT uk_rs_unique UNIQUE (slot_date, slot_time, designer_id)
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

CREATE TABLE IF NOT EXISTS WorkingHour (
    wh_id INT AUTO_INCREMENT,
    designer_id INT NOT NULL,
    weekday TINYINT NOT NULL COMMENT '근무일자(요일을 따로 쓰려면 tinyint/enum으로 변경 가능)',
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    PRIMARY KEY (wh_id),
    CONSTRAINT fk_workinghour_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id)
);

CREATE TABLE IF NOT EXISTS TimeOff (
    to_id INT AUTO_INCREMENT,
    designer_id INT NOT NULL,
    start_at DATE NOT NULL,
    end_at DATE NOT NULL,
    PRIMARY KEY (to_id),
    CONSTRAINT fk_timeoff_designer FOREIGN KEY (designer_id) REFERENCES Users(user_id)
);