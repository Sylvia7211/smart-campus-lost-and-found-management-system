-- ==========================================
-- SMART CAMPUS LOST & FOUND MANAGEMENT SYSTEM
-- Database Script
-- ==========================================

CREATE DATABASE IF NOT EXISTS smartcampus;
USE smartcampus;

-- =========================
-- USERS TABLE
-- =========================
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    reg_number VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('student','admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- LOST ITEMS TABLE
-- =========================
CREATE TABLE Lost_Items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location_lost VARCHAR(255) NOT NULL,
    date_lost DATE NOT NULL,
    image VARCHAR(255),
    reward DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('Searching','Claimed') DEFAULT 'Searching',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES Users(id)
        ON DELETE CASCADE
);

-- =========================
-- FOUND ITEMS TABLE
-- =========================
CREATE TABLE Found_Items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location_found VARCHAR(255) NOT NULL,
    date_found DATE NOT NULL,
    image VARCHAR(255),
    status ENUM('Available','Claimed') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES Users(id)
        ON DELETE CASCADE
);

-- =========================
-- CLAIMS TABLE
-- =========================
CREATE TABLE Claims (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lost_item_id INT NULL,
    found_item_id INT NULL,
    claimant_id INT NOT NULL,
    claim_message TEXT,
    status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (claimant_id) REFERENCES Users(id),
    FOREIGN KEY (lost_item_id) REFERENCES Lost_Items(id),
    FOREIGN KEY (found_item_id) REFERENCES Found_Items(id)
);

-- =========================
-- NOTIFICATIONS TABLE
-- =========================
CREATE TABLE Notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES Users(id)
        ON DELETE CASCADE
);