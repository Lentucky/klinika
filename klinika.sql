-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
-- Host: 127.0.0.1    Database: klinika
-- ------------------------------------------------------
-- Server version 5.5.5-10.4.32-MariaDBdentists

-- Table structure for table `account`
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `staff_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `staff`
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL, -- Roles like receptionist, cashier, etc.
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `appointments`
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `dentist_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL, -- Staff member assigned to this appointment (optional)
  `appointment_date` datetime NOT NULL,
  `reason_for_visit` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Scheduled',
  `notes` text DEFAULT NULL,
  `appointment_type` varchar(100) DEFAULT NULL,
  `service_cost` decimal(10, 2) NOT NULL,  -- Service cost
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`appointment_id`),
  KEY `patient_id` (`patient_id`),
  KEY `dentist_id` (`dentist_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`dentist_id`) REFERENCES `dentists` (`dentist_id`),
  CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) -- Linking appointments to staff
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `payments`
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL, -- Staff handling the payment (e.g., cashier)
  `payment_amount` decimal(10, 2) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) NOT NULL,  -- Cash, Credit Card, etc.
  PRIMARY KEY (`payment_id`),
  KEY `appointment_id` (`appointment_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) -- Linking payment to staff member
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `patients`
DROP TABLE IF EXISTS `patients`;
CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `dentists`
DROP TABLE IF EXISTS `dentists`;
CREATE TABLE `dentists` (
  `dentist_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `office_location` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`dentist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data into the `staff` table
INSERT INTO `staff` (first_name, last_name, role, email, phone_number) VALUES
('John', 'Doe', 'Cashier', 'john.doe@klinika.com', '09123456789'),
('Jane', 'Smith', 'Receptionist', 'jane.smith@klinika.com', '09187654321');

-- Insert sample data into the `payments` table
INSERT INTO `payments` (appointment_id, staff_id, payment_amount, payment_method) VALUES
(1, 1, 1500.00, 'Cash');

-- Insert sample data for other tables
INSERT INTO `account` VALUES (1,'admin','admin_password');
INSERT INTO `patients` VALUES (1,'Anna','Dagos','2003-02-15','Female','09123456789','anna@gmail.com','Cabuyao City, Laguna','2024-09-20 11:19:24','2024-09-20 11:19:24');
