-- Create database
CREATE DATABASE student_records;

-- Use database
USE student_records;

-- Create table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT CHECK (age > 0),
    enrollment_date DATE
);

-- Insert records
INSERT INTO students (name, email, age, enrollment_date) VALUES
('Alice Smith', 'alice@example.com', 19, '2023-02-15'),
('Bob Johnson', 'bob@example.com', 22, '2022-12-10'),
('Tim Tom', 'ttim@albany.edu', 17, '2023-03-22'),
('Dana White', 'dana@example.com', 21, '2021-11-05'),
('Austin', 'award@albany.edu', 23, '2023-01-30');

-- SQL commands:

-- Retrieve all records
SELECT * FROM students;

-- Students older than 18
SELECT * FROM students WHERE age > 18;

-- Students enrolled after a specific date
SELECT * FROM students WHERE enrollment_date > '2023-01-01';

-- Update a student's email
UPDATE students SET email = 'alice.new@example.com' WHERE id = 1;

-- Delete a record
DELETE FROM students WHERE id = 3;