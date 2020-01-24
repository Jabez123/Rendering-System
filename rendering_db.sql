-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2020 at 02:39 PM
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

CREATE TABLE IF NOT EXISTS `admin_tb` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `admin_tb`:
--

--
-- Truncate table before insert `admin_tb`
--

TRUNCATE TABLE `admin_tb`;
--
-- Dumping data for table `admin_tb`
--

INSERT INTO `admin_tb` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$vJ5FqJHMog0iRHsON65Vse7a8c7C1SjKU4KYIMatOipTVfWPAQsOW');

-- --------------------------------------------------------

--
-- Table structure for table `department_tb`
--

CREATE TABLE IF NOT EXISTS `department_tb` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `hashed_password` varchar(100) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `department_tb`:
--

--
-- Truncate table before insert `department_tb`
--

TRUNCATE TABLE `department_tb`;
--
-- Dumping data for table `department_tb`
--

INSERT INTO `department_tb` (`department_id`, `username`, `password`, `hashed_password`, `department_name`) VALUES
(1, 'envi', 'qwer', '$2y$10$KNPdZOjie/KwHbxYKtFad.rx22KnqTBrL0.DMszupR3d6JQecqO/O', 'Environment'),
(2, 'reg', '1234', '$2y$10$vbIilQt9kRfGpRsmKbW8HOtVO4vDpat.XLKT9fQk811lDGr6F6hwq', 'Registration'),
(3, 'accom', '1234', '$2y$10$flypx3esj15YmGcVGUlULetHDPuEioHRj3fWxj3lSRxzv6dM7tD/C', 'Accommodation'),
(4, 'kit', '1234', '$2y$10$EebiKdRhSrdrYzqUaElw4u7bO/49zk0smtNjrMx3Bz0eoJho1xVNm', 'Kitchen');

-- --------------------------------------------------------

--
-- Table structure for table `render_tb`
--

CREATE TABLE IF NOT EXISTS `render_tb` (
  `render_id` int(11) NOT NULL AUTO_INCREMENT,
  `trainee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  `is_grounded` int(11) NOT NULL,
  `summaries` int(11) NOT NULL,
  `words` int(11) NOT NULL,
  `levitical_service` int(11) NOT NULL,
  `render_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`render_id`),
  KEY `department_id` (`department_id`),
  KEY `trainee_id` (`trainee_id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `render_tb`:
--   `department_id`
--       `department_tb` -> `department_id`
--   `rule_id`
--       `rules_tb` -> `rule_id`
--   `trainee_id`
--       `trainee_tb` -> `trainee_id`
--

--
-- Truncate table before insert `render_tb`
--

TRUNCATE TABLE `render_tb`;
--
-- Dumping data for table `render_tb`
--

INSERT INTO `render_tb` (`render_id`, `trainee_id`, `department_id`, `rule_id`, `is_grounded`, `summaries`, `words`, `levitical_service`, `render_date`) VALUES
(1, 660012, 3, 3, 0, 1, 125, 0, '2020-01-24 13:37:45'),
(2, 660012, 3, 3, 0, 1, 250, 0, '2020-01-24 13:38:01'),
(3, 660012, 3, 4, 0, 1, 375, 0, '2020-01-24 13:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `rules_tb`
--

CREATE TABLE IF NOT EXISTS `rules_tb` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `offense_code` varchar(50) NOT NULL,
  `offense_type` varchar(100) NOT NULL,
  `offense_description` varchar(500) NOT NULL,
  PRIMARY KEY (`rule_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `rules_tb`:
--   `department_id`
--       `department_tb` -> `department_id`
--

--
-- Truncate table before insert `rules_tb`
--

TRUNCATE TABLE `rules_tb`;
--
-- Dumping data for table `rules_tb`
--

INSERT INTO `rules_tb` (`rule_id`, `department_id`, `offense_code`, `offense_type`, `offense_description`) VALUES
(1, 3, 'A1', 'CONDUCT', 'Eating inside the quarters'),
(3, 3, 'A2', 'CONDUCT', 'Entering the quarters during the break, sessions and study time'),
(4, 3, 'A3', 'CONDUCT', 'Shouting inside the quarters');

-- --------------------------------------------------------

--
-- Table structure for table `trainee_tb`
--

CREATE TABLE IF NOT EXISTS `trainee_tb` (
  `trainee_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `id_name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `class` varchar(10) NOT NULL,
  `class_group` varchar(10) NOT NULL,
  `room` varchar(10) NOT NULL,
  `team` varchar(10) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`trainee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `trainee_tb`:
--

--
-- Truncate table before insert `trainee_tb`
--

TRUNCATE TABLE `trainee_tb`;
--
-- Dumping data for table `trainee_tb`
--

INSERT INTO `trainee_tb` (`trainee_id`, `first_name`, `last_name`, `id_name`, `gender`, `class`, `class_group`, `room`, `team`, `status`) VALUES
(64101, 'Neshama', 'Aba-a', 'Neshama', 'Sister', 'FT3', 'FT3A', '', '13', 'Active'),
(64102, 'Precil', 'Abalde', 'Precil', 'Sister', 'FT3', 'FT3B', '', '12', 'Active'),
(660012, 'Jabez', 'Bondoc', 'Jabez', 'Brother', 'FT1', 'FT1C', 'B3', '7', 'Active'),
(661001, 'Grace', 'Abalde', 'Grace', 'Sister', 'FT1', 'FT1A', '', '14', 'Active');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `render_tb`
--
ALTER TABLE `render_tb`
  ADD CONSTRAINT `render_tb_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_tb` (`department_id`),
  ADD CONSTRAINT `render_tb_ibfk_2` FOREIGN KEY (`rule_id`) REFERENCES `rules_tb` (`rule_id`),
  ADD CONSTRAINT `render_tb_ibfk_3` FOREIGN KEY (`trainee_id`) REFERENCES `trainee_tb` (`trainee_id`);

--
-- Constraints for table `rules_tb`
--
ALTER TABLE `rules_tb`
  ADD CONSTRAINT `rules_tb_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_tb` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
