-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 07:40 PM
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
-- Table structure for table `taskinfos`
--

CREATE TABLE `taskinfos` (
  `taskID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `taskName` varchar(100) NOT NULL,
  `taskDesc` varchar(300) DEFAULT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `taskLabel` varchar(50) DEFAULT NULL,
  `taskCategory` varchar(50) DEFAULT NULL,
  `taskFile` varchar(255) DEFAULT NULL,
  `isDone` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taskinfos`
--

INSERT INTO `taskinfos` (`taskID`, `ID`, `taskName`, `taskDesc`, `startTime`, `endTime`, `taskLabel`, `taskCategory`, `taskFile`, `isDone`) VALUES
(4, 17, 'Simplify', 'tm', '2025-05-28 13:52:00', '2025-05-30 19:53:00', 'dev', 'development', '../../asset/upload/taskFiles/1748288924_cnLab_22461301.pdf', 0),
(5, 21, 'WebAPP', 'asd', '2025-05-28 03:44:00', '2025-05-30 03:43:00', 'asd', 'development', 'asset/upload/taskFiles/1748295850_cnLab_22461301.pdf', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `taskinfos`
--
ALTER TABLE `taskinfos`
  ADD PRIMARY KEY (`taskID`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `taskinfos`
--
ALTER TABLE `taskinfos`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `taskinfos`
--
ALTER TABLE `taskinfos`
  ADD CONSTRAINT `taskinfos_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `userinfos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
-- Table structure for table `subtasks`
--
CREATE TABLE `subtasks` (
  `subtaskID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `subtaskName` varchar(100) NOT NULL,
  `subtaskDesc` varchar(300) DEFAULT NULL,
  `isDone` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`subtaskID`),
  ADD KEY `taskID` (`taskID`);

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `subtaskID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`taskID`) REFERENCES `taskinfos` (`taskID`) ON DELETE CASCADE ON UPDATE CASCADE;
