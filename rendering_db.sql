-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2020 at 05:40 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rendering_db`
--
CREATE DATABASE IF NOT EXISTS `rendering_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rendering_db`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_tb`
--

CREATE TABLE `admin_tb` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `admin_tb`
--

TRUNCATE TABLE `admin_tb`;
-- --------------------------------------------------------

--
-- Table structure for table `in_charge_tb`
--

CREATE TABLE `in_charge_tb` (
  `in_charge_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `in_charge_tb`
--

TRUNCATE TABLE `in_charge_tb`;
--
-- Dumping data for table `in_charge_tb`
--

INSERT INTO `in_charge_tb` (`in_charge_id`, `password`, `department`) VALUES
(1, '12345', 'sample'),
(2, '12345', 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `render_tb`
--

CREATE TABLE `render_tb` (
  `render_id` int(11) NOT NULL,
  `trainee_id` int(11) NOT NULL,
  `render_code` varchar(5) NOT NULL,
  `summary` int(11) NOT NULL,
  `levitical` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `render_tb`
--

TRUNCATE TABLE `render_tb`;
--
-- Dumping data for table `render_tb`
--

INSERT INTO `render_tb` (`render_id`, `trainee_id`, `render_code`, `summary`, `levitical`) VALUES
(1, 2, 'B1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `trainee_tb`
--

CREATE TABLE `trainee_tb` (
  `trainee_id` int(11) NOT NULL,
  `in_charge_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `trainee_tb`
--

TRUNCATE TABLE `trainee_tb`;
--
-- Dumping data for table `trainee_tb`
--

INSERT INTO `trainee_tb` (`trainee_id`, `in_charge_id`, `first_name`, `last_name`) VALUES
(1, 1, 'Sample first name', 'Sample last name'),
(2, 1, 'Sample 1 name', 'Sample 1 last');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tb`
--
ALTER TABLE `admin_tb`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `in_charge_tb`
--
ALTER TABLE `in_charge_tb`
  ADD PRIMARY KEY (`in_charge_id`);

--
-- Indexes for table `render_tb`
--
ALTER TABLE `render_tb`
  ADD PRIMARY KEY (`render_id`),
  ADD KEY `trainee_id` (`trainee_id`);

--
-- Indexes for table `trainee_tb`
--
ALTER TABLE `trainee_tb`
  ADD PRIMARY KEY (`trainee_id`),
  ADD KEY `in_charge_id` (`in_charge_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tb`
--
ALTER TABLE `admin_tb`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `in_charge_tb`
--
ALTER TABLE `in_charge_tb`
  MODIFY `in_charge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `render_tb`
--
ALTER TABLE `render_tb`
  MODIFY `render_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trainee_tb`
--
ALTER TABLE `trainee_tb`
  MODIFY `trainee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `render_tb`
--
ALTER TABLE `render_tb`
  ADD CONSTRAINT `render_tb_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainee_tb` (`trainee_id`);

--
-- Constraints for table `trainee_tb`
--
ALTER TABLE `trainee_tb`
  ADD CONSTRAINT `trainee_tb_ibfk_1` FOREIGN KEY (`in_charge_id`) REFERENCES `in_charge_tb` (`in_charge_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
