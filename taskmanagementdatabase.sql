-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 11:59 PM
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
-- Database: `taskmanagementdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `subtaskID` int(11) NOT NULL,
  `taskID` int(11) DEFAULT NULL,
  `subtaskName` varchar(255) NOT NULL,
  `subtaskDesc` text DEFAULT NULL,
  `isDone` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`subtaskID`, `taskID`, `subtaskName`, `subtaskDesc`, `isDone`, `created_at`) VALUES
(1, 3, 'project', 'lab project', 0, '2026-01-13 23:02:22'),
(3, 5, 'Golden Ball', '', 1, '2026-01-13 23:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `taskinfos`
--

CREATE TABLE `taskinfos` (
  `taskID` int(11) NOT NULL,
  `ID` int(11) DEFAULT NULL,
  `taskName` varchar(255) NOT NULL,
  `taskDesc` text DEFAULT NULL,
  `taskLabel` varchar(100) DEFAULT NULL,
  `taskCategory` varchar(100) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `taskFile` varchar(500) DEFAULT NULL,
  `isDone` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taskinfos`
--

INSERT INTO `taskinfos` (`taskID`, `ID`, `taskName`, `taskDesc`, `taskLabel`, `taskCategory`, `startTime`, `endTime`, `taskFile`, `isDone`, `created_at`) VALUES
(1, 2, 'Lab task', 'webtech lab task', '', 'development', '2026-01-06 07:36:00', '2026-01-17 07:36:00', 'asset/upload/taskFiles/1768268196_WT Final Assignment.pdf', 1, '2026-01-13 01:36:36'),
(2, 2, 'Class Work', 'class work', '', 'design', '2026-01-13 07:51:00', '2026-01-27 07:51:00', 'asset/upload/taskFiles/1768269097_Practice Math-Inventory Management.docx', 0, '2026-01-13 01:51:37'),
(3, 5, 'Submit lab report', 'Database lab report', '', 'education', '2026-01-12 05:01:00', '2026-01-16 05:01:00', 'asset/upload/taskFiles/1768345314_report.docx', 0, '2026-01-13 23:01:54'),
(4, 5, 'Research paper completion', 'Machine learning research paper', '', 'research', '2026-01-14 05:04:00', '2026-01-20 05:04:00', 'asset/upload/taskFiles/1768345521_ETSD_2026_flyer.pdf', 0, '2026-01-13 23:05:21'),
(5, 7, 'Win World Cup', 'FIFA world cup 2022', '', 'others', '2022-11-20 05:15:00', '2022-12-18 05:15:00', 'asset/upload/taskFiles/1768346297_Case Study 1.docx', 1, '2026-01-13 23:18:17'),
(6, 7, 'Ballon d\\\'or', '8th ballon d\\\'or', '', 'others', '2026-01-14 05:20:00', '2026-01-15 05:20:00', 'asset/upload/taskFiles/1768346480_Case Study 2.docx', 1, '2026-01-13 23:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `userinfos`
--

CREATE TABLE `userinfos` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `selfImage` varchar(500) DEFAULT NULL,
  `role` enum('User','Admin') DEFAULT 'User',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfos`
--

INSERT INTO `userinfos` (`id`, `firstname`, `lastname`, `email`, `password`, `phone`, `dob`, `gender`, `address`, `selfImage`, `role`, `created_at`) VALUES
(1, 'Anika', 'Mosh', 'admin@email.com', 'anika1234', NULL, NULL, NULL, NULL, NULL, 'User', '2026-01-12 00:43:48'),
(2, 'anika', 'moshfirat', 'anika@gmail.com', '$2y$10$Uv/okuFTV7/510W67QSd9Okv7nkCswFlr0tfjG9E4g/MQhc1agGh2', '012587638476', '2003-02-19', 'Female', 'aiub', 'asset/upload/profilePic/1768178762_cute minimalist flower desktop wallpaper (2).png', 'Admin', '2026-01-12 00:46:02'),
(3, 'Anni', 'anii', 'admin@gmail.com', '1234anika', NULL, NULL, NULL, NULL, NULL, 'User', '2026-01-13 01:57:03'),
(5, 'Nafisa', 'Naznin', 'nafisa@gmail.com', '$2y$10$QcaFEywq27DBMGIk6.ZDZOH0VD23myIx8xp9YiPL.YQDzUxpd83oe', '01345738921', '2018-07-27', 'Female', 'Dhaka ', 'asset/upload/profilePic/1768341136_messsi.jpg', 'User', '2026-01-13 21:52:16'),
(6, 'Masha', 'B', 'masha@gmail.com', '$2y$10$/lzUWzYf.GjrYOTkq8Qkt.8okmYtkwy.PIEY3z0OmqcHuInR7P.Gm', '01744202361', '2021-01-01', 'Female', 'Bangladesh ', 'asset/upload/profilePic/1768345814_images.jpg', 'User', '2026-01-13 23:10:14'),
(7, 'Lionel ', 'Messi', 'lm10@gmail.com', '$2y$10$Pe6o75uLGaNGK1O15rLz6emHnneE.i/88uTIvS5tV2B6Zem5rM5Bi', '01744202527', '1987-06-24', 'Male', 'Argentina ', 'asset/upload/profilePic/1768345998_messi.jpg', 'User', '2026-01-13 23:13:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`subtaskID`),
  ADD KEY `taskID` (`taskID`);

--
-- Indexes for table `taskinfos`
--
ALTER TABLE `taskinfos`
  ADD PRIMARY KEY (`taskID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `userinfos`
--
ALTER TABLE `userinfos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `subtaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taskinfos`
--
ALTER TABLE `taskinfos`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `userinfos`
--
ALTER TABLE `userinfos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`taskID`) REFERENCES `taskinfos` (`taskID`) ON DELETE CASCADE;

--
-- Constraints for table `taskinfos`
--
ALTER TABLE `taskinfos`
  ADD CONSTRAINT `taskinfos_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `userinfos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
