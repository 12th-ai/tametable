-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 05, 2024 at 05:53 PM
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
-- Database: `time_table_generator`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
(1, 'l4sod'),
(2, 'l5sod'),
(3, 'l5rct'),
(4, 'l4mas'),
(5, 'Qui assumenda at pos'),
(6, 'kj'),
(7, 'l3 cst'),
(8, 'l4 sod '),
(9, 'l5 sod'),
(10, 'l 3 rct '),
(11, 'l4 rct'),
(12, 'l5 rct '),
(13, 'l3 mas '),
(14, 'l 4 mas'),
(15, 'l 5 mas');

-- --------------------------------------------------------

--
-- Table structure for table `class_stream`
--

CREATE TABLE `class_stream` (
  `class_stream_id` int(11) NOT NULL,
  `class_stream_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_stream`
--

INSERT INTO `class_stream` (`class_stream_id`, `class_stream_name`) VALUES
(1, 'e'),
(2, 'l4sod a'),
(3, 'l4 sod b'),
(4, 'l5 mas a'),
(5, 'l5 rct b');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`) VALUES
(1, 'math'),
(2, 'english'),
(3, 'kiny'),
(4, 'Consectetur voluptas'),
(5, 'france'),
(6, 'physics'),
(7, 'kiswahili'),
(8, 'algorithm'),
(9, 'chemistry'),
(10, 'biology');

-- --------------------------------------------------------

--
-- Table structure for table `fixed_event`
--

CREATE TABLE `fixed_event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fixed_event`
--

INSERT INTO `fixed_event` (`event_id`, `event_name`, `start_time`, `end_time`) VALUES
(1, 'A deleniti ipsa con', '01:56:00', '00:08:00'),
(2, 'A deleniti ipsa con', '08:12:00', '21:17:00'),
(3, 'Aliquip et maiores c', '15:21:00', '03:21:00'),
(4, 'break1', '10:20:00', '10:40:00'),
(5, 'lunch', '12:30:00', '13:30:00'),
(6, 'break 2', '15:45:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_name`) VALUES
(1, 'marceil'),
(2, 'cloude'),
(3, 'fidel'),
(4, 'jack'),
(5, 'Nisi qui impedit te'),
(6, 'chantal'),
(7, 'jose'),
(8, 'camile'),
(9, 'eric'),
(10, 'patrick');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_stream`
--
ALTER TABLE `class_stream`
  ADD PRIMARY KEY (`class_stream_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `fixed_event`
--
ALTER TABLE `fixed_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `class_stream`
--
ALTER TABLE `class_stream`
  MODIFY `class_stream_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fixed_event`
--
ALTER TABLE `fixed_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
