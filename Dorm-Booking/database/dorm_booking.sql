-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 09:15 AM
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
  `link` varchar(200) NOT NULL,
  `image` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `body`, `link`, `image`, `created_at`, `updated_at`) VALUES
(1, 'อุตุฯ ประชุมด่วนติดตามพายุ \"บัวลอย\" คาดไทยตอนบนเจอ \"ฝนหนักถึงหนักมาก\"', '\"กรมอุตุนิยมวิทยา\" ประชุมด่วนติดตามพายุ \"บัวลอย\" คาดไทยตอนบนเจอ \"ฝนหนักถึงหนักมาก\" อาจเกิดน้ำท่วมฉับพลันและน้ำป่าไหลหลาก', 'https://www.thairath.co.th/news/local/2885671', 'uploads/announcement/1TajPqaXtSNhJfgoCnxaTlnGAQ3g48SLgSvXBdDo.webp', '2025-09-28 18:32:31', '2025-09-28 18:32:31'),
(3, 'รวบชายป่วยจิตเวช ผู้ต้องสงสัยฆ่าแล้วเผาคนเร่ร่อน ค้นเจอไฟแช็ก-คราบน้ำมัน', 'รวบทันควันชายป่วยจิตเวช ผู้ต้องสงสัยฆ่าแล้วเผาซ้ำชายเร่ร่อน หลังค้นตัวเจอไฟแช็ก เสื้อและกางเกงมีคราบน้ำมัน ขณะที่ตำรวจยังไม่สามารถแจ้งข้อหา รอผลตรวจก่อน', 'https://www.thairath.co.th/news/crime/2885712', 'uploads/announcement/lZMxevavtMyQHwDIGfylajKGNfY7s8KNCwhRsVZX.webp', '2025-09-28 18:44:33', '2025-09-28 18:44:33'),
(4, 'www.คนละครึ่ง.com เตรียมเปิดลงทะเบียน \"คนละครึ่งพลัส\" ได้ใช้เมื่อไหร่ ใครได้บ้าง', 'อัปเดตโครงการ \"คนละครึ่งพลัส\" เตรียมเปิดลงทะเบียนรับสิทธิผ่านเว็บไซต์ www.คนละครึ่ง.com เช็ก 3 กลุ่มใครได้บ้าง ได้เงินสูงสุด 2,400 บาท\r\n\r\nภายหลังจาก นายอนุทิน ชาญวีรกูล นายกรัฐมนตรี เผยถึงโครงการ \"คนละครึ่ง\" ว่ามีประโยชน์ เพราะมีส่วนร่วมกับประชาชนโดยมีการแชร์กัน รัฐบาลจะทำโครงการ \"คนละครึ่งพลัส\" เป็นแรงจูงใจให้คนที่เสียภาษี 60:40 และมั่นใจว่าจะกระตุ้นเศรษฐกิจให้เร็ว', 'https://www.thairath.co.th/news/society/2885695', 'uploads/announcement/mluSCmFI4p7H6236tOpVhjqQifAxZ6s6oxQ8VBOK.webp', '2025-09-28 18:57:04', '2025-09-28 18:57:04'),
(5, 'เผยความคืบหน้าเหตุ \"ถนนทรุด\" หน้าวชิระพยาบาล ยันคืนผิวการจราจรได้ทันตามกำหนด', 'รฟม. เผยความคืบหน้าเหตุการณ์ \"ถนนทรุด\" หน้าวชิรพยาบาล เทคอนกรีตอุดหลุมเรียบร้อยแล้ว เตรียมเคลียร์เศษเสาไฟฟ้า-อุปกรณ์ต่างๆ ออกจากหลุมวันพรุ่งนี้ ยันคืนผิวการจราจร 9 ต.ค. นี้ ด้าน \"อ.ธเนศ\" จ่อตรวจวัดความสั่นสะเทือนก่อนให้ ปชช.กลับที่พัก', 'https://www.thairath.co.th/news/local/bangkok/2885711', 'uploads/announcement/Cak8bSbARTgVWSdwxx00p0nQllood7mImswInZ7d.webp', '2025-09-28 19:04:55', '2025-09-28 19:04:55'),
(6, 'ครม. อนุมัติงบฯ 1,418 ล้าน ชดเชยภาระค่าไฟฟ้าให้ กฟน.-กฟภ. งวด ต.ค.-ธ.ค. 2567', 'ครม. อนุมัติงบกลาง เงินสำรองจ่ายเพื่อกรณีฉุกเฉิน ชดเชยภาระค่าไฟฟ้าให้ กฟน.-กฟภ. หลังดำเนินมาตรการลดภาระค่าใช้จ่ายด้านไฟฟ้าให้ประชาชนกลุ่มเปราะบาง งวดเดือนตุลาคม-ธันวาคม 2567', 'https://www.thairath.co.th/news/politic/2863678', 'uploads/announcement/aCAMkgxtSzIrekPRghseVO3KWEJA4J1zmkTSZONq.webp', '2025-09-28 19:06:19', '2025-09-28 19:06:19'),
(7, 'พนักงานสาว เล่านาทีระทึก \"รถเก๋ง\" ขับพุ่งชนเข้าร้านหมาล่า จนลูกค้าได้รับบาดเจ็บ', 'พนักงานสาว เล่านาทีระทึก \"รถเก๋งแดง\" ขับพุ่งชนเข้าร้านหม่าล่า ทำลูกค้าต่างชาติหนีกระเจิง หลายคนได้รับบาดเจ็บ ด้านคนขับเผย จะเหยียบเบรก แต่กลับเป็นคันเร่ง', 'https://www.thairath.co.th/news/local/north/2885685', 'uploads/announcement/MpNjKTtewTX6oirK8VFtFVcx91cUdvC3yH8wS4gK.webp', '2025-09-28 19:41:46', '2025-09-28 19:41:46');

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
(4, 2, '2025-05', '2025-05-26', 2500.00, 1000.00, 200.00, 3700.00, 'ISSUED', NULL, 'PENDING', 'uploads/receipts/nWdGbOs3wjWA5j2PzehxYp7XGp6Px6sVH3gOX095.jpg', '2025-09-22 18:22:15', '2025-09-22 18:22:15'),
(5, 1, '2024-03', '2025-09-18', 5000.00, 1231.00, 1231.00, 7462.00, 'PAID', NULL, 'PENDING', 'uploads/receipts/MTvdlntVVZqQkwbDbGs4D1Yat1ATEN4Jw6YZD2Ah.png', '2025-09-29 17:27:41', '2025-09-29 17:27:41'),
(6, 4, '2024-03', '2025-09-18', 123123.00, 11.00, 11.00, 123145.00, 'PAID', NULL, 'CONFIRMED', 'uploads/receipts/3NUqhVFNrmxIlrl7OpqdBz9sVYTvUYKbrzG0gMBf.png', '2025-10-01 12:39:13', '2025-10-01 12:39:39');

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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leases`
--

INSERT INTO `leases` (`id`, `user_id`, `room_id`, `start_date`, `end_date`, `rent_amount`, `deposit_amount`, `status`, `contract_file_url`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 11, 5, '2025-09-22', '2026-10-24', 5000.00, 2000.00, 'ACTIVE', 'uploads/contracts/keV63zDv8rmPtU1usejbinVvwlQPtt52YZ1IbDC1.png', '2025-09-22 17:24:29', '2025-09-28 17:16:41', NULL),
(2, 9, 7, '2025-09-22', '2026-01-21', 2500.00, 1000.00, 'ENDED', 'uploads/contracts/ywhIlQrvhClEj8n3D8mCWTgWXgN0hiiQRhXBl4no.jpg', '2025-09-22 18:21:18', '2025-09-28 16:31:40', NULL),
(3, 4, 7, '2025-09-24', '2025-10-11', 506.00, 12312.00, 'ACTIVE', 'uploads/contracts/muKAZqyHh1bia5OlEzhax0dYbKLVqI9sSJ5Gw241.png', '2025-09-28 17:51:58', '2025-09-28 17:52:05', NULL),
(4, 3, 8, '2025-09-01', '2025-09-28', 123123.00, 123123.00, 'ACTIVE', 'uploads/contracts/wod0i5va019q1WNSimKCJaEpX03HLTzmWfUwHOWG.png', '2025-09-28 17:56:27', '2025-10-01 14:13:46', '2025-10-01 14:13:46');

--
-- Triggers `leases`
--
DELIMITER $$
CREATE TRIGGER `before_lease_delete_unpaid_guard` BEFORE DELETE ON `leases` FOR EACH ROW BEGIN
  IF EXISTS (
    SELECT 1
    FROM invoices
    WHERE lease_id = OLD.id
      AND (
           status IN ('DRAFT','ISSUED','OVERDUE')
        OR payment_status IS NULL
        OR payment_status <> 'CONFIRMED'
      )
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Cannot delete lease: unpaid invoices exist';
  END IF;
END
$$
DELIMITER ;

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
(5, '128', 8, 'DELUXE', 'AVAILABLE', 4500.00, 'this room is for black gay that horny, mai wai leawwwwww~~~'),
(6, '123', 3, 'STANDARD', 'MAINTENANCE', 2378.00, 'Eiei'),
(7, '002', 4, 'STANDARD', 'OCCUPIED', 2000.00, 'mai me rai mak bok rag pua'),
(8, '334', 5, 'STANDARD', 'AVAILABLE', 1500.00, 'mai me rai ja bok rok'),
(10, '555', 4, 'STANDARD', 'AVAILABLE', 2222.00, 'ddSSSSS');

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
(12, 'member@gmail.com', '$2y$12$L/mDtC94/SQ.f5o.ip9VLer8Q1wvkkg1Vlf2DOJzYc/YPA5b5xFMe', 'Member Test', '1231231111', 'MEMBER', 'ACTIVE', '2025-09-22 21:05:25', '2025-09-22 21:05:25'),
(13, 'eieiLawZa@hotmail.com', '$2y$12$CpFF4f3ATrEI0K09G4xgYuAamIfToHnY3G8nSX7eYxRKz3TZP9cPy', 'LawZa007X', '9999999999', 'STAFF', 'ACTIVE', '2025-09-29 16:17:48', '2025-09-29 16:17:48');

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
  ADD KEY `Foreign key lease_id` (`lease_id`),
  ADD KEY `idx_invoices_lease_status` (`lease_id`,`payment_status`,`status`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leases`
--
ALTER TABLE `leases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
