CREATE DATABASE hospital_queue_management;
USE hospital_queue_management;
CREATE TABLE departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL
);

INSERT INTO departments (department_name) VALUES
('Cardiology'),
('Neurology'),
('Orthopedics'),
('ENT'),
('Pediatrics');
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    age INT,
    gender VARCHAR(20),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    password VARCHAR(100)
);

INSERT INTO patients
(full_name,age,gender,phone,email,address,password)
VALUES
('Bernice Jenisha',21,'Female','9876543210',
'bernice@gmail.com','Chennai','patient123'),
('John Mathew',35,'Male','9876543211',
'john@gmail.com','Coimbatore','patient123'),
('Priya Joseph',29,'Female','9876543212',
'priya@gmail.com','Madurai','patient123');
CREATE TABLE doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_name VARCHAR(100),
    specialization VARCHAR(100),
    department_id INT,
    phone VARCHAR(20),
    email VARCHAR(100),
    experience INT,
    password VARCHAR(100),
    FOREIGN KEY (department_id)
    REFERENCES departments(department_id)
);

INSERT INTO doctors
(doctor_name,specialization,department_id,phone,email,experience,password)
VALUES
('Dr. Priya Sharma','Cardiology',1,'9999991111','doctor@gmail.com',10,'doctor123'),
('Dr. Rahul Kumar','Neurology',2,'9999992222','rahul@gmail.com',8,'doctor123'),
('Dr. Anjali Menon','Orthopedics',3,'9999993333','anjali@gmail.com',12,'doctor123'),
('Dr. Joseph Paul','ENT',4,'9999994444','joseph@gmail.com',9,'doctor123'),
('Dr. Sneha Iyer','Pediatrics',5,'9999995555','sneha@gmail.com',7,'doctor123');
CREATE TABLE receptionists (
    receptionist_id INT AUTO_INCREMENT PRIMARY KEY,
    receptionist_name VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    password VARCHAR(100)
);

INSERT INTO receptionists
(receptionist_name,phone,email,password)
VALUES
('Reception Desk','9876500000','reception@gmail.com','reception123');
CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100)
);

INSERT INTO admins
(name,email,password)
VALUES
('Administrator','admin@gmail.com','admin123');
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_date DATE,
    appointment_time VARCHAR(20),
    status VARCHAR(30) DEFAULT 'Waiting',

    FOREIGN KEY (patient_id)
    REFERENCES patients(patient_id),

    FOREIGN KEY (doctor_id)
    REFERENCES doctors(doctor_id)
);

INSERT INTO appointments
(patient_id,doctor_id,appointment_date,appointment_time,status)
VALUES
(1,1,'2026-09-15','10:00 AM','Waiting'),
(2,2,'2026-09-15','11:00 AM','Waiting'),
(3,3,'2026-09-16','09:00 AM','Completed');
CREATE TABLE queue_tokens (
    queue_id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT,
    token_number VARCHAR(20),
    waiting_status VARCHAR(30),
    estimated_wait_time INT,

    FOREIGN KEY (appointment_id)
    REFERENCES appointments(appointment_id)
);

INSERT INTO queue_tokens
(appointment_id,token_number,waiting_status,estimated_wait_time)
VALUES
(1,'A-01','Waiting',20),
(2,'A-02','Waiting',15),
(3,'A-03','Completed',0);