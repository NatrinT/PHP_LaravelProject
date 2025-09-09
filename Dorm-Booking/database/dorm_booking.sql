-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2025 at 07:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dorm_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `lease_id` int(11) NOT NULL,
  `billing_period` char(7) NOT NULL,
  `due_date` date NOT NULL,
  `amount_rent` decimal(10,2) NOT NULL,
  `amount_utilities` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount_other` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('DRAFT','ISSUED','PAID','OVERDUE','CANCELED') NOT NULL DEFAULT 'ISSUED',
  `paid_at` datetime DEFAULT NULL,
  `payment_status` enum('PENDING','CONFIRMED','FAILED') NOT NULL DEFAULT 'PENDING',
  `receipt_file_url` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `upated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leases`
--

CREATE TABLE `leases` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `rent_amount` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('PENDING','ACTIVE','ENDED','CANCELED') NOT NULL DEFAULT 'PENDING',
  `contract_file_url` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` varchar(20) NOT NULL,
  `floor` int(11) NOT NULL,
  `type` enum('STANDARD','DELUXE','OTHER') NOT NULL DEFAULT 'STANDARD',
  `status` enum('AVAILABLE','OCCUPIED','MAINTENANCE') NOT NULL DEFAULT 'AVAILABLE',
  `monthly_rent` decimal(10,2) NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `floor`, `type`, `status`, `monthly_rent`, `note`) VALUES
(4, '224', 2, 'STANDARD', 'MAINTENANCE', 2500.00, 'Haha, Benten'),
(5, '128', 8, 'DELUXE', 'AVAILABLE', 4500.00, 'this room is for black gay that horny, mai wai leawwwwww~~~'),
(6, '123', 3, 'STANDARD', 'MAINTENANCE', 2378.00, 'Eiei');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `role` enum('ADMIN','MEMBER','STAFF') NOT NULL DEFAULT 'MEMBER',
  `status` enum('ACTIVE','SUSPENDED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `create_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pass_hash`, `full_name`, `phone`, `role`, `status`, `create_at`, `updated_at`) VALUES
(2, 'kh.chittaworn_st@tni.ac.th', '$2y$12$AX23PiH6Y9JjzK2Nm5aEseM2Yj3Pjf8mBJI.ZKckebjQQ/RtgVR7q', 'Riew EieiTest', '0944364363', 'MEMBER', 'ACTIVE', '2025-09-07 20:39:59', '2025-09-08 16:15:01'),
(3, 'masdf@gmail.com', '$2y$12$RSU9KcpIVqZynPoVBp.1lOIL0.1pq8m.wB3P3jdRZwBjm6OFVxpKC', 'Potter', '0009998889', 'STAFF', 'ACTIVE', '2025-09-08 16:16:00', '2025-09-08 16:16:00'),
(4, 'T_T@gmail.com', '$2y$12$nP0oD0fEy53uCh61We1/HOdDebaZh8XKTkXnRr54nd0NKVFE765E6', 'Phat', '9998765432', 'MEMBER', 'ACTIVE', '2025-09-08 16:16:35', '2025-09-08 16:16:35'),
(5, 'Kim@gmail.com', '$2y$12$rg0P6s/oPfEzF5k8B7g5QeE7J2Ovc07d62hfssgljAUTpCi4SQf8m', 'Kim Eiei`', '1234567890', 'ADMIN', 'ACTIVE', '2025-09-08 16:17:06', '2025-09-08 16:17:06'),
(6, 'haha@gmail.com', '$2y$12$ktEx7FxyrZZPeFx/6fexLuiKlyRNH5.JGOmjet5YvhtLtIzzNraUu', 'Gene', '8888444488', 'MEMBER', 'ACTIVE', '2025-09-08 16:17:33', '2025-09-08 16:17:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign key lease_id` (`lease_id`);

--
-- Indexes for table `leases`
--
ALTER TABLE `leases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign key user_id` (`user_id`),
  ADD KEY `Foreign key room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_no` (`room_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leases`
--
ALTER TABLE `leases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `Foreign key lease_id` FOREIGN KEY (`lease_id`) REFERENCES `leases` (`id`);

--
-- Constraints for table `leases`
--
ALTER TABLE `leases`
  ADD CONSTRAINT `Foreign key room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `Foreign key user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
