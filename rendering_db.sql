-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2020 at 11:47 AM
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
(1, 'admin', '$2y$10$7oWMcUs3HcaQuEkntHIx6ONUUk9877Oq8uGTjc6xnsfYM8.bcbpsi');

-- --------------------------------------------------------

--
-- Table structure for table `department_tb`
--

CREATE TABLE IF NOT EXISTS `department_tb` (
  `department_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `department_tb`:
--

--
-- Truncate table before insert `department_tb`
--

TRUNCATE TABLE `department_tb`;
-- --------------------------------------------------------

--
-- Table structure for table `render_tb`
--

CREATE TABLE IF NOT EXISTS `render_tb` (
  `render_id` int(11) NOT NULL AUTO_INCREMENT,
  `trainee_id` int(11) NOT NULL,
  `rules_id` int(11) NOT NULL,
  `render_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`render_id`),
  KEY `trainee_id` (`trainee_id`),
  KEY `rules_id` (`rules_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `render_tb`:
--   `trainee_id`
--       `trainee_tb` -> `trainee_id`
--   `rules_id`
--       `rules_tb` -> `rule_id`
--

--
-- Truncate table before insert `render_tb`
--

TRUNCATE TABLE `render_tb`;
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
  `is_grounded` int(11) NOT NULL,
  `summaries` int(11) NOT NULL,
  `words` int(11) NOT NULL,
  `levitical_service` int(11) NOT NULL,
  PRIMARY KEY (`rule_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `rules_tb`:
--   `department_id`
--       `department_tb` -> `department_id`
--

--
-- Truncate table before insert `rules_tb`
--

TRUNCATE TABLE `rules_tb`;
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
-- Constraints for dumped tables
--

--
-- Constraints for table `render_tb`
--
ALTER TABLE `render_tb`
  ADD CONSTRAINT `render_tb_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainee_tb` (`trainee_id`),
  ADD CONSTRAINT `render_tb_ibfk_2` FOREIGN KEY (`rules_id`) REFERENCES `rules_tb` (`rule_id`);

--
-- Constraints for table `rules_tb`
--
ALTER TABLE `rules_tb`
  ADD CONSTRAINT `rules_tb_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_tb` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
