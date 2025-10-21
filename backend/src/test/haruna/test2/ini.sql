CREATE DATABASE backend2;

USE backend2;

-- 개전 정보
CREATE TABLE IF NOT EXISTS Users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    account VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    gender VARCHAR(100) NOT NULL,
    role ENUM('client', 'designer', 'manager') NOT NULL DEFAULT 'client',
    phone VARCHAR(30), 
    birth DATE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- service 내용
CREATE TABLE IF NOT EXISTS Service (
    service_id INT AUTO_INCREMENT,
    service_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (service_id)
);

INSERT INTO Service (service_name, price) VALUES
        ('CUT',40000),
        ('PERM', 80000),
        ('COLOR', 60000)
;

-- 예약 내용
CREATE TABLE IF NOT EXISTS Reservation (
    reservation_id INT AUTO_INCREMENT,
    client_id INT NOT NULL,
    designer_id INT NOT NULL,
    requirement TEXT,
    service VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    start_at TIME NOT NULL,
    end_at TIME ,
    status ENUM('pending', 'confirmed', 'checked_in', 'completed', 'cancelled', 'no_show') NOT NULL DEFAULT 'pending',
    cancelled_at DATETIME,
    cancel_reason TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (reservation_id),
    CONSTRAINT FK_reservation_client 
        FOREIGN KEY (client_id) REFERENCES Users(user_id)
        ON DELETE CASCADE,
    CONSTRAINT FK_reservation_designer 
        FOREIGN KEY (designer_id) REFERENCES Users(user_id)  
);

-- 예약 내목
CREATE TABLE IF NOT EXISTS ReservationService (
    reservation_id INT NOT NULL,  
    service_id     INT NOT NULL,
    qty            INT NOT NULL DEFAULT 1,
    unit_price     DECIMAL(10,2) NOT NULL,
    PRIMARY KEY(reservation_id, service_id),
    CONSTRAINT FK_ReservationService_Reservation 
    FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES Service(service_id)
        ON UPDATE CASCADE ON DELETE RESTRICT    
);