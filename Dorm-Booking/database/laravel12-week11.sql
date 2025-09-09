-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2025 at 08:44 AM
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
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_username` varchar(200) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_name`, `admin_username`, `admin_password`, `dateCreate`) VALUES
(1, 'aaaaaaa', 'ssss@344', '$2y$12$DwbMfUxTfC7WzKGLhl32V.fIa23QNzqa0gD6T5zvkHNGnW58r14R.', '2025-08-22 09:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_detail` text NOT NULL,
  `product_price` float(10,2) NOT NULL,
  `product_img` varchar(200) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `product_name`, `product_detail`, `product_price`, `product_img`, `dateCreate`) VALUES
(3, 'Apple', 'asdfasdfasdfsdfddfsdf', 120.00, 'uploads/product/NgQUB6y5TwoktVve1u1XvnJdrc8D8czCmHHZi6PT.png', '2025-09-05 05:08:37'),
(4, 'Banana', 'asdfasdfasdfasdffd', 500.00, 'uploads/product/57X5R5Cdw73bhQloo6V9gv1YsYtG7KazAKpXMExW.png', '2025-09-05 05:09:05'),
(5, 'Orange', 'asdfasdfeasdfasdfadfasdfa', 1200.00, 'uploads/product/voxBuukQL2IproL0aFTU9fkkZBsAY43zRy59AgSd.png', '2025-09-05 05:09:24'),
(6, 'Pen', 'asdfasdfasdfasdf', 200.00, 'uploads/product/hhCS3OSLNyQ4Socfy2m8iQDDyKsSyLwHebZ7oD8o.png', '2025-09-05 05:09:50'),
(7, 'Pencil', 'asdfasdfasdfasdfasdf', 50.00, 'uploads/product/Mjr9uYm1t0MftGZCLFvNaZ81Pd6mGgnSL18Rrp6u.png', '2025-09-05 05:10:02'),
(8, 'Fish', 'asdfafa sdasd asdfasdf', 25000.00, 'uploads/product/ND7KT5V1uqsjCwOz5PYUBs6HzLTiMoRv80h7ykbW.png', '2025-09-05 05:10:23'),
(9, 'Bubblegum', 'asdfasdgasdfasdf', 100000.00, 'uploads/product/Hnb8Kf5vwcy1BTupNQ6Vwpgs30rEK8BH0Ff4zgo7.png', '2025-09-05 05:11:07'),
(10, 'Durian', 'asdfasdfasdfasdf', 100.00, 'uploads/product/IAsoAaBG521F54o4kmb1kWIs8zpo0QsGJpYxJqID.png', '2025-09-05 05:11:49'),
(11, 'CPU', 'aosdi ha;sldf;alskdfj;asldkfj;asiod jasdf', 5022.00, 'uploads/product/qrYreQkzjcGpD9ZLA5jOR8vLKFxlDNiNB7zJzWl5.png', '2025-09-05 05:12:05'),
(12, 'Mainboard', 'asdfasdfasdgas asdfasdfasdfasfd', 8695.00, 'uploads/product/Zt9ah6T5ohcXz1N2K4cIgtxNRjypX5ODeX81IR3g.png', '2025-09-05 05:12:30'),
(13, 'RAM', 'asdf asdfasdfasdf', 1500.00, 'uploads/product/hc9zU9QmrPWxsDWzs8QTMkE1ZqHZvhOhux0UipIB.png', '2025-09-05 05:12:47'),
(14, 'GPU', 'asdfasd fasdfasdfasdfasdf', 50000.00, 'uploads/product/u7ggPDy94P2uki6Mn2Za8jCxTwVJpw7UHLGtYV14.png', '2025-09-05 05:13:20'),
(15, 'Power Supply', 'asdfasdfasdfasdf', 3250.00, 'uploads/product/AAR217YUEW1BfZ748ZcHnexJ1Yjztw6wHpX6iCbX.png', '2025-09-05 05:13:45'),
(16, 'Case', 'asdfasefeesdfas', 1600.00, 'uploads/product/k3tIZZQLrgY9Y2e7WXQGwMWX1q5wMgYQCLLutAPN.png', '2025-09-05 05:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(11) NOT NULL,
  `std_code` varchar(200) NOT NULL,
  `std_name` varchar(200) NOT NULL,
  `std_phone` varchar(10) NOT NULL,
  `std_img` varchar(200) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_test`
--

CREATE TABLE `tbl_test` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_test`
--

INSERT INTO `tbl_test` (`id`, `name`, `email`, `phone`) VALUES
(1, '222', '22@fdfdf', '2223434343'),
(2, '122', 'ss@g.com', '1111232324');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_username` (`admin_username`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `std_code` (`std_code`);

--
-- Indexes for table `tbl_test`
--
ALTER TABLE `tbl_test`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_test`
--
ALTER TABLE `tbl_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
