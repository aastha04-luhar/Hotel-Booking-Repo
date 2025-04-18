-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 06:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passkey` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `passkey`) VALUES
(1, 'ayush', 'aastha56@gmail.com', '123456', 'hotel1234'),
(3, 'parth', 'keya69@gmail.com', '123456', 'hotel1234'),
(4, 'ayush', 'ayush@gmail.com', '456456', 'hotel1234');

-- --------------------------------------------------------

--
-- Table structure for table `bookingss`
--

CREATE TABLE `bookingss` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `room_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL DEFAULT curdate(),
  `check_out_date` date NOT NULL DEFAULT curdate(),
  `booking_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `email` varchar(50) NOT NULL,
  `num_people` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingss`
--

INSERT INTO `bookingss` (`id`, `user_id`, `booking_date`, `room_id`, `check_in_date`, `check_out_date`, `booking_time`, `email`, `num_people`) VALUES
(17, 2, '2025-03-07 12:12:43', 2, '2025-03-21', '2025-03-21', '2025-03-07 12:12:43.152734', 'keya@gmail.com', 1),
(20, 3, '2025-03-08 11:10:23', 5, '2025-03-30', '2025-03-30', '2025-03-08 11:10:23.938792', 'feny@gmail.com', 1),
(33, 1, '2025-03-19 05:17:20', 6, '2025-03-29', '2025-03-30', '2025-03-19 05:17:20.701418', 'astha@gmail.com', 1),
(34, 1, '2025-04-17 10:00:01', 2, '2025-04-18', '2025-04-18', '2025-04-17 10:00:01.350415', 'astha@gmail.com', 1),
(35, 1, '2025-04-17 10:18:07', 2, '2025-04-19', '2025-04-20', '2025-04-17 10:18:07.885575', 'astha@gmail.com', 3),
(36, 2, '2025-04-17 10:21:58', 1, '2025-04-25', '2025-04-25', '2025-04-17 10:21:58.586747', 'keya@gmail.com', 2),
(37, 2, '2025-04-17 11:59:56', 2, '2025-04-18', '2025-04-18', '2025-04-17 11:59:56.157056', 'keya@gmail.com', 2),
(38, 2, '2025-04-17 12:16:47', 2, '2025-04-21', '2025-04-21', '2025-04-17 12:16:47.046708', 'keya@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'ff', 'ff@gmail.com', 'hello hii', '2025-02-09 08:51:39'),
(2, 'keya', 'keya@gmail.com', 'hello everyone!!!', '2025-02-11 11:35:16'),
(3, 'hfgrerre', 'gf@gmail.com', 'fgfhgfg', '2025-02-12 05:09:05'),
(4, 'astha', 'astha@gmail.com', 'I want to cancel my booking', '2025-02-19 11:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `location`, `rating`) VALUES
(1, 'Green Apple', 'Gandhinagar', 4),
(2, 'Blue Berry', 'Gandhinagar', 5),
(6, 'Swagat ', 'Ahmedabad ', 5),
(7, 'R World ', 'Surat', 5),
(8, 'The Leela', 'Gandhinagar', 4);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` enum('Paid','Pending') DEFAULT 'Paid',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_number`, `name`, `email`, `amount`, `payment_method`, `payment_status`, `payment_date`) VALUES
(1, 'INV-5092', 'ayush', 'astha@gmail.com', 1000.00, 'bank_transfer', 'Paid', '2025-03-09 11:51:59'),
(8, 'INV-4111', 'astha', 'astha@gmail.com', 1000.00, 'bank_transfer', 'Paid', '2025-03-09 12:13:22'),
(11, 'INV-8025', 'keya', 'keya@gmail.com', 2000.00, 'paypal', 'Paid', '2025-03-09 12:34:40'),
(12, 'INV-3597', 'astha', 'mohit@gmail.com', 120.00, 'credit_card', 'Paid', '2025-03-09 12:44:53'),
(15, 'INV-8716', 'astha', 'astha@gmail.com', 2000.00, 'bank_transfer', 'Paid', '2025-03-19 05:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `room_type` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hotel_id`, `room_type`, `price`, `availability`) VALUES
(1, 1, 'single room', 500.00, 1),
(2, 2, 'single room', 2000.00, 1),
(5, 6, 'Presidential Suites', 2500.00, 1),
(6, 7, 'Presidential Suites', 2000.00, 1),
(8, 2, 'Presidential Suites', 2200.00, 1),
(10, 1, 'Presidential Suite', 2100.00, 1),
(11, 6, 'Twin Room ', 1000.00, 1),
(12, 6, 'Single Room', 1200.00, 1),
(13, 7, 'Deluxe Room ', 2500.00, 1),
(14, 7, 'Single Room', 1500.00, 1),
(15, 1, 'Deluxe Room ', 2200.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(15) NOT NULL,
  `password` varchar(8) NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'default_profile.png',
  `fullname` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_pic`, `fullname`, `address`, `dob`, `age`) VALUES
(1, 'astha', 'astha@gmail.com', '456456', 'admin.png', 'astha L', 'ZUNDAL', '2005-01-29', 20),
(2, 'keya', 'keya@gmail.com', 'keya12', 'default_profile.png', 'Patel Keya', 'Zundal', '2004-09-08', 20),
(3, 'feny', 'feny@gmail.com', 'feny12', 'default_profile.png', '', '', NULL, 0),
(5, 'keya1', 'keya1@mail.com', '111111', 'default_profile.png', '', '', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookingss`
--
ALTER TABLE `bookingss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookingss`
--
ALTER TABLE `bookingss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
