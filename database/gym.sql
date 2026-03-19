-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2026 at 09:11 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ad_id` int(11) NOT NULL,
  `Log_Id` text NOT NULL,
  `name` varchar(200) NOT NULL,
  `contactno` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `utype` varchar(200) NOT NULL,
  `design` varchar(200) NOT NULL,
  `addrs` text NOT NULL,
  `photo` text NOT NULL,
  `locatin` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ad_id`, `Log_Id`, `name`, `contactno`, `email`, `username`, `password`, `date`, `utype`, `design`, `addrs`, `photo`, `locatin`) VALUES
(1, 'AKL0021542786003', 'Administrator', '9847011216', 'admin@gmail.com', 'admin', 'admin', '2026-01-26', 'Administrator', 'E C', 'PALAKKAD', 'person-08-big.jpg', 'Palakkad');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `msg_id` int(11) NOT NULL,
  `Log_Id` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `age` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `cntno` varchar(200) NOT NULL,
  `subjct` varchar(200) NOT NULL,
  `descp` text NOT NULL,
  `date` varchar(200) NOT NULL,
  `reply` text NOT NULL,
  `rdate` varchar(200) NOT NULL,
  `tm` varchar(200) NOT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`msg_id`, `Log_Id`, `name`, `age`, `sex`, `cntno`, `subjct`, `descp`, `date`, `reply`, `rdate`, `tm`, `photo`) VALUES
(1, 'GYM76218228', 'Raj', '23', 'Male', '9797979797', 'sfsaf', 'sf', '09-03-2026', 'Pending', '', '11:14:00 AM', 'person-07-big.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_date` date NOT NULL,
  `method` varchar(50) DEFAULT 'Cash',
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `member_id`, `amount`, `paid_date`, `method`, `remarks`) VALUES
(1, 1, '2500.00', '2026-03-07', 'Cash', '2560'),
(2, 1, '4000.00', '2026-03-08', 'Cash', '2560');

-- --------------------------------------------------------

--
-- Table structure for table `gym_logs`
--

CREATE TABLE `gym_logs` (
  `ex_id` int(11) NOT NULL,
  `Log_Id` varchar(100) NOT NULL,
  `mem_name` varchar(100) NOT NULL,
  `exercise_name` varchar(100) NOT NULL,
  `exercise_count` varchar(50) DEFAULT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gym_logs`
--

INSERT INTO `gym_logs` (`ex_id`, `Log_Id`, `mem_name`, `exercise_name`, `exercise_count`, `log_date`, `log_time`, `created_at`) VALUES
(69, 'MEM11243528', 'rasi', 'pushups', '9', '2026-03-09', '13:18:50', '2026-03-09 08:08:01'),
(70, 'MEM11243528', 'rasi', 'squats', '6', '2026-03-09', '13:19:29', '2026-03-09 08:08:01'),
(72, 'MEM11243528', 'rasi', 'pushups', '9', '2026-03-09', '13:18:50', '2026-03-09 08:09:29'),
(73, 'MEM11243528', 'rasi', 'squats', '6', '2026-03-09', '13:19:29', '2026-03-09 08:09:29'),
(75, 'MEM11243528', 'rasi', 'pushups', '9', '2026-03-09', '13:18:50', '2026-03-09 08:09:37'),
(76, 'MEM11243528', 'rasi', 'squats', '6', '2026-03-09', '13:19:29', '2026-03-09 08:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `gym_logsa`
--

CREATE TABLE `gym_logsa` (
  `ex_id` int(11) NOT NULL,
  `Log_Id` varchar(100) NOT NULL,
  `mem_name` varchar(100) NOT NULL,
  `exercise_name` varchar(100) NOT NULL,
  `exercise_count` varchar(50) DEFAULT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `Log_Id` varchar(200) NOT NULL,
  `tname` varchar(100) NOT NULL,
  `age` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `addr` text DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL,
  `dist` varchar(50) DEFAULT NULL,
  `membership_plan` varchar(50) DEFAULT NULL,
  `cntno1` varchar(15) NOT NULL,
  `cntno2` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `jdate` date NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` date NOT NULL,
  `utype` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `Log_Id`, `tname`, `age`, `sex`, `blood_group`, `addr`, `stat`, `dist`, `membership_plan`, `cntno1`, `cntno2`, `email`, `photo`, `jdate`, `username`, `password`, `about`, `created_at`, `date`, `utype`) VALUES
(1, 'MEM11243528', 'rasi', '34', 'Female', 'a+', 'Palkad', 'Kerala', 'Palakkad', 'long', '1321242112', '1241241241', 'rasi@gmail.com', 'person-01-big.jpg', '2026-03-07', 'rasi143', 'rasi143', 'okey', '2026-03-07 15:23:00', '2026-03-07', 'Member'),
(4, 'MEM11243528', 'rasi', '23', 'Female', 'a+', 'Palkad', 'Kerala', 'Palakkad', 'long', '1321242112', '1241241241', 'rasi@gmail.com', 'person-01-big.jpg', '2026-03-07', 'rasi143', 'rasi143', 'okey', '2026-03-07 15:23:00', '2026-03-07', 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msg_id` int(11) NOT NULL,
  `tname` varchar(200) NOT NULL,
  `sname` varchar(200) NOT NULL,
  `subjt` varchar(200) NOT NULL,
  `desp` text NOT NULL,
  `photo` text NOT NULL,
  `file1` text NOT NULL,
  `date` varchar(200) NOT NULL,
  `tm` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_id`, `tname`, `sname`, `subjt`, `desp`, `photo`, `file1`, `date`, `tm`) VALUES
(1, 'rasi', 'Raj', 'ss', 'sss', 'person-07-big.jpg', 'background-03.jpg', '09-03-2026', '11:17:22 AM');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `not_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `subjct` varchar(200) NOT NULL,
  `descp` text NOT NULL,
  `date` date NOT NULL,
  `tme` text NOT NULL,
  `photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(200) NOT NULL,
  `salary_month` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_date` date NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`id`, `staff_id`, `salary_month`, `amount`, `paid_date`, `remarks`) VALUES
(1, 'GYM76218228', '2026-03', '40000.00', '2026-03-07', 'no'),
(2, 'GYM76218228', '2026-03', '25000.00', '2026-03-13', 'no'),
(3, 'GYM762182283', '2026-03', '25000.00', '2026-03-13', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `trainees`
--

CREATE TABLE `trainees` (
  `id` int(11) NOT NULL,
  `Log_Id` varchar(50) NOT NULL,
  `tname` varchar(100) NOT NULL,
  `age` varchar(200) NOT NULL,
  `sex` varchar(200) NOT NULL,
  `blood_group` varchar(20) DEFAULT NULL,
  `addr` text DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL,
  `dist` varchar(50) DEFAULT NULL,
  `trainer_name` varchar(100) DEFAULT NULL,
  `cntno1` varchar(15) NOT NULL,
  `cntno2` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `jdate` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `about` text DEFAULT NULL,
  `utype` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trainees`
--

INSERT INTO `trainees` (`id`, `Log_Id`, `tname`, `age`, `sex`, `blood_group`, `addr`, `stat`, `dist`, `trainer_name`, `cntno1`, `cntno2`, `email`, `photo`, `jdate`, `username`, `password`, `date`, `about`, `utype`) VALUES
(2, 'GYM76218228', 'Raj', '23', 'Male', 'A+', 'pALKKAD', 'Kerala', 'Palakkad', 'rAJ', '7979797973', '9797979797', 'RAJ@GMAIL.COM', 'person-07-big.jpg', '2026-03-21', 'raj123', 'raj123', '2026-03-07', 'okey', 'Trainee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_logs`
--
ALTER TABLE `gym_logs`
  ADD PRIMARY KEY (`ex_id`);

--
-- Indexes for table `gym_logsa`
--
ALTER TABLE `gym_logsa`
  ADD PRIMARY KEY (`ex_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`not_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainees`
--
ALTER TABLE `trainees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gym_logs`
--
ALTER TABLE `gym_logs`
  MODIFY `ex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `gym_logsa`
--
ALTER TABLE `gym_logsa`
  MODIFY `ex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trainees`
--
ALTER TABLE `trainees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
