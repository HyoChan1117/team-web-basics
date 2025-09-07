use test;

CREATE TABLE guestbook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    content VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO guestbook (name, content) VALUES
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant'),
('saitou', 'Im Hungry'), ('pito', 'cat'),('king', 'ant')
;