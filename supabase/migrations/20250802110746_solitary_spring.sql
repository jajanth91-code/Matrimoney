-- Matrimony Database Structure
-- Create database
CREATE DATABASE IF NOT EXISTS matrimony;
USE matrimony;

-- Admin table
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user
INSERT INTO admin (user_name, password, email) VALUES 
('admin', 'admin123', 'admin@matrimony.com');

-- User details table
CREATE TABLE IF NOT EXISTS user_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    age INT,
    gender ENUM('male', 'female', 'other') NOT NULL,
    district VARCHAR(100),
    height VARCHAR(10),
    nakshatra VARCHAR(50),
    raasi VARCHAR(50),
    resident VARCHAR(100),
    native_place VARCHAR(100),
    complexion ENUM('Fair', 'Wheatish', 'Dusky', 'Dark') DEFAULT 'Fair',
    marital_status ENUM('Single', 'Married', 'Divorced', 'Widowed') DEFAULT 'Single',
    qualification VARCHAR(100),
    job VARCHAR(100),
    user_image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User interests/matches table
CREATE TABLE IF NOT EXISTS user_interests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES user_details(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES user_details(id) ON DELETE CASCADE
);

-- Messages table
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES user_details(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES user_details(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_user_gender ON user_details(gender);
CREATE INDEX idx_user_age ON user_details(age);
CREATE INDEX idx_user_district ON user_details(district);
CREATE INDEX idx_user_marital_status ON user_details(marital_status);
CREATE INDEX idx_user_active ON user_details(is_active);