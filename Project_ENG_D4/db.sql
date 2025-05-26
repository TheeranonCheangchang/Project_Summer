CREATE DATABASE stock_management;
USE stock_management;

-- ตารางผู้ใช้
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Super_admin', 'admin','employee','Root') NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

INSERT INTO users (username, password, role, firstname, lastname, email) 
VALUES ('admin', MD5('1234'), 'admin', 'My', 'Admin', 'admin@example.com');
INSERT INTO users (username, password, role, firstname, lastname, email) 
VALUES ('employee', MD5('1234'), 'employee', 'New', 'Employee', 'employee@example.com');
INSERT INTO users (username, password, role, firstname, lastname, email) 
VALUES ('Super_admin', MD5('1234'), 'Super_admin', 'Super', 'Admin', 'Super_admin@example.com');
INSERT INTO users (username, password, role, firstname, lastname, email) 
VALUES ('Root', MD5('1234'), 'Root', 'My', 'Root', 'Root@example.com');

-- ตารางหมวดหมู่
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);
    ALTER TABLE users
    ADD COLUMN category_id INT,
    ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;

-- ตารางสินค้า
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

--ตารางแจ้งซ่อม
CREATE TABLE repairs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_code VARCHAR(50) NOT NULL,       -- รหัสอุปกรณ์
    device_name VARCHAR(255) NOT NULL,      -- ชื่ออุปกรณ์
    problem TEXT,                           -- ปัญหาที่พบ
    phone VARCHAR(20),                      -- เบอร์โทรศัพท์
    repair_date DATE NOT NULL,              -- วันที่แจ้งซ่อม
    note TEXT,                              -- หมายเหตุ
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);