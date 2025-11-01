-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 01, 2025 at 04:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `Fee`
--

CREATE TABLE `Fee` (
  `fee_id` int(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Fee`
--

INSERT INTO `Fee` (`fee_id`, `class`, `amount`) VALUES
(1, 'Nursery', 18000.00),
(2, 'KG', 20400.00),
(3, '1st', 24000.00),
(4, '2nd', 26400.00),
(5, '3rd', 30000.00),
(6, '4th', 32400.00),
(7, '5th', 36000.00),
(8, '6th', 38400.00),
(9, '7th', 42000.00),
(10, '8th', 44400.00),
(11, '9th', 48000.00),
(12, '10th', 50400.00),
(13, '11th', 54000.00),
(14, '12th', 57600.00);

-- --------------------------------------------------------

--
-- Table structure for table `Student`
--

CREATE TABLE `Student` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `class` varchar(20) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Student`
--

INSERT INTO `Student` (`student_id`, `first_name`, `last_name`, `dob`, `class`, `contact_number`, `address`, `email`, `gender`, `created_at`) VALUES
(1, 'Shivank', 'Kamboj', '2003-06-05', '10th', '7500718539', 'Raipur Road', 'ayushkamboj7500@gmail.com', 'Male', '2025-10-24 10:10:30'),
(4, 'Aditi', 'Chhabra', '2005-03-15', '10th', '9876543210', 'Rajpur Road', 'aditi123@gmail.com', 'Female', '2025-10-24 10:24:58'),
(5, 'Varun', 'Sharma', '2015-10-09', '5th', '9898989898', 'Karanpur', 'varun123@gmail.com', 'Male', '2025-10-24 10:36:58'),
(6, 'Harshita', 'Kundu', '2007-08-14', '8th', '9292929292', 'Haryana', 'harshita123@gmail.com', 'Female', '2025-10-24 10:38:13'),
(7, 'Ankit', 'Sharma', '2003-01-09', '9th', '8787878787', 'Dharampur', 'ankit123@gmail.com', 'Male', '2025-10-24 10:40:58'),
(8, 'Kunal', 'Kashqap', '2001-03-03', '12th', '7676767676', 'Delhi', 'kunal123@gmail.com', 'Male', '2025-10-24 10:42:29'),
(9, 'Aditya', 'Sharma', '2009-09-09', '8th', '9090909090', 'Gaziabad', 'aditya123@gmail.com', 'Male', '2025-10-24 10:45:02'),
(10, 'Ayush', 'Kamboj', '2003-06-05', '12th', '7979797979', 'Raipur', 'ayush123@gmail.com', 'Male', '2025-10-24 10:47:26'),
(11, 'Akshit', 'Kamboj', '2001-03-29', '12th', '6789678968', 'Raipur Road', 'akshit123@gmail.com', 'Male', '2025-10-24 18:36:39'),
(12, 'Khushi', 'Kamboj', '2003-03-01', '12th', '6789678960', 'Raipur Road', 'khushi123@gmail.com', 'Female', '2025-10-24 18:37:07'),
(13, 'Akul', 'Kamboj', '2003-03-19', '12th', '6789678961', 'Raipur Road', 'akul123@gmail.com', 'Male', '2025-10-24 18:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `Student_fee`
--

CREATE TABLE `Student_fee` (
  `student_id` int(11) NOT NULL,
  `total_fee` int(11) DEFAULT NULL,
  `amount_paid` int(11) DEFAULT NULL,
  `amount_left` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Student_fee`
--

INSERT INTO `Student_fee` (`student_id`, `total_fee`, `amount_paid`, `amount_left`) VALUES
(1, 50400, 20400, 30000),
(4, 50400, NULL, 50400),
(5, 36000, NULL, 36000),
(6, 44400, NULL, 44400),
(7, 48000, NULL, 48000),
(8, 57600, NULL, 57600),
(9, 44400, NULL, 44400),
(10, 57600, 45000, 12600),
(11, 57600, NULL, 57600),
(12, 57600, NULL, 57600),
(13, 57600, NULL, 57600);

-- --------------------------------------------------------

--
-- Table structure for table `Transaction`
--

CREATE TABLE `Transaction` (
  `transaction_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Transaction`
--

INSERT INTO `Transaction` (`transaction_id`, `student_id`, `amount_paid`, `payment_date`) VALUES
(1, 1, 400.00, '2025-10-25'),
(2, 1, 10000.00, '2025-10-25'),
(3, 10, 25000.00, '2025-10-25'),
(4, 1, 10000.00, '2025-10-25'),
(5, 10, 10000.00, '2025-10-27'),
(6, 10, 10000.00, '2025-10-30');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `username`, `password`) VALUES
(1, 'Admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Fee`
--
ALTER TABLE `Fee`
  ADD PRIMARY KEY (`fee_id`);

--
-- Indexes for table `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `Student_fee`
--
ALTER TABLE `Student_fee`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Fee`
--
ALTER TABLE `Fee`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Student`
--
ALTER TABLE `Student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Student_fee`
--
ALTER TABLE `Student_fee`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
