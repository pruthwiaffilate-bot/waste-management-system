-- Waste Management System Database Schema

CREATE DATABASE IF NOT EXISTS waste_management_db;
USE waste_management_db;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(20) NOT NULL,
    second_name VARCHAR(20) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    residence_zip CHAR(8),
    password VARCHAR(255) NOT NULL,
    role INT DEFAULT 2,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Collection Personnel Table
CREATE TABLE collection_personnel (
    personnel_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(20) NOT NULL,
    second_name VARCHAR(20) NOT NULL,
    phone VARCHAR(20),
    collection_company VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Recycling Company Table
CREATE TABLE recycling_companies (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(50) NOT NULL,
    contact_person VARCHAR(50),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Collection Company Table
CREATE TABLE collection_companies (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(50) NOT NULL,
    registration_no VARCHAR(50) UNIQUE,
    contact_person VARCHAR(50),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Waste Reports Table
CREATE TABLE waste_reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    residence_zip CHAR(8),
    waste_type VARCHAR(100),
    description TEXT,
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending',
    assigned_to INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Campaigns Table
CREATE TABLE campaigns (
    campaign_id INT AUTO_INCREMENT PRIMARY KEY,
    campaign_name VARCHAR(100),
    description TEXT,
    start_date DATE,
    end_date DATE,
    residence_zip CHAR(8),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Campaign Participants Table
CREATE TABLE campaign_participants (
    participant_id INT AUTO_INCREMENT PRIMARY KEY,
    campaign_id INT,
    user_id INT,
    joined_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (campaign_id) REFERENCES campaigns(campaign_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- System Settings Table
CREATE TABLE system_settings (
    setting_id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create indexes for better performance
CREATE INDEX idx_user_username ON users(username);
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_report_user ON waste_reports(user_id);
CREATE INDEX idx_report_status ON waste_reports(status);
CREATE INDEX idx_campaign_zip ON campaigns(residence_zip);
CREATE INDEX idx_campaign_user ON campaign_participants(user_id);