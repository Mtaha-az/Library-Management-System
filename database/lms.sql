-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 10:22 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ID` int(20) UNSIGNED NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_password_reg` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `admin_email`, `admin_name`, `admin_password_reg`) VALUES
(24, 'taha20@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(25, 'taha21@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(26, 'taha22@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(27, 'taha23@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(28, 'taha24@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(30, 'taha25@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(32, 'taha27@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(33, 'taha28@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(34, 'taha30@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(35, 'taha31@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(36, 'taha32@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(37, 'taha33@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(39, 'taha34@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(40, 'taha35@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(41, 'taha@gmail.com', 'taha', '202cb962ac59075b964b07152d234b70'),
(43, 'taha12@gmail.com', 'taha', '202cb962ac59075b964b07152d234b70'),
(44, 'taha13@gmail.com', 'taha', '202cb962ac59075b964b07152d234b70'),
(45, 'taha14@gmail.com', 'taha', '202cb962ac59075b964b07152d234b70'),
(46, 'taha15@gmail.com', 'taha', '202cb962ac59075b964b07152d234b70'),
(47, 'taha11@gmail.com', 'taha', '202cb962ac59075b964b07152d234b70'),
(48, 'taha36@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(49, 'taha37@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(50, 'taha38@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(51, 'taha40@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(52, 'taha47@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(53, 'taha48@admin.library', 'taha', '202cb962ac59075b964b07152d234b70'),
(54, 'taha49@admin.library', 'taha', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookName` varchar(30) NOT NULL,
  `authorName` varchar(40) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `ISBN` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookName`, `authorName`, `price`, `quantity`, `ISBN`) VALUES
('java', 'Shoaib khan', 12, 12, '12121212'),
('math', 'ali', 122, 14, '123321'),
('DSA', 'Shoaib khan', 2000, 10, '235768'),
('DSAAA', 'Shoaib', 200, 15, '2357689'),
('Data Structure', 'kevin jr', 200, 5, '319998');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `student_id`, `isbn`, `book_name`, `status`) VALUES
(1, 's20232', '235768', 'dsa', 'Approved'),
(2, 's2023', '12313', 'java', 'Approved'),
(3, 's2023', '123133', 'java', 'Approved'),
(4, 's2023', '2357689', 'dsaaa', 'Declined'),
(5, 's2023', '12121212', 'java', 'Declined'),
(6, 's2023', '12313', 'dsa', 'Approved'),
(7, 's2023', '12313', 'java', 'Declined'),
(8, 's2023', '12313', 'java', 'pending'),
(9, 's2023', '12313', 'java', 'pending'),
(10, 's20236', '123321', 'math', 'pending'),
(11, 's2023266074', '319998', 'Data Structure', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` varchar(20) NOT NULL,
  `studentName` varchar(40) NOT NULL,
  `studentEmail` varchar(50) NOT NULL,
  `studentPassword` int(25) NOT NULL,
  `degree` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentID`, `studentName`, `studentEmail`, `studentPassword`, `degree`) VALUES
('s2021', 'taha', 's2021@gmail.com', 202, 'bscs'),
('s2023', 'taha', 's2023@gmail.com', 202, 'bscs'),
('s20232', 'taha', 's2023@gmail.com', 202, 'bscs'),
('s2023266074', 'Aliyan Ahmad', 's2023266074@umt.edu.pk', 827, 'bscs'),
('s20233', 'taha', 's20233@gmail.com', 202, 'bscs'),
('s20234', 'taha', 's20232@gmail.com', 202, 'bscs'),
('s20235', 'taha', 's20235@gmail.com', 202, 'bsse'),
('s20236', 'taha', 's20236@gmail.com', 202, 'bsit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `admin_email` (`admin_email`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
