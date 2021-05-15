-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2021 at 04:25 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_db`
--

CREATE TABLE `activity_db` (
  `activity_num` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `activity_name` varchar(50) NOT NULL,
  `activity_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_db`
--

INSERT INTO `activity_db` (`activity_num`, `id`, `activity_name`, `activity_type`) VALUES
(1, 6, 'อาบน้ำ/ตัดขน', 'clear'),
(2, 6, 'ออกกำลังกาย', 'sport'),
(4, 10, 'อาบน้ำ/ตัดขน', 'clear'),
(5, 12, 'อาบน้ำ/เป่าขน/ตัดขน', 'clear'),
(8, 16, 'เดินเล่น', 'travel');

-- --------------------------------------------------------

--
-- Table structure for table `booking_db`
--

CREATE TABLE `booking_db` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `booking_staff_name` varchar(50) NOT NULL,
  `booking_driver_name` varchar(50) NOT NULL,
  `booking_activity_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_db`
--

INSERT INTO `booking_db` (`booking_id`, `customer_id`, `host_id`, `booking_staff_name`, `booking_driver_name`, `booking_activity_name`) VALUES
(16, 13, 12, 'พัชราภา ไชยเชื้ออ', 'เขมนิจ จามิกรณ์', 'อาบน้ำ/ตัดขน'),
(17, 13, 12, 'พัชราภา ไชยเชื้ออ', 'No', 'ออกกำลังกาย'),
(18, 15, 12, 'พัชราภา ไชยเชื้ออ', 'No', 'ออกกำลังกาย'),
(19, 15, 12, 'พัชราภา ไชยเชื้ออ', 'No', 'อาบน้ำ/ตัดขน'),
(20, 15, 16, 'กร คุณาธิปอภิสิริ', 'No', 'เดินเล่น'),
(21, 13, 16, 'กร คุณาธิปอภิสิริ', 'No', 'เดินเล่น'),
(22, 15, 16, 'กร คุณาธิปอภิสิริ', 'คุณสำรวย แซ่เฮง', 'อาบน้ำ/ตัดขน');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driver_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `driver_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `id`, `driver_name`, `driver_phone`) VALUES
(2, 6, 'คุณสำรวย แซ่เฮง', '089-666-8888'),
(4, 10, 'คุณสำรวย แซ่ลี้ลล', '089-666-8888'),
(5, 12, 'เขมนิจ จามิกรณ์', '089-666-8888'),
(8, 16, 'คุณสำรวย แซ่เฮง', '089-666-8888');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `img_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `img_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`img_id`, `id`, `img_name`, `img_path`, `img_type`) VALUES
(1, 13, 'test_profile_cat.jpg', 'img_db/test_profile_cat.jpg', 'image/jpeg'),
(3, 12, 'hotel_pic.jpg', 'img_db/hotel_pic.jpg', 'image/jpeg'),
(4, 15, 'user2.jpeg', 'img_db/user2.jpeg', 'image/jpeg'),
(5, 16, 'review-Kofuku-Cat-Hotel-17.jpg', 'img_db/review-Kofuku-Cat-Hotel-17.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `staff_person`
--

CREATE TABLE `staff_person` (
  `staff_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `staff_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_person`
--

INSERT INTO `staff_person` (`staff_id`, `id`, `staff_name`, `staff_phone`) VALUES
(4, 6, 'พิมพ์ชนก ลือวิเศษไพบูลย์', '085-666-5554'),
(5, 6, 'พิมพ์ชนก ลือวิเศษไพบูลย์', '085-666-5554'),
(7, 10, 'สุภัสสรา ธนชาต', '089-999-9999'),
(9, 12, 'พัชราภา ไชยเชื้ออ', '089-999-9998'),
(12, 16, 'กร คุณาธิปอภิสิริ', '081-111-1111');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat`
--

CREATE TABLE `tbl_chat` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `chat` text NOT NULL,
  `chat_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_chat`
--

INSERT INTO `tbl_chat` (`id`, `customer_id`, `host_id`, `name`, `chat`, `chat_time`) VALUES
(1, 15, 12, 'BINGSU', 'ddgsgxds', '2020-07-03 19:44:14'),
(2, 15, 12, 'BINGSU', 'ddgsgxds', '2020-07-03 19:44:42'),
(3, 15, 12, 'BINGSU', 'สวัสดี', '2020-07-03 19:47:56'),
(4, 15, 12, 'เจ้าหน้าที่', 'สวัสดีครับ มีอะไรให้ช่วยมั้ยครับ', '2020-07-03 20:25:08'),
(5, 15, 16, 'ลูกค้า', 'สวัสดีครับ', '2020-07-03 20:48:27'),
(6, 15, 16, 'ลูกค้า', 'สอบถามราคาที่พักหน่อยครับ', '2020-07-03 20:48:58'),
(7, 13, 16, 'บิว', 'สวัสดีครับ มีห้องว่างมั้ยครับ', '2020-07-03 20:50:39'),
(8, 13, 16, 'พนักงาน', 'มีครับ', '2020-07-03 20:51:52'),
(9, 15, 16, 'พนักงาน', 'ห้องคีนละ1000', '2020-07-03 20:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `address`, `phone`, `role`) VALUES
(3, 'admin_1', 'admin@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'admin', 'admin', '080-000-0000', 'admin'),
(12, 'hoteltest', 'hoteltest@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'บ๊อก บ๊อก เฮ้าส์', '172 33-34 ซอย เมืองทองธานี ตำบลบางพูด อำเภอปากเกร็ด นนทบุรี 11120', '083-863-5656', 'host'),
(13, 'usertest', 'usertest@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'ไลลา บุญยศักดิ์', 'บ้าน', '085-555-5555', 'user'),
(14, 'hotel2', 'hotel2@gmail.com', 'bcbe3365e6ac95ea2c0343a2395834dd', 'Meganeko Cat Hotel ', 'รามคำแหง', '083-435-6595', 'host'),
(15, 'user2', 'user2@gmail.com', 'bcbe3365e6ac95ea2c0343a2395834dd', 'ไอเหมียว', 'กรุงเทพ', '086-636-9393', 'user'),
(16, 'hotel3', 'hotel3@gmail.com', '310dcbbf4cce62f762a2aaa148d556bd', 'โรงแรมแมวโคฟูกุ', 'พระราม 9', '085-667-7777', 'host');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_db`
--
ALTER TABLE `activity_db`
  ADD PRIMARY KEY (`activity_num`);

--
-- Indexes for table `booking_db`
--
ALTER TABLE `booking_db`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `staff_person`
--
ALTER TABLE `staff_person`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_db`
--
ALTER TABLE `activity_db`
  MODIFY `activity_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `booking_db`
--
ALTER TABLE `booking_db`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_person`
--
ALTER TABLE `staff_person`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
