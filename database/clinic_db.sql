-- Create the database
CREATE DATABASE IF NOT EXISTS clinic_db;
USE clinic_db;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2024 at 01:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `clinic_db`

-- --------------------------------------------------------

-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `PatientID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `HealthNumber` varchar(50) NOT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PatientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `DoctorID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Specialty` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Availability` text DEFAULT NULL,
  PRIMARY KEY (`DoctorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `MedicineID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Manufacturer` varchar(100) DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`MedicineID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL AUTO_INCREMENT,
  `PatientID` int(11) NOT NULL,
  `DoctorID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `AppointmentTime` time NOT NULL,
  `Details` text DEFAULT NULL,
  `IsNewPatient` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`AppointmentID`),
  KEY `PatientID` (`PatientID`),
  KEY `DoctorID` (`DoctorID`),
  FOREIGN KEY (`PatientID`) REFERENCES `patients` (`PatientID`),
  FOREIGN KEY (`DoctorID`) REFERENCES `doctors` (`DoctorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `BedID` int(11) NOT NULL AUTO_INCREMENT,
  `BedNumber` varchar(10) NOT NULL,
  `Status` enum('Available','Occupied') NOT NULL,
  `PatientID` int(11) DEFAULT NULL,
  PRIMARY KEY (`BedID`),
  KEY `PatientID` (`PatientID`),
  FOREIGN KEY (`PatientID`) REFERENCES `patients` (`PatientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `clinicinfo`
--

CREATE TABLE `clinicinfo` (
  `ClinicID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `ContactNumber` varchar(15) NOT NULL,
  `OpeningHours` text NOT NULL,
  PRIMARY KEY (`ClinicID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `medicineorders`
--

CREATE TABLE `medicineorders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `PatientID` int(11) NOT NULL,
  `DoctorID` int(11) NOT NULL,
  `MedicineID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `PatientID` (`PatientID`),
  KEY `MedicineID` (`MedicineID`),
  KEY `DoctorID` (`DoctorID`),
  FOREIGN KEY (`PatientID`) REFERENCES `patients` (`PatientID`),
  FOREIGN KEY (`MedicineID`) REFERENCES `medicines` (`MedicineID`),
  FOREIGN KEY (`DoctorID`) REFERENCES `doctors` (`DoctorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('admin','doctor','patient') NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into tables
--

-- Clinic Info
INSERT INTO `clinicinfo` (`ClinicID`, `Name`, `Address`, `ContactNumber`, `OpeningHours`) VALUES
(1, 'Dallas Family Clinic', '123 Main St', '123-456-7890', 'Mon-Fri: 9am - 5pm');

-- Patients
INSERT INTO `patients` (`FirstName`, `LastName`, `PhoneNumber`, `HealthNumber`, `PostalCode`, `Country`, `Address`, `City`) VALUES
('Brian', 'Granda', '1234567890', 'HN123456', '2000', 'Australia', '1 Clinic Street', 'Sydney'),
('Santiago', 'Ortiz', '1234567891', 'HN123457', '2001', 'Australia', '2 Clinic Street', 'Melbourne'),
('Sagar', 'Khatiwada', '1234567892', 'HN123458', '2002', 'Australia', '3 Clinic Street', 'Brisbane'),
('Sushil', 'Sapkota', '1234567893', 'HN123459', '2003', 'Australia', '4 Clinic Street', 'Perth');

-- Doctors
INSERT INTO `doctors` (`FirstName`, `LastName`, `PhoneNumber`, `Specialty`, `Email`, `Availability`) VALUES
('Samia', 'Sultana', '1234567894', 'Cardiology', 'samia.sultana@example.com', 'Mon-Fri: 9am - 5pm'),
('Saiful', 'Islam', '1234567895', 'Neurology', 'saiful.islam@example.com', 'Mon-Fri: 9am - 5pm'),
('Syed', 'Altaf', '1234567896', 'Pediatrics', 'syed.altaf@example.com', 'Mon-Fri: 9am - 5pm');

-- Medicines
INSERT INTO `medicines` (`Name`, `Manufacturer`, `ExpiryDate`, `Quantity`, `Price`) VALUES
('Paracetamol', 'Pharma Inc.', '2025-12-31', 100, 5.00),
('Ibuprofen', 'Medicare Ltd.', '2024-11-30', 200, 10.00),
('Amoxicillin', 'HealthCorp', '2023-10-31', 150, 15.00);

-- Beds
INSERT INTO `beds` (`BedNumber`, `Status`, `PatientID`) VALUES
('B001', 'Available', NULL),
('B002', 'Occupied', 1),
('B003', 'Available', NULL),
('B004', 'Occupied', 2),
('B005', 'Available', NULL);

-- Appointments
INSERT INTO `appointments` (`PatientID`, `DoctorID`, `AppointmentDate`, `AppointmentTime`, `Details`, `IsNewPatient`) VALUES
(1, 1, '2024-06-05', '09:00:00', 'Regular check-up', 0),
(2, 2, '2024-06-06', '10:00:00', 'Follow-up', 1),
(3, 3, '2024-06-07', '11:00:00', 'Consultation', 0),
(4, 1, '2024-06-08', '12:00:00', 'Routine visit', 1);

COMMIT;