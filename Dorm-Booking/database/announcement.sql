-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2025 at 06:55 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
