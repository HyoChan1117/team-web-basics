CREATE DATABASE backend;

USE backend;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT,
    account VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    gender VARCHAR(100) NOT NULL,
    role ENUM('client', 'designer', 'manager') NOT NULL DEFAULT 'client',
    phone VARCHAR(30),
    birth DATE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
);

-- salon정보
CREATE TABLE IF NOT EXISTS Salon (
    salon_id INT AUTO_INCREMENT,
    manager_id INT NOT NULL,
    image JSON NOT NULL COMMENT 'array of image URLs',
    introduction TEXT NOT NULL,
    information JSON NOT NULL COMMENT 'Address, OpeningHour, Holiday, Phone',
    map VARCHAR(255) NOT NULL,
    traffic JSON NOT NULL COMMENT 'Bus, Parking, Directions',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (salon_id),
    CONSTRAINT FK_Salon_Manager FOREIGN KEY (manager_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- 사비스 내용
CREATE TABLE IF NOT EXISTS Service (
    service_id INT AUTO_INCREMENT,
    service_name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY (service_id)
);

-- 서비스 내용, 가격 관리
CREATE TABLE ReservationService (
  reservation_id INT NOT NULL,
  service_id     INT NOT NULL,
  qty            INT NOT NULL DEFAULT 1,
  unit_price     DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (reservation_id, service_id),
  FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES Service(service_id)
    ON UPDATE CASCADE ON DELETE RESTRICT
);

-- 예약 내용
CREATE TABLE IF NOT EXISTS Reservation (
    reservation_id INT AUTO_INCREMENT,
    client_id INT NOT NULL,
    designer_id INT NOT NULL,
    date DATE NOT NULL,
    start_at TIME NOT NULL,
    end_at TIME,
    status ENUM('pending', 'confirmed', 'checked_in', 'completed', 'cancelled', 'no_show') NOT NULL DEFAULT 'pending',
    requirement TEXT,
    cancelled_at DATETIME,
    cancel_reason TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (reservation_id),
    CONSTRAINT FK_Reservation_Client FOREIGN KEY (client_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FK_Reservation_Designer FOREIGN KEY (designer_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);



CREATE TABLE IF NOT EXISTS HairStyle (
    hair_id INT AUTO_INCREMENT,
    manager_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (hair_id),
    CONSTRAINT FK_HairStyle_Manager FOREIGN KEY (manager_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Designer (
    designer_id INT AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    experience INT NOT NULL,
    good_at VARCHAR(255) NOT NULL,
    personality VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (designer_id),
    CONSTRAINT FK_Designer_User FOREIGN KEY (user_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);



CREATE TABLE IF NOT EXISTS StorePolicy (
    policy_id INT AUTO_INCREMENT,
    cancel_deadline TIME NOT NULL,
    PRIMARY KEY (policy_id)
);

CREATE TABLE IF NOT EXISTS NEWS (
    news_id INT AUTO_INCREMENT,
    manager_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content VARCHAR(100) NOT NULL,
    file VARCHAR(255),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (news_id),
    CONSTRAINT FK_NEWS_Manager FOREIGN KEY (manager_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS WorkingHour (
    wh_id INT AUTO_INCREMENT,
    designer_id INT NOT NULL,
    weekday TINYINT NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    PRIMARY KEY (wh_id),
    CONSTRAINT FK_WorkingHour_Designer FOREIGN KEY (designer_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS TimeOff (
    to_id INT AUTO_INCREMENT,
    designer_id INT NOT NULL,
    start_at DATE NOT NULL,
    end_at DATE NOT NULL,
    PRIMARY KEY (to_id),
    CONSTRAINT FK_TimeOff_Designer FOREIGN KEY (designer_id)
        REFERENCES Users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);


