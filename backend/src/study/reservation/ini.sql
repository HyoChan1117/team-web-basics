CREATE DATABASE IF NOT EXISTS simple_reservation
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE simple_reservation;

-- 예약 가능한 서비스(메뉴) 테이블 (필요 없으면 생략 가능)
CREATE TABLE IF NOT EXISTS service (
  service_id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  duration_min INT NOT NULL DEFAULT 60
);

-- 예약 테이블
CREATE TABLE IF NOT EXISTS reservation (
  reservation_id BIGINT PRIMARY KEY AUTO_INCREMENT,
  service_id BIGINT NOT NULL,
  customer_name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  reservation_date DATE NOT NULL,
  time_slot VARCHAR(20) NOT NULL,              -- 예: "09:00", "10:30"
  note VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_reservation_service
    FOREIGN KEY (service_id) REFERENCES service(service_id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  -- 같은 서비스/날짜/시간대에 한 건만 허용 (중복예약 방지 핵심)
  UNIQUE KEY uq_service_date_time (service_id, reservation_date, time_slot),
  INDEX idx_date (reservation_date)
);

INSERT INTO service (name, duration_min) VALUES
('커트', 30), ('염색', 90), ('펌', 120);
