CREATE DATABASE soap_system;
USE soap_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('doctor', 'nurse', 'admin') NOT NULL
);

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    symptoms TEXT,  -- Subjective: Patient-reported symptoms
    medical_history TEXT,  -- Subjective: Medical history
    blood_pressure VARCHAR(20),  -- Objective: BP reading
    heart_rate INT,  -- Objective: HR in BPM
    temperature DECIMAL(4,1),  -- Objective: Temp in °C
    weight DECIMAL(5,2),  -- Objective: Weight in kg
    diagnostic_tests TEXT  -- Objective: Test results
);

CREATE TABLE soap_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    subjective TEXT,
    objective TEXT,
    assessment TEXT,
    plan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE patients 
ADD COLUMN diagnosis TEXT,
ADD COLUMN treatment_plan TEXT,
ADD COLUMN medications TEXT,
ADD COLUMN therapies TEXT,
ADD COLUMN follow_ups TEXT;

