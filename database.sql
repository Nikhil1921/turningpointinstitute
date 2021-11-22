-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2021 at 10:09 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `turningpointinstitute`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `role` int(11) NOT NULL,
  `sub_menu` varchar(50) NOT NULL,
  `operation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`role`, `sub_menu`, `operation`) VALUES
(1, 'student', 'view'),
(1, 'student', 'add'),
(1, 'student', 'update'),
(1, 'student', 'delete'),
(1, 'ebook', 'view'),
(1, 'ebook', 'add'),
(1, 'ebook', 'update'),
(1, 'ebook', 'delete'),
(1, 'moduleVideo', 'view'),
(1, 'moduleVideo', 'add'),
(1, 'moduleVideo', 'update'),
(1, 'moduleVideo', 'delete'),
(1, 'module', 'view'),
(1, 'module', 'add'),
(1, 'module', 'update'),
(1, 'module', 'delete'),
(2, 'freeStudents', 'view'),
(2, 'freeStudents', 'update');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `language` varchar(30) NOT NULL,
  `ch_id` int(11) NOT NULL,
  `sub_ch_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `language`, `ch_id`, `sub_ch_id`, `is_deleted`, `description`) VALUES
(1, 'Gujarati', 1, 2, 0, '<p>sdsd</p>\r\n'),
(2, 'Gujarati', 4, 5, 0, '<p>sdsdggg</p>\r\n'),
(3, 'Gujarati', 1, 0, 0, '<p>RTre</p>\r\n'),
(4, 'Gujarati', 1, 0, 0, '<p>ffg</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `buy_ebook`
--

CREATE TABLE `buy_ebook` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `city` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `del_charge` varchar(5) NOT NULL,
  `u_id` bigint(20) NOT NULL,
  `status` enum('Pending','In Delivery','Delivered') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_membership`
--

CREATE TABLE `buy_membership` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `u_id` bigint(20) NOT NULL,
  `mem_id` smallint(6) NOT NULL,
  `expiry` datetime NOT NULL,
  `payment` varchar(10) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buy_membership`
--

INSERT INTO `buy_membership` (`id`, `u_id`, `mem_id`, `expiry`, `payment`, `pay_type`, `expired`) VALUES
(1, 1, 2, '2021-09-10 18:00:00', '999', 'Cash', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `ebook_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ch_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `ebook_id`, `title`, `ch_id`, `is_deleted`) VALUES
(1, 1, 'Chapter 1', 0, 0),
(2, 1, 'Simple past tense', 1, 0),
(3, 1, 'Simple present', 1, 0),
(4, 2, 'Chapter 2', 0, 0),
(5, 2, 'Perfect pase', 4, 0),
(6, 2, 'Perfect present', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `price` varchar(10) NOT NULL,
  `dicount_price` varchar(10) NOT NULL,
  `discount` varchar(3) NOT NULL,
  `details` text NOT NULL,
  `video` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`title`, `sub_title`, `price`, `dicount_price`, `discount`, `details`, `video`) VALUES
('test', 'test', '0', '0', '0', 'test', 'intro-video.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `ebook`
--

CREATE TABLE `ebook` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` varchar(10) NOT NULL,
  `discount` varchar(3) NOT NULL,
  `del_charge` varchar(5) NOT NULL,
  `details` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ebook`
--

INSERT INTO `ebook` (`id`, `title`, `price`, `discount`, `del_charge`, `details`, `image`, `admin_id`, `is_deleted`) VALUES
(1, 'The Incredible gujarat', '100', '50', '50', 'testing update', '1631170181.webp', 0, 0),
(2, 'test', '1000', '10', '50', 'dd', '1631526495.webp', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `follow_ups`
--

CREATE TABLE `follow_ups` (
  `id` bigint(20) NOT NULL,
  `stu_id` bigint(20) NOT NULL,
  `status` varchar(30) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` date NOT NULL,
  `created_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follow_ups`
--

INSERT INTO `follow_ups` (`id`, `stu_id`, `status`, `remark`, `created_by`, `created_date`, `created_time`) VALUES
(1, 3, 'Follow Up', 'sdds', 1, '2021-11-13', '18:28:54'),
(2, 3, 'Not interested', 'Final test', 1, '2021-11-13', '18:29:20'),
(3, 2, 'Follow Up', 'Tets', 1, '2021-11-17', '13:03:33'),
(4, 2, 'Follow Up', 'Hello', 8, '2021-11-17', '13:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id` smallint(6) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` varchar(10) NOT NULL,
  `duration` varchar(5) NOT NULL,
  `features` text NOT NULL,
  `duration_type` varchar(10) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `title`, `price`, `duration`, `features`, `duration_type`, `is_deleted`) VALUES
(1, 'One day free trial', '0', '1', 'Get full access of TP-English for 1 Day', 'Days', 1),
(2, '3 months plan', '999', '3', 'Get full access of TP-English for 3 months at cost of 999 Rs\r\n', 'Months', 0),
(3, '6 months plan', '1799', '6', 'Get full access of TP-English for 6 months at cost of 1799 Rs\r\n', 'Months', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `price` varchar(10) NOT NULL,
  `details` text NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `title`, `sub_title`, `price`, `details`, `admin_id`, `is_deleted`) VALUES
(1, 'module 1', 'basic english', '1000', 'basic structures with single verb', 0, 0),
(2, 'test', 'Food Truck', '0', 'ss', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_video`
--

CREATE TABLE `module_video` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_no` varchar(50) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `video` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `hindi_pdf` mediumtext DEFAULT NULL,
  `guj_pdf` mediumtext DEFAULT NULL,
  `admin_id` bigint(20) NOT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `module_video`
--

INSERT INTO `module_video` (`id`, `title`, `video_no`, `details`, `video`, `image`, `module_id`, `hindi_pdf`, `guj_pdf`, `admin_id`, `is_free`, `is_deleted`) VALUES
(3, 'ssd', 'sdsd', 'sdsd', '1637300779.mp4', NULL, 2, '<p>sssdsd</p>\r\n', '<p>fgfgfgffgfffffffffffff</p>\r\n', 1, 1, 0),
(4, 'test', '123', 'test', NULL, '1637307301.webp', 1, NULL, NULL, 1, 0, 0),
(5, 'title', '123', 'teest', '1637307379.mp4', '1637307365.webp', 2, '<p>test</p>\r\n', '<p>testttt</p>\r\n', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) CHARACTER SET latin1 NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET latin1 NOT NULL,
  `sub_menu` varchar(255) DEFAULT NULL,
  `priority` tinyint(2) DEFAULT NULL,
  `permissions` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `menu`, `url`, `icon`, `sub_menu`, `priority`, `permissions`) VALUES
(1, 'users', 'users', 'users', '{\"users\":\"user\",\"role\":\"role\"}', NULL, 'view, add, update, delete'),
(2, 'navigation', 'navigation', 'bars', NULL, NULL, 'view, add, update, delete'),
(3, 'students', 'student', 'graduation-cap', NULL, NULL, 'view, add, update, delete'),
(4, 'Banners', 'banner', 'image', NULL, NULL, 'view, add, delete'),
(5, 'Ebook', 'ebook', 'book', '{\"Ebook\":\"ebook\",\"Purchase\":\"purchase\",\"chapters\":\"chapter\",\"books\":\"book\"}', NULL, 'view, add, update, delete'),
(6, 'Membership', 'membership', 'user', NULL, NULL, 'view, add, update, delete'),
(7, 'course', 'course', 'book', '{\"module videos\":\"moduleVideo\",\"modules\":\"module\",\"course\":\"course\"}', NULL, 'view, add, update, delete'),
(8, 'questions', 'question', 'question-circle', NULL, NULL, 'view, add, update, delete'),
(9, 'Free Students', 'freeStudents', 'graduation-cap', NULL, NULL, 'view, update'),
(10, 'Follow up(s)', 'followUp', 'users', NULL, NULL, 'view');

-- --------------------------------------------------------

--
-- Table structure for table `otp_check`
--

CREATE TABLE `otp_check` (
  `mobile` varchar(10) NOT NULL,
  `otp` varchar(4) NOT NULL,
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  `options` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `language` enum('Gujarati','Hindi') NOT NULL,
  `test_type` enum('Blocks','Speaking','Writing') NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `video_id`, `module_id`, `options`, `answer`, `language`, `test_type`, `admin_id`, `is_deleted`) VALUES
(1, 'hu cha PIs', 4, 2, NULL, '[\"I take tea\",\"I will take tea\"]', 'Hindi', 'Blocks', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` tinyint(4) NOT NULL,
  `role` varchar(50) NOT NULL,
  `navigation` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`, `navigation`, `is_deleted`) VALUES
(1, 'Faculty', '3,5,7', 0),
(2, 'Staff', '9', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `free_membership` datetime DEFAULT NULL,
  `free_used` tinyint(1) NOT NULL DEFAULT 0,
  `admin_id` bigint(20) NOT NULL,
  `assign_id` bigint(20) NOT NULL DEFAULT 0,
  `registered` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `mobile`, `email`, `address`, `free_membership`, `free_used`, `admin_id`, `assign_id`, `registered`, `is_deleted`) VALUES
(1, '1234', '9974011111', 'testt@mail.com', 'test', '2021-09-11 15:50:52', 1, 0, 0, 0, 0),
(2, 'admin', '3333333333', 'jp@densetek.in', '203', '2021-09-17 00:00:00', 0, 0, 8, 0, 0),
(3, 'saurabh', '2344567890', 'saupatel37@gmail.com', 'test', '2021-09-11 00:00:00', 1, 1, 8, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `turningpointinstitute_session`
--

CREATE TABLE `turningpointinstitute_session` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `turningpointinstitute_session`
--

INSERT INTO `turningpointinstitute_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('445l2isjgj9v3bbfvtp9sm77fl2vqlmt', '::1', 1637312942, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633373331323636343b617574687c733a313a2231223b);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','User','Super Admin') NOT NULL,
  `sub_role` tinyint(4) NOT NULL,
  `otp` varchar(4) NOT NULL DEFAULT '1234',
  `last_update` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `admin_id` bigint(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `password`, `role`, `sub_role`, `otp`, `last_update`, `status`, `admin_id`, `is_deleted`) VALUES
(1, 'turningpointinstitute', '9537128259', 'info@turningpointinstitute.com', 'SE1KOEpaS2ZJV2Q4am5NUnpvNHVRQT09', 'Super Admin', 0, '6084', '2021-08-10 15:32:11', 'Active', 0, 0),
(7, 'Nikhil Patel', '1234567890', 'jp@densetek.in', 'UzI4L2xNM2xTNlFMb1l6TWdQWVJEdz09', 'Admin', 1, '1234', '2021-09-11 09:49:36', 'Active', 1, 0),
(8, 'staff', '9999999999', 'staff@mail.com', 'UzI4L2xNM2xTNlFMb1l6TWdQWVJEdz09', 'Admin', 2, '1234', '2021-11-13 16:54:59', 'Active', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buy_ebook`
--
ALTER TABLE `buy_ebook`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `buy_membership`
--
ALTER TABLE `buy_membership`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `follow_ups`
--
ALTER TABLE `follow_ups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_video`
--
ALTER TABLE `module_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turningpointinstitute_session`
--
ALTER TABLE `turningpointinstitute_session`
  ADD PRIMARY KEY (`id`,`ip_address`),
  ADD KEY `turningpointinstitute_session_timestamp` (`timestamp`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buy_ebook`
--
ALTER TABLE `buy_ebook`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_membership`
--
ALTER TABLE `buy_membership`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ebook`
--
ALTER TABLE `ebook`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `follow_ups`
--
ALTER TABLE `follow_ups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `module_video`
--
ALTER TABLE `module_video`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
