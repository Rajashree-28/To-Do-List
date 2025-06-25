-- Create Database
CREATE DATABASE IF NOT EXISTS bca_r1;
USE bca_r1;

-- Create Table
CREATE TABLE IF NOT EXISTS activitylist (
    ActID INT AUTO_INCREMENT PRIMARY KEY,
    ActTitle VARCHAR(255) NOT NULL,
    ActDesc TEXT NOT NULL
);
