-- Create the database
CREATE DATABASE IF NOT EXISTS breyer_college;

-- Use the database
USE breyer_college;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add these columns to the users table to support password reset functionality
ALTER TABLE users
  ADD `reset_token_hash` VARCHAR(64) NULL DEFAULT NULL,
  ADD `reset_token_expires_at` DATETIME NULL DEFAULT NULL,
  ADD UNIQUE (`reset_token_hash`);

-- Create the admins table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
