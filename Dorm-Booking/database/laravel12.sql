-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 10:53 PM
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
-- Database: `laravel12`
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
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_14_142020_create_leases_table', 2),
(5, '2025_09_14_142020_create_rooms_table', 2),
(6, '2025_09_14_142136_create_invoices_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `note` text DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `floor`, `type`, `status`, `monthly_rent`, `note`, `branch`) VALUES
(13, 'SK101', 1, 'STANDARD', 'AVAILABLE', 3500.00, 'หอพักย่านศรีนครินทร์ ห้องกว้าง โปร่งสบาย มีที่จอดรถและระบบรักษาความปลอดภัย 24 ชม. เดินทางสะดวกใกล้แหล่งของกินและคอมมูนิตี้มอลล์ จุดขึ้นรถสาธารณะ', 'SRINAKARIN'),
(14, 'SK102', 1, 'STANDARD', 'AVAILABLE', 3500.00, 'หอพักย่านศรีนครินทร์ ห้องกว้าง โปร่งสบาย มีที่จอดรถและระบบรักษาความปลอดภัย 24 ชม. เดินทางสะดวกใกล้แหล่งของกินและคอมมูนิตี้มอลล์ จุดขึ้นรถสาธารณะ', 'SRINAKARIN'),
(15, 'SK103', 1, 'STANDARD', 'AVAILABLE', 3500.00, 'หอพักย่านศรีนครินทร์ ห้องกว้าง โปร่งสบาย มีที่จอดรถและระบบรักษาความปลอดภัย 24 ชม. เดินทางสะดวกใกล้แหล่งของกินและคอมมูนิตี้มอลล์ จุดขึ้นรถสาธารณะ', 'SRINAKARIN'),
(16, 'SK104', 1, 'STANDARD', 'AVAILABLE', 3500.00, 'หอพักย่านศรีนครินทร์ ห้องกว้าง โปร่งสบาย มีที่จอดรถและระบบรักษาความปลอดภัย 24 ชม. เดินทางสะดวกใกล้แหล่งของกินและคอมมูนิตี้มอลล์ จุดขึ้นรถสาธารณะ', 'SRINAKARIN'),
(17, 'SK105', 1, 'STANDARD', 'AVAILABLE', 3500.00, 'หอพักย่านศรีนครินทร์ ห้องกว้าง โปร่งสบาย มีที่จอดรถและระบบรักษาความปลอดภัย 24 ชม. เดินทางสะดวกใกล้แหล่งของกินและคอมมูนิตี้มอลล์ จุดขึ้นรถสาธารณะ', 'SRINAKARIN'),
(18, 'SK201', 2, 'DELUXE', 'AVAILABLE', 5500.00, 'ห้อง DELUXE ฟังก์ชันครบ พร้อมแสงธรรมชาติและบรรยากาศเงียบสงบ ศรีนครินทร์โลเคชันเยี่ยม ใกล้แหล่งไลฟ์สไตล์ เดินทางสะดวกทุกเส้นทาง', 'SRINAKARIN'),
(19, 'SK202', 2, 'DELUXE', 'AVAILABLE', 5500.00, 'ห้อง DELUXE ฟังก์ชันครบ พร้อมแสงธรรมชาติและบรรยากาศเงียบสงบ ศรีนครินทร์โลเคชันเยี่ยม ใกล้แหล่งไลฟ์สไตล์ เดินทางสะดวกทุกเส้นทาง', 'SRINAKARIN'),
(20, 'SK203', 2, 'DELUXE', 'AVAILABLE', 5500.00, 'ห้อง DELUXE ฟังก์ชันครบ พร้อมแสงธรรมชาติและบรรยากาศเงียบสงบ ศรีนครินทร์โลเคชันเยี่ยม ใกล้แหล่งไลฟ์สไตล์ เดินทางสะดวกทุกเส้นทาง', 'SRINAKARIN'),
(21, 'SK204', 2, 'DELUXE', 'AVAILABLE', 5500.00, 'ห้อง DELUXE ฟังก์ชันครบ พร้อมแสงธรรมชาติและบรรยากาศเงียบสงบ ศรีนครินทร์โลเคชันเยี่ยม ใกล้แหล่งไลฟ์สไตล์ เดินทางสะดวกทุกเส้นทาง', 'SRINAKARIN'),
(22, 'SK301', 3, 'LUXURY', 'AVAILABLE', 7900.00, 'สไตล์โรงแรมระดับพรีเมียม สิ่งอำนวยความสะดวกครบ เข้าออกปลอดภัย ที่ตั้งศรีนครินทร์ เดินทางสะดวก ใกล้ห้าง ร้านอาหาร และรถสาธารณะ', 'SRINAKARIN'),
(23, 'SK302', 3, 'LUXURY', 'AVAILABLE', 7900.00, 'สไตล์โรงแรมระดับพรีเมียม สิ่งอำนวยความสะดวกครบ เข้าออกปลอดภัย ที่ตั้งศรีนครินทร์ เดินทางสะดวก ใกล้ห้าง ร้านอาหาร และรถสาธารณะ', 'SRINAKARIN'),
(24, 'SK303', 3, 'LUXURY', 'AVAILABLE', 7900.00, 'สไตล์โรงแรมระดับพรีเมียม สิ่งอำนวยความสะดวกครบ เข้าออกปลอดภัย ที่ตั้งศรีนครินทร์ เดินทางสะดวก ใกล้ห้าง ร้านอาหาร และรถสาธารณะ', 'SRINAKARIN'),
(25, 'RM101', 1, 'STANDARD', 'AVAILABLE', 5300.00, 'ที่พักสบาย ราคาคุ้ม ห้องสะอาด พร้อมอินเทอร์เน็ต/จุดซักผ้า (ขึ้นกับอาคาร) โซนพระราม 9 ใกล้ห้าง สำนักงาน และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(26, 'RM102', 1, 'STANDARD', 'AVAILABLE', 5300.00, 'ที่พักสบาย ราคาคุ้ม ห้องสะอาด พร้อมอินเทอร์เน็ต/จุดซักผ้า (ขึ้นกับอาคาร) โซนพระราม 9 ใกล้ห้าง สำนักงาน และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(27, 'RM103', 1, 'STANDARD', 'AVAILABLE', 5300.00, 'ที่พักสบาย ราคาคุ้ม ห้องสะอาด พร้อมอินเทอร์เน็ต/จุดซักผ้า (ขึ้นกับอาคาร) โซนพระราม 9 ใกล้ห้าง สำนักงาน และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(28, 'RM104', 1, 'STANDARD', 'AVAILABLE', 5300.00, 'ที่พักสบาย ราคาคุ้ม ห้องสะอาด พร้อมอินเทอร์เน็ต/จุดซักผ้า (ขึ้นกับอาคาร) โซนพระราม 9 ใกล้ห้าง สำนักงาน และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(29, 'RM105', 1, 'STANDARD', 'AVAILABLE', 5300.00, 'ที่พักสบาย ราคาคุ้ม ห้องสะอาด พร้อมอินเทอร์เน็ต/จุดซักผ้า (ขึ้นกับอาคาร) โซนพระราม 9 ใกล้ห้าง สำนักงาน และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(30, 'RM201', 2, 'DELUXE', 'AVAILABLE', 8700.00, 'ห้องดีลักซ์สไตล์โมเดิร์น ฟังก์ชันครบ เตียงใหญ่ พื้นที่เก็บของเยอะ พระราม 9 เดินทางสะดวก ใกล้คอมมูนิตี้มอลล์และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(31, 'RM202', 2, 'DELUXE', 'AVAILABLE', 8700.00, 'ห้องดีลักซ์สไตล์โมเดิร์น ฟังก์ชันครบ เตียงใหญ่ พื้นที่เก็บของเยอะ พระราม 9 เดินทางสะดวก ใกล้คอมมูนิตี้มอลล์และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(32, 'RM203', 2, 'DELUXE', 'AVAILABLE', 8700.00, 'ห้องดีลักซ์สไตล์โมเดิร์น ฟังก์ชันครบ เตียงใหญ่ พื้นที่เก็บของเยอะ พระราม 9 เดินทางสะดวก ใกล้คอมมูนิตี้มอลล์และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(33, 'RM204', 2, 'DELUXE', 'AVAILABLE', 8700.00, 'ห้องดีลักซ์สไตล์โมเดิร์น ฟังก์ชันครบ เตียงใหญ่ พื้นที่เก็บของเยอะ พระราม 9 เดินทางสะดวก ใกล้คอมมูนิตี้มอลล์และจุดขึ้นรถสาธารณะ', 'RAMA9'),
(34, 'RM301', 3, 'LUXURY', 'AVAILABLE', 11500.00, 'ห้องหรูทันสมัย แสงธรรมชาติดี ระเบียง/พื้นที่เก็บของ ครบฟังก์ชันใกล้ MRT พระราม 9–ศูนย์การค้า เดินทางสะดวกทุกเส้นทาง', 'RAMA9'),
(35, 'RM302', 3, 'LUXURY', 'AVAILABLE', 11500.00, 'ห้องหรูทันสมัย แสงธรรมชาติดี ระเบียง/พื้นที่เก็บของ ครบฟังก์ชันใกล้ MRT พระราม 9–ศูนย์การค้า เดินทางสะดวกทุกเส้นทาง', 'RAMA9'),
(36, 'RM303', 3, 'LUXURY', 'AVAILABLE', 11500.00, 'ห้องหรูทันสมัย แสงธรรมชาติดี ระเบียง/พื้นที่เก็บของ ครบฟังก์ชันใกล้ MRT พระราม 9–ศูนย์การค้า เดินทางสะดวกทุกเส้นทาง', 'RAMA9'),
(37, 'AS101', 1, 'STANDARD', 'AVAILABLE', 6700.00, 'ห้องสแตนดาร์ดกะทัดรัด อยู่สบาย เฟอร์นิเจอร์พื้นฐานครบทำเลอโศก เดินทางสะดวก ใกล้ BTS/MRT ร้านอาหารและออฟฟิศ', 'ASOKE'),
(38, 'AS102', 1, 'STANDARD', 'AVAILABLE', 6700.00, 'ห้องสแตนดาร์ดกะทัดรัด อยู่สบาย เฟอร์นิเจอร์พื้นฐานครบทำเลอโศก เดินทางสะดวก ใกล้ BTS/MRT ร้านอาหารและออฟฟิศ', 'ASOKE'),
(39, 'AS103', 1, 'STANDARD', 'AVAILABLE', 6700.00, 'ห้องสแตนดาร์ดกะทัดรัด อยู่สบาย เฟอร์นิเจอร์พื้นฐานครบทำเลอโศก เดินทางสะดวก ใกล้ BTS/MRT ร้านอาหารและออฟฟิศ', 'ASOKE'),
(40, 'AS104', 1, 'STANDARD', 'AVAILABLE', 6700.00, 'ห้องสแตนดาร์ดกะทัดรัด อยู่สบาย เฟอร์นิเจอร์พื้นฐานครบทำเลอโศก เดินทางสะดวก ใกล้ BTS/MRT ร้านอาหารและออฟฟิศ', 'ASOKE'),
(41, 'AS105', 1, 'STANDARD', 'AVAILABLE', 6700.00, 'ห้องสแตนดาร์ดกะทัดรัด อยู่สบาย เฟอร์นิเจอร์พื้นฐานครบทำเลอโศก เดินทางสะดวก ใกล้ BTS/MRT ร้านอาหารและออฟฟิศ', 'ASOKE'),
(42, 'AS201', 2, 'DELUXE', 'AVAILABLE', 9900.00, 'ดีลักซ์โทนอบอุ่น อยู่สบายทั้งวัน เฟอร์นิเจอร์พร้อมทำเลอโศก เดินไม่ไกลถึง BTS อโศก และ MRT สุขุมวิท', 'ASOKE'),
(43, 'AS202', 2, 'DELUXE', 'AVAILABLE', 9900.00, 'ดีลักซ์โทนอบอุ่น อยู่สบายทั้งวัน เฟอร์นิเจอร์พร้อมทำเลอโศก เดินไม่ไกลถึง BTS อโศก และ MRT สุขุมวิท', 'ASOKE'),
(44, 'AS203', 2, 'DELUXE', 'AVAILABLE', 9900.00, 'ดีลักซ์โทนอบอุ่น อยู่สบายทั้งวัน เฟอร์นิเจอร์พร้อมทำเลอโศก เดินไม่ไกลถึง BTS อโศก และ MRT สุขุมวิท', 'ASOKE'),
(45, 'AS204', 2, 'DELUXE', 'AVAILABLE', 9900.00, 'ดีลักซ์โทนอบอุ่น อยู่สบายทั้งวัน เฟอร์นิเจอร์พร้อมทำเลอโศก เดินไม่ไกลถึง BTS อโศก และ MRT สุขุมวิท', 'ASOKE'),
(46, 'AS301', 3, 'LUXURY', 'AVAILABLE', 15900.00, 'ความสบายระดับโรงแรม สิ่งอำนวยความสะดวกครบ คีย์การ์ด/กล้อง 24 ชม.รายล้อมคาเฟ่–ร้านอาหาร เดินทางง่ายทุกเส้นทาง', 'ASOKE'),
(47, 'AS302', 3, 'LUXURY', 'AVAILABLE', 15900.00, 'ความสบายระดับโรงแรม สิ่งอำนวยความสะดวกครบ คีย์การ์ด/กล้อง 24 ชม.รายล้อมคาเฟ่–ร้านอาหาร เดินทางง่ายทุกเส้นทาง', 'ASOKE'),
(48, 'AS303', 3, 'LUXURY', 'AVAILABLE', 15900.00, 'ความสบายระดับโรงแรม สิ่งอำนวยความสะดวกครบ คีย์การ์ด/กล้อง 24 ชม.รายล้อมคาเฟ่–ร้านอาหาร เดินทางง่ายทุกเส้นทาง', 'ASOKE');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('daYBKooZCQjImJY8XZRlilGuvrJ7RfS2fobvLMr0', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoibXZtVENMcXR0c0FFcWhPbElHMkFSQ0p1MDBkWGVWMHhqZGlXVW5WbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yb29tL3NlYXJjaD9ieT1mbG9vciZrZXl3b3JkPTEmcGFnZT0xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTtzOjc6InVzZXJfaWQiO2k6MTE7czo5OiJ1c2VyX25hbWUiO3M6MTA6IkFkbWluIFRlc3QiO3M6OToidXNlcl9yb2xlIjtzOjU6IkFETUlOIjtzOjU6ImFsZXJ0IjthOjA6e319', 1759351963);

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
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign key lease_id` (`lease_id`),
  ADD KEY `idx_invoices_lease_status` (`lease_id`,`payment_status`,`status`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leases`
--
ALTER TABLE `leases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign key user_id` (`user_id`),
  ADD KEY `Foreign key room_id` (`room_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_no` (`room_no`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leases`
--
ALTER TABLE `leases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
