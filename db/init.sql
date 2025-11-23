CREATE DATABASE IF NOT EXISTS sqli_lab;
USE sqli_lab;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    password VARCHAR(255)  -- We'll use a fake hash: '5f4dcc3b5aa765d61d8327deb882cf99' (admin123)
);

INSERT INTO users (id, username, password) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99'),
(2, 'alice', 'e10adc3949ba59abbe56e057f20f883e'),  -- 123456
(3, 'bob', '827ccb0eea8a706c4c34a16891f84e7b');    -- toor

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    price DECIMAL(10,2)
);

INSERT INTO products (name, price) VALUES
('Laptop', 999.99),
('Mouse', 25.50),
('Keyboard', 75.00);