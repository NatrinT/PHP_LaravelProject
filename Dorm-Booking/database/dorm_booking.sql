-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 04:10 PM
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
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `body`, `image`, `created_at`, `updated_at`) VALUES
(2, 'I phoo pen gay', 'a;lsdkfja;lskdfj;alskdjf; si eja;soidjf isje;fokj sidfjaskd naksnc vc;lakxjv;alkxcvj;zxclkvj;zxclkvjzx;clkvjzx;clkvjpsaoidfapsdofiapsoeifjpasoiefjasokdljf ;asoldifjiasdj ;aiosdjf;alksdj ;aoisdjf;laksdjfiasejfasf', 'uploads/announcement/HFGvopaxG0nFtsHpfjGQGu2TPovJQEYWwkcTI41q.jpg', '2025-09-22 20:35:54', '2025-09-22 20:35:54'),
(3, 'ASDFASD', 'asdfas asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasda sdasfasdf asdfasdf asdf asdfasefasdfasd asdf sadfasdf', 'uploads/announcement/zFnlIQSkSz2c3JLd1flZrxO5ZNRYUpRsGXbWpblg.jpg', '2025-09-22 20:36:21', '2025-09-22 20:36:21'),
(4, 'fefefefefWEFWFEWEF', 'asdf SDFASDFfasdfasdf sdafFASFASEFASEFASEFfasdfasdfASDFASDFfasdfasd  asdf asdfasdfasdf', 'uploads/announcement/0oW3VHjkRDT4pScONy6Yl0s3wLuf1VUvV6DF5FdK.jpg', '2025-09-22 20:36:40', '2025-09-22 20:36:40'),
(5, 'FFFFFFFFFFFFF', 'ASDFASASDFasdfasdfasefasdfasdfasdfasdfasdfasefasdfasdfasefasdfase asdfasefasdfasef asdfasefasdfase asdfasefasdfasefsadfasdfasefasdfefafgasedffasdfasdfasef', 'uploads/announcement/tSlGegMt0D3gtMtlE57w7VwGIxSY78DPvji3E95O.jpg', '2025-09-22 20:40:16', '2025-09-22 20:40:16');

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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `lease_id`, `billing_period`, `due_date`, `amount_rent`, `amount_utilities`, `amount_other`, `total_amount`, `status`, `paid_at`, `payment_status`, `receipt_file_url`, `created_at`, `updated_at`) VALUES
(2, 1, '2025-05', '2026-09-24', 5000.00, 300.00, 200.00, 5500.00, 'ISSUED', NULL, 'PENDING', 'uploads/receipts/vYGSRkQY5BHhXS9gXx7BoVmg5c1qZo7BJ57Mpf85.jpg', '2025-09-22 18:19:13', '2025-09-22 18:19:13'),
(3, 1, '2025-05', '2026-09-24', 5000.00, 300.00, 2.00, 5302.00, 'ISSUED', NULL, 'PENDING', 'uploads/receipts/wZ0BRf9V4n2sCQz13b9IDBsIr77lbvw1iVPrT4zf.jpg', '2025-09-22 18:19:34', '2025-09-22 18:19:34'),
(4, 2, '2025-05', '2025-05-26', 2500.00, 1000.00, 200.00, 3700.00, 'ISSUED', NULL, 'PENDING', 'uploads/receipts/nWdGbOs3wjWA5j2PzehxYp7XGp6Px6sVH3gOX095.jpg', '2025-09-22 18:22:15', '2025-09-22 18:22:15');

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

--
-- Dumping data for table `leases`
--

INSERT INTO `leases` (`id`, `user_id`, `room_id`, `start_date`, `end_date`, `rent_amount`, `deposit_amount`, `status`, `contract_file_url`, `created_at`, `updated_at`) VALUES
(1, 9, 5, '2025-09-22', '2026-10-24', 5000.00, 2000.00, 'ACTIVE', 'uploads/contracts/keV63zDv8rmPtU1usejbinVvwlQPtt52YZ1IbDC1.png', '2025-09-22 17:24:29', '2025-09-22 17:24:29'),
(2, 9, 7, '2025-09-22', '2026-01-21', 2500.00, 1000.00, 'ACTIVE', 'uploads/contracts/ywhIlQrvhClEj8n3D8mCWTgWXgN0hiiQRhXBl4no.jpg', '2025-09-22 18:21:18', '2025-09-22 18:21:18');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` varchar(20) NOT NULL,
  `floor` int(11) NOT NULL,
  `type` enum('STANDARD','DELUXE','LUXURY') NOT NULL DEFAULT 'STANDARD',
  `status` enum('AVAILABLE','OCCUPIED','MAINTENANCE') NOT NULL DEFAULT 'AVAILABLE',
  `monthly_rent` decimal(10,2) NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `floor`, `type`, `status`, `monthly_rent`, `note`) VALUES
(4, '224', 2, 'STANDARD', 'MAINTENANCE', 2500.00, 'Haha, Benten'),
(5, '128', 8, 'DELUXE', 'OCCUPIED', 4500.00, 'this room is for black gay that horny, mai wai leawwwwww~~~'),
(6, '123', 3, 'STANDARD', 'MAINTENANCE', 2378.00, 'Eiei'),
(7, '002', 4, 'STANDARD', 'OCCUPIED', 2000.00, 'mai me rai mak bok rag pua');

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
(6, 'haha@gmail.com', '$2y$12$ktEx7FxyrZZPeFx/6fexLuiKlyRNH5.JGOmjet5YvhtLtIzzNraUu', 'Gene', '8888444488', 'MEMBER', 'ACTIVE', '2025-09-08 16:17:33', '2025-09-08 16:17:33'),
(8, 'test@gmail.com', '$2y$12$BwjHXCaItVQohAReLkbIZ.zFO/uxSZ..J3PzLOtFmwi6AiFhQ73Wi', 'test test', '1111111111', 'ADMIN', 'ACTIVE', '2025-09-22 16:19:01', '2025-09-22 16:19:01'),
(9, 'riew@gmail.com', '$2y$12$GY4QOD7jIdD3MgAef/VoBuZdRi8z3q3hMfgBMQMCKuWYgQCiE/fUi', 'Riew Eiei', '1231231231', 'ADMIN', 'ACTIVE', '2025-09-22 16:20:33', '2025-09-22 16:20:33'),
(10, 'riewmember@gmail.com', '$2y$12$BgfD6lACZoCA3W8cX8D7bOgQLu4OI.ypzM.qJ8CHMAtwVmxzKSW9K', 'RiewMember', '1231231231', 'MEMBER', 'ACTIVE', '2025-09-22 20:38:01', '2025-09-22 20:38:01'),
(11, 'admin@gmail.com', '$2y$12$cTRwWSAwbUdhnky17kHVm.1gzAWL79mSFj4Kh62CzYoSAzOaF5H3S', 'Admin Test', '1231231231', 'ADMIN', 'ACTIVE', '2025-09-22 21:05:06', '2025-09-22 21:05:06'),
(12, 'member@gmail.com', '$2y$12$L/mDtC94/SQ.f5o.ip9VLer8Q1wvkkg1Vlf2DOJzYc/YPA5b5xFMe', 'Member Test', '1231231111', 'MEMBER', 'ACTIVE', '2025-09-22 21:05:25', '2025-09-22 21:05:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leases`
--
ALTER TABLE `leases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
