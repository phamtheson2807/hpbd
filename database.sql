-- Tạo database cho trang sinh nhật
CREATE DATABASE birthday_pages CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE birthday_pages;

-- Bảng chính lưu thông tin sinh nhật
CREATE TABLE birthday_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    short_id VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    birth_date VARCHAR(20) NOT NULL,
    title VARCHAR(500) NOT NULL,
    music_filename VARCHAR(255) NULL,
    music_original_name VARCHAR(255) NULL,
    music_size INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_short_id (short_id),
    INDEX idx_created_at (created_at)
);

-- Bảng lưu lời chúc
CREATE TABLE birthday_wishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    birthday_id INT NOT NULL,
    wish_text TEXT NOT NULL,
    order_index INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (birthday_id) REFERENCES birthday_data(id) ON DELETE CASCADE,
    INDEX idx_birthday_id (birthday_id)
);

-- Bảng thống kê lượt xem (tùy chọn)
CREATE TABLE birthday_views (
    id INT AUTO_INCREMENT PRIMARY KEY,
    birthday_id INT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (birthday_id) REFERENCES birthday_data(id) ON DELETE CASCADE,
    INDEX idx_birthday_id (birthday_id),
    INDEX idx_viewed_at (viewed_at)
);
