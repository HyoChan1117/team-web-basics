USE level_up;

create table guestbook(
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    content VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

INSERT INTO guestbook (name, content, created_at) VALUES ('haruna', 'hahahaha', NOW()),
('hyochan', 'wawawawa', NOW()),('dinesh', 'fufufufufu', NOW());