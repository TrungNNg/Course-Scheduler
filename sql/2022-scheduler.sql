-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 03, 2022 at 05:55 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2022-scheduler`
--

CREATE DATABASE IF NOT EXISTS `2022-scheduler` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `2022-scheduler`;

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `BUID` int(11) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  `long_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`BUID`, `short_name`, `long_name`) VALUES
(1, 'SH', 'Science Hall'),
(2, 'CSB', 'Coykendall Science Building'),
(3, 'HUM', 'Humanities Building'),
(4, 'LC', 'Lecture Center'),
(5, 'OM', 'Old Main');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CID` int(11) NOT NULL,
  `short_name` varchar(11) NOT NULL,
  `long_name` varchar(60) NOT NULL,
  `credit` smallint(6) NOT NULL,
  `is_lab` tinyint(1) NOT NULL,
  `is_grad` tinyint(1) NOT NULL,
  `Attributes` varchar(50) NOT NULL,
  `DEID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CID`, `short_name`, `long_name`, `credit`, `is_lab`, `is_grad`, `Attributes`, `DEID`) VALUES
(2, 'CPS210', 'Computer Science I: Foundation', 4, 0, 0, '', 1),
(3, 'CPS310', 'Computer Science II: Data Structure', 4, 0, 0, '', 1),
(4, 'CPS315', 'Computer Science III', 4, 0, 0, '', 1),
(5, 'CPS330', 'Assembly Language and Computer Architecture', 4, 0, 0, '', 1),
(6, 'CPS425', 'Language Processing', 4, 0, 0, '', 1),
(7, 'CPS340', 'Operating System', 4, 0, 0, '', 1),
(8, 'CPS352', 'Object Oriented Programming', 3, 0, 0, '', 1),
(9, 'CPS353', 'Software Engineering', 3, 0, 0, '', 1),
(10, 'CPS415', 'Discrete and Continuous Computer Algorithms', 3, 0, 0, '', 1),
(11, 'CPS485', 'Projects', 4, 0, 0, '', 1),
(12, 'CPS493', 'CS Electives', 3, 0, 0, '', 1),
(13, 'CPS104', 'Visual Programming', 3, 0, 0, '', 1),
(14, 'CPS110', 'Web Page Design', 3, 0, 0, '', 1),
(15, 'MAT320', 'Discrete Mathematic for Computing', 3, 0, 0, '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DEID` int(11) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  `long_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DEID`, `short_name`, `long_name`) VALUES
(1, 'CPS', 'Computer Science'),
(2, 'MAT', 'Mathematic');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `FID` int(11) NOT NULL,
  `DEID` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`FID`, `DEID`, `name`, `email`, `password`, `role`) VALUES
(1, 1, 'Kristin Mayo', '', '', 4),
(2, 1, 'Kaitlin Hoffmann', '', '', 4),
(3, 1, 'Jon Seager', '', '', 4),
(4, 1, 'Lieb Mathieson', '', '', 4),
(5, 1, 'Shivangi Kakkar', '', '', 4),
(6, 1, 'Ashley Suchy', '', '', 4),
(8, 1, 'Spandana Mareddy', '', '', 4),
(9, 1, 'Min Chen', '', '', 4),
(10, 1, 'Alekhya Akki', '', '', 4),
(11, 1, 'Anthony Dos Reis', '', '', 4),
(12, 1, 'Nazim Wali', '', '', 4),
(13, 1, 'Hanh Pham', '', '', 4),
(16, 1, 'Venkata Siva Narra', '', '', 4),
(17, 1, 'Anthony Denizard', '', '', 4),
(18, 1, 'Kenqin Li', '', '', 4),
(19, 1, 'Sai Pavan Veluguri', '', '', 4),
(20, 1, 'Moshe Plotkin', '', '', 4),
(21, 1, 'Chirakkal Easwaran', '', '', 2),
(24, 1, 'Masker Leslie', '', '', 3),
(25, 1, 'admin', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `LID` int(11) NOT NULL,
  `SCID` int(11) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `days` varchar(10) NOT NULL,
  `ROID` int(11) NOT NULL,
  `FID` int(11) NOT NULL,
  `duration` int(5) NOT NULL,
  `days_per_week` int(5) NOT NULL,
  `locked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab`
--

INSERT INTO `lab` (`LID`, `SCID`, `start_time`, `end_time`, `days`, `ROID`, `FID`, `duration`, `days_per_week`, `locked`) VALUES
(1, 3, '', '', '', 1, 3, 170, 1, 0),
(2, 3, '', '', '', 1, 3, 170, 1, 0),
(3, 3, '', '', '', 1, 4, 170, 1, 0),
(4, 4, '', '', '', 1, 4, 170, 1, 0),
(5, 4, '', '', '', 1, 5, 170, 1, 0),
(6, 4, '', '', '', 1, 4, 170, 1, 0),
(7, 5, '', '', '', 9, 5, 170, 1, 0),
(8, 5, '', '', '', 9, 16, 170, 1, 0),
(9, 5, '', '', '', 9, 8, 170, 1, 0),
(10, 5, '', '', '', 11, 8, 170, 1, 0),
(11, 6, '', '', '', 13, 10, 170, 1, 0),
(12, 6, '', '', '', 13, 10, 170, 1, 0),
(13, 6, '', '', '', 13, 10, 170, 1, 0),
(14, 7, '', '', '', 9, 12, 170, 1, 0),
(15, 7, '', '', '', 9, 12, 170, 1, 0),
(16, 8, '', '', '', 1, 16, 170, 1, 0),
(17, 8, '', '', '', 1, 16, 170, 1, 0),
(18, 12, '', '', '', 9, 19, 170, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `LLID` int(11) NOT NULL,
  `phrase` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `requisite`
--

CREATE TABLE `requisite` (
  `RID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `has_preq` tinyint(1) NOT NULL,
  `has_coreq` tinyint(1) NOT NULL,
  `REID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requisite`
--

INSERT INTO `requisite` (`RID`, `CID`, `has_preq`, `has_coreq`, `REID`) VALUES
(1, 3, 1, 0, 2),
(2, 4, 1, 0, 3),
(3, 5, 1, 0, 3),
(4, 6, 1, 0, 4),
(5, 6, 1, 0, 3),
(6, 7, 1, 0, 5),
(7, 8, 1, 0, 3),
(8, 9, 1, 0, 8),
(9, 10, 1, 0, 15),
(10, 15, 1, 0, 3),
(11, 11, 1, 0, 9),
(12, 12, 1, 0, 3),
(13, 11, 1, 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `ROID` int(11) NOT NULL,
  `BUID` int(11) NOT NULL,
  `short_name` varchar(7) NOT NULL,
  `room_num` varchar(4) NOT NULL,
  `seats` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`ROID`, `BUID`, `short_name`, `room_num`, `seats`) VALUES
(1, 1, 'SH 259', '259', 25),
(2, 3, 'HUM 116', '116', 30),
(3, 2, 'CSB 001', '001', 30),
(4, 2, 'SH 181', '181', 30),
(5, 4, 'LC 104', '104', 30),
(6, 2, 'CSB 023', '023', 30),
(7, 3, 'HUM 201', '201', 30),
(8, 3, 'HUM 113', '113', 30),
(9, 1, 'SH 271', '271', 30),
(10, 2, 'CBS AUD', 'AUD', 30),
(11, 4, 'LC 110', '110', 30),
(12, 4, 'LC 109', '109', 30),
(13, 3, 'HUM 301', '301', 30),
(14, 3, 'HUM 320', '320', 30),
(16, 3, 'HUM 111', '111', 30),
(17, 4, 'LC 103', '103', 30),
(18, 5, 'OM 230', '230', 30),
(19, 3, 'HUM 218', '218', 30),
(20, 5, 'OM 231', '231', 30),
(21, 5, 'OM 238', '238', 30),
(22, 4, 'LC 108', '108', 30);

-- --------------------------------------------------------

--
-- Table structure for table `scheduler`
--

CREATE TABLE `scheduler` (
  `SCID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `SEID` int(11) NOT NULL,
  `section` smallint(2) NOT NULL,
  `days_per_week` int(5) NOT NULL,
  `duration` int(5) NOT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `days` varchar(7) DEFAULT NULL,
  `FID` int(11) NOT NULL,
  `ROID` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scheduler`
--

INSERT INTO `scheduler` (`SCID`, `CID`, `SEID`, `section`, `days_per_week`, `duration`, `start_time`, `end_time`, `days`, `FID`, `ROID`, `locked`) VALUES
(1, 13, 2, 1, 1, 170, NULL, NULL, NULL, 1, 1, 0),
(2, 14, 2, 1, 1, 170, NULL, NULL, NULL, 1, 9, 0),
(3, 2, 2, 1, 2, 75, NULL, NULL, NULL, 2, 4, 0),
(4, 2, 2, 2, 2, 75, NULL, NULL, NULL, 2, 10, 0),
(5, 3, 2, 1, 2, 75, NULL, NULL, NULL, 6, 7, 0),
(6, 4, 2, 1, 2, 75, NULL, NULL, NULL, 9, 12, 0),
(7, 5, 2, 1, 2, 75, NULL, NULL, NULL, 11, 14, 0),
(8, 7, 2, 1, 2, 75, NULL, NULL, NULL, 13, 16, 0),
(9, 8, 2, 1, 2, 75, NULL, NULL, NULL, 9, 17, 0),
(10, 9, 2, 1, 2, 75, NULL, NULL, NULL, 17, 18, 0),
(11, 10, 2, 1, 2, 75, NULL, NULL, NULL, 18, 19, 0),
(12, 6, 2, 1, 2, 75, NULL, NULL, NULL, 11, 13, 0),
(13, 11, 2, 1, 1, 230, NULL, NULL, NULL, 13, 20, 0),
(14, 11, 2, 2, 1, 230, NULL, NULL, NULL, 13, 18, 0),
(15, 12, 2, 1, 2, 75, NULL, NULL, NULL, 20, 22, 0),
(16, 12, 2, 2, 2, 75, NULL, NULL, NULL, 9, 18, 0);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `SEID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`SEID`, `name`, `start_date`, `end_date`) VALUES
(1, 'Fall 2022', '2022-08-29', '2022-12-21'),
(2, 'Spring 2023', '2023-01-23', '2023-05-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`BUID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CID`),
  ADD KEY `DEID` (`DEID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DEID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`FID`),
  ADD KEY `DEID` (`DEID`);

--
-- Indexes for table `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`LID`),
  ADD KEY `SCID` (`SCID`),
  ADD KEY `ROID` (`ROID`),
  ADD KEY `FID` (`FID`);

--
-- Indexes for table `requisite`
--
ALTER TABLE `requisite`
  ADD PRIMARY KEY (`RID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `REID` (`REID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`ROID`),
  ADD KEY `BUID` (`BUID`);

--
-- Indexes for table `scheduler`
--
ALTER TABLE `scheduler`
  ADD PRIMARY KEY (`SCID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `lecture_FID` (`FID`),
  ADD KEY `lecture_ROID` (`ROID`),
  ADD KEY `SEID` (`SEID`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`SEID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `BUID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `FID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `lab`
--
ALTER TABLE `lab`
  MODIFY `LID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `requisite`
--
ALTER TABLE `requisite`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `ROID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `scheduler`
--
ALTER TABLE `scheduler`
  MODIFY `SCID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `SEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`DEID`) REFERENCES `department` (`DEID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`DEID`) REFERENCES `department` (`DEID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lab`
--
ALTER TABLE `lab`
  ADD CONSTRAINT `lab_ibfk_1` FOREIGN KEY (`SCID`) REFERENCES `scheduler` (`SCID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lab_ibfk_2` FOREIGN KEY (`ROID`) REFERENCES `rooms` (`ROID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lab_ibfk_3` FOREIGN KEY (`FID`) REFERENCES `faculty` (`FID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `requisite`
--
ALTER TABLE `requisite`
  ADD CONSTRAINT `requisite_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `course` (`CID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `requisite_ibfk_2` FOREIGN KEY (`REID`) REFERENCES `course` (`CID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`BUID`) REFERENCES `building` (`BUID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `scheduler`
--
ALTER TABLE `scheduler`
  ADD CONSTRAINT `scheduler_ibfk_1` FOREIGN KEY (`ROID`) REFERENCES `rooms` (`ROID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `scheduler_ibfk_2` FOREIGN KEY (`CID`) REFERENCES `course` (`CID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `scheduler_ibfk_3` FOREIGN KEY (`SEID`) REFERENCES `semester` (`SEID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `scheduler_ibfk_4` FOREIGN KEY (`FID`) REFERENCES `faculty` (`FID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
