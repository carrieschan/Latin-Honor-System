-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2023 at 05:41 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sample_sis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin`, `password`) VALUES
(12, 'admin', 'admin'),
(28, 'adminharrel', 'adminharrel123'),
(29, 'adminharrel', 'adminharrel123');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `middleinitial` varchar(50) NOT NULL,
  `studentnumber` varchar(15) NOT NULL,
  `course` varchar(10) NOT NULL,
  `birthmonth` text NOT NULL,
  `birthdate` int(3) NOT NULL,
  `birthyear` int(5) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `surname`, `firstname`, `middleinitial`, `studentnumber`, `course`, `birthmonth`, `birthdate`, `birthyear`, `password`) VALUES
(84, 'Alejandro', 'Andrei James', 'S', '2021-00153-TG-0', 'BSIT', 'October', 9, 2003, 'Aa#123456'),
(85, 'Monroy', 'Jeff Carl', 'C', '2021-00187-TG-0', 'BSIT', 'May', 2, 2003, 'Jc#987654'),
(86, 'Nabayra', 'James Villaruel', 'D', '2021-00129-TG-0', 'BSIT', 'June', 29, 2002, 'Jv#456789'),
(87, 'Martinez', 'Miles Emmanuel', 'Q', '2019-00233-TG-0', 'BSIT', 'Sept', 18, 2001, 'Me#654321'),
(88, 'Gomez', 'Juan Paolo', 'R', '2022-00123-TG-0', 'DICT', 'January', 15, 2004, 'Jp#DICT123'),
(89, 'Ramos', 'Maria Sofia', 'M', '2022-00145-TG-0', 'DICT', 'April', 5, 2003, 'Ms#DICT456'),
(90, 'Lopez', 'Diego Miguel', 'P', '2022-00165-TG-0', 'DICT', 'July', 12, 2002, 'Dm#DICT789'),
(91, 'Santos', 'Isabella', 'L', '2022-00189-TG-0', 'DICT', 'November', 22, 2001, 'Il#DICT987'),
(92, 'Naoe', 'Adrian', 'B', '2022-00199-TG-0', 'BSIT', 'March', 24, 2003, 'Adrian@24Naoe');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `studentnumber1` varchar(15) NOT NULL,
  `first_sem_avg_1` decimal(3,2) NOT NULL,
  `second_sem_avg_1` decimal(3,2) NOT NULL,
  `first_sem_avg_2` decimal(3,2) NOT NULL,
  `second_sem_avg_2` decimal(3,2) NOT NULL,
  `first_sem_avg_3` decimal(3,2) NOT NULL,
  `second_sem_avg_3` decimal(3,2) NOT NULL,
  `first_sem_avg_4` decimal(3,2) NOT NULL,
  `second_sem_avg_4` decimal(3,2) NOT NULL,
  `summer_avg` decimal(3,2) NOT NULL,
  `yr_1_final_ave` decimal(3,2) NOT NULL,
  `yr_2_final_ave` decimal(3,2) NOT NULL,
  `yr_3_final_ave` decimal(3,2) NOT NULL,
  `yr_4_final_ave` decimal(3,2) NOT NULL,
  `final_average` decimal(3,2) NOT NULL,
  `academicDistinction` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`studentnumber1`, `first_sem_avg_1`, `second_sem_avg_1`, `first_sem_avg_2`, `second_sem_avg_2`, `first_sem_avg_3`, `second_sem_avg_3`, `first_sem_avg_4`, `second_sem_avg_4`, `summer_avg`, `yr_1_final_ave`, `yr_2_final_ave`, `yr_3_final_ave`, `yr_4_final_ave`, `final_average`, `academicDistinction`) VALUES
('2021-00129-TG-0', '1.50', '1.70', '1.75', '1.80', '1.45', '1.40', '1.60', '1.67', '1.25', '1.60', '1.78', '1.43', '1.64', '1.54', 'Cum Laude'),
('2021-00153-TG-0', '1.33', '1.25', '1.50', '1.53', '1.00', '1.00', '1.11', '1.13', '1.12', '1.29', '1.52', '1.00', '1.12', '1.21', 'Magna Cum Laude '),
('2021-00187-TG-0', '1.20', '1.10', '1.15', '1.11', '1.13', '1.23', '1.00', '1.00', '1.00', '1.15', '1.13', '1.18', '1.00', '1.09', 'Summa Cum Laude '),
('2022-00199-TG-0', '1.33', '1.25', '1.07', '1.21', '1.00', '1.11', '1.13', '1.14', '1.00', '1.29', '1.14', '1.06', '1.14', '1.12', 'Summa Cum Laude ');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades_dit`
--

CREATE TABLE `student_grades_dit` (
  `studentnumber2` varchar(15) NOT NULL,
  `first_sem_avg_1` decimal(3,2) NOT NULL,
  `second_sem_avg_1` decimal(3,2) NOT NULL,
  `first_sem_avg_2` decimal(3,2) NOT NULL,
  `second_sem_avg_2` decimal(3,2) NOT NULL,
  `first_sem_avg_3` decimal(3,2) NOT NULL,
  `second_sem_avg_3` decimal(3,2) NOT NULL,
  `summer_avg` decimal(3,2) NOT NULL,
  `yr_1_final_ave` decimal(3,2) NOT NULL,
  `yr_2_final_ave` decimal(3,2) NOT NULL,
  `yr_3_final_ave` decimal(3,2) NOT NULL,
  `final_average` decimal(3,2) NOT NULL,
  `academicDistinction` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_grades_dit`
--

INSERT INTO `student_grades_dit` (`studentnumber2`, `first_sem_avg_1`, `second_sem_avg_1`, `first_sem_avg_2`, `second_sem_avg_2`, `first_sem_avg_3`, `second_sem_avg_3`, `summer_avg`, `yr_1_final_ave`, `yr_2_final_ave`, `yr_3_final_ave`, `final_average`, `academicDistinction`) VALUES
('2022-00123-TG-0', '1.00', '1.25', '1.13', '1.24', '1.16', '1.00', '1.03', '1.13', '1.19', '1.08', '1.11', 'Summa Cum Laude '),
('2022-00145-TG-0', '1.50', '1.55', '1.25', '1.30', '1.46', '1.33', '1.07', '1.53', '1.28', '1.40', '1.32', 'Magna Cum Laude '),
('2022-00165-TG-0', '1.69', '1.60', '1.70', '1.76', '1.59', '1.68', '1.59', '1.65', '1.73', '1.64', '1.65', 'Cum Laude');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studentnumber` (`studentnumber`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`studentnumber1`),
  ADD UNIQUE KEY `studentnumber1` (`studentnumber1`),
  ADD KEY `student_id` (`studentnumber1`);

--
-- Indexes for table `student_grades_dit`
--
ALTER TABLE `student_grades_dit`
  ADD PRIMARY KEY (`studentnumber2`),
  ADD UNIQUE KEY `studentnumber2` (`studentnumber2`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
