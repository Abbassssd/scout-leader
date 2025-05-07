-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2025 at 04:26 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scout`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `father_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `mother_name` varchar(50) DEFAULT NULL,
  `mother_family_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `your_number` varchar(20) DEFAULT NULL,
  `mother_number` varchar(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `civil_number` varchar(50) DEFAULT NULL,
  `id_image` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` enum('YES','NO') DEFAULT 'YES',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type_of_account` enum('cubs','junior','youth','commander') NOT NULL DEFAULT 'cubs',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `civil_number` (`civil_number`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `father_name`, `last_name`, `mother_name`, `mother_family_name`, `email`, `your_number`, `mother_number`, `country`, `city`, `nationality`, `date_of_birth`, `civil_number`, `id_image`, `username`, `password`, `last_login`, `is_active`, `created_at`, `type_of_account`) VALUES
(1, 'abbass', 'hussein', 'fadel', 'hanan', 'nasser', 'abbass2014_fadel_nasser@hotmail.com', '76706181', '70721719', 'lebanon', 'beirut', 'lebanese', '2003-09-20', '168', 'ss', 'abs', 'abs123', '2025-05-02 14:17:18', 'YES', '2025-04-24 07:50:35', 'cubs'),
(2, 'hasan', 'dads', 'dassd', 'dada', 'dsada', '', 'dada', 'dada', 'dada', 'dad', 'dada', '2025-04-01', '1515', 'dasda', 'hasan', 'souna', '2025-04-24 15:36:31', 'YES', '2025-04-24 12:36:17', 'junior'),
(3, 'hasan', 'hisham', 'sweidan', 'amal', 'bederdin', 'abbass2014_fadel@hotmail.com', '76852585', '78525245', 'lebanon', 'beirut', 'lebanese', '2003-04-05', '1685', NULL, 'icy', 'Insane1200!', '2025-05-06 16:35:36', 'YES', '2025-05-06 13:33:46', 'youth'),
(4, 'commander', 'commander', 'commander', 'commander', 'commander', 'commander@hotmail.com', 'commander', 'commander', 'lebanon', 'beirut', 'lebanese', '2002-04-05', '16877', NULL, 'commander', 'commander@123', NULL, 'YES', '2025-05-06 16:11:43', 'commander');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `individual_id` int NOT NULL,
  `attend_date` date NOT NULL,
  `status` enum('present','absent') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `individual_id`, `attend_date`, `status`, `created_at`) VALUES
(1, 1, '2025-05-08', 'present', '2025-05-02 13:06:36'),
(2, 7, '2025-05-08', 'present', '2025-05-02 13:06:36'),
(6, 7, '2025-05-20', 'present', '2025-05-05 14:14:00'),
(5, 1, '2025-05-20', 'absent', '2025-05-05 14:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendance2`
--

DROP TABLE IF EXISTS `attendance2`;
CREATE TABLE IF NOT EXISTS `attendance2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `individual_id` int NOT NULL,
  `attend_date` date NOT NULL,
  `status` enum('present','absent') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance2`
--

INSERT INTO `attendance2` (`id`, `individual_id`, `attend_date`, `status`, `created_at`) VALUES
(1, 5, '2025-05-14', 'present', '2025-05-05 11:18:01'),
(2, 5, '2025-05-22', 'present', '2025-05-05 11:59:17'),
(11, 5, '2025-05-28', 'present', '2025-05-05 12:20:18'),
(12, 3, '2025-05-08', 'present', '2025-05-06 11:59:02'),
(13, 3, '2025-05-16', 'absent', '2025-05-06 12:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `attendance3`
--

DROP TABLE IF EXISTS `attendance3`;
CREATE TABLE IF NOT EXISTS `attendance3` (
  `id` int NOT NULL AUTO_INCREMENT,
  `individual_id` int NOT NULL,
  `attend_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance3`
--

INSERT INTO `attendance3` (`id`, `individual_id`, `attend_date`, `status`, `created_at`) VALUES
(1, 3, '2025-05-18', 'present', '2025-05-06 15:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `individual_id` int DEFAULT NULL,
  `task_id` int DEFAULT NULL,
  `grade` int DEFAULT NULL,
  `month` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `individual_id`, `task_id`, `grade`, `month`) VALUES
(17, 1, 10, 55, NULL),
(18, 7, 10, 55, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades2`
--

DROP TABLE IF EXISTS `grades2`;
CREATE TABLE IF NOT EXISTS `grades2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `individual_id` int NOT NULL,
  `task_id` int NOT NULL,
  `grade` int DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grades2`
--

INSERT INTO `grades2` (`id`, `individual_id`, `task_id`, `grade`, `month`) VALUES
(1, 5, 11, NULL, NULL),
(2, 5, 12, NULL, NULL),
(3, 5, 13, 20, NULL),
(4, 7, 13, NULL, NULL),
(5, 5, 14, 20, NULL),
(6, 7, 14, NULL, NULL),
(7, 5, 15, 20, NULL),
(8, 7, 15, NULL, NULL),
(9, 5, 16, 30, NULL),
(10, 7, 16, NULL, NULL),
(11, 5, 17, NULL, NULL),
(12, 7, 17, NULL, NULL),
(13, 5, 1, NULL, NULL),
(14, 7, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades3`
--

DROP TABLE IF EXISTS `grades3`;
CREATE TABLE IF NOT EXISTS `grades3` (
  `id` int NOT NULL AUTO_INCREMENT,
  `individual_id` int NOT NULL,
  `task_id` int NOT NULL,
  `grade` int DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `individual`
--

DROP TABLE IF EXISTS `individual`;
CREATE TABLE IF NOT EXISTS `individual` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `father_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `mother_name` varchar(50) DEFAULT NULL,
  `mother_family_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `your_number` varchar(20) DEFAULT NULL,
  `mother_number` varchar(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `civil_number` varchar(50) DEFAULT NULL,
  `id_image` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `is_active` enum('YES','NO') DEFAULT 'YES',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `individual`
--

INSERT INTO `individual` (`id`, `first_name`, `father_name`, `last_name`, `mother_name`, `mother_family_name`, `email`, `your_number`, `mother_number`, `country`, `city`, `nationality`, `date_of_birth`, `civil_number`, `id_image`, `username`, `password`, `created_at`, `last_login`, `is_active`) VALUES
(1, 'abbass', 'hussein', 'fadel', 'hanan', 'nasser', 'abbass2014_fadel_nasser@hotmail.com', '76706181', '70721719', 'Lebanon', 'beirut', 'Lebanese', '2017-04-12', '168', '11221', 'user1', 'Insane1200!', '2025-04-24 08:58:26', '2025-05-06 14:17:11', 'YES'),
(2, 'abbass', 'hussein', 'fadel', 'hanan', 'nasser', 'user12@hotmail.com', '76706181', '70721719', 'Lebanon', 'beirut', 'Iraqi', '0000-00-00', '16855', '11221', 'user123', 'Abbson123@', '2025-04-24 10:35:36', NULL, 'YES'),
(3, 'abbass', 'hussein', 'fadel', 'hanan', 'nasser', 'asddsa@hotmail.com', '76706181', '70721719', 'Lebanon', 'beirut', 'Lebanese', '2008-05-10', '168', '11221', 'user122222222222222222', 'Abbson123@', '2025-04-24 10:51:07', '2025-05-06 14:57:19', 'YES'),
(5, 'abbassws', 'husseinfsfs', 'fadeldad', 'hananfsdf', 'nasser', 'asddfdsfdsa@hotmail.com', '76706181', '70821719', 'Lebanon', 'beirut', 'Syrian', '2013-05-15', '168', '11221', 'user12', 'Insane1200!', '2025-04-27 14:23:21', '2025-05-06 12:15:30', 'YES'),
(6, '[value-2]', '[value-3]', '[value-4]', '[value-5]', '[value-6]', '[value-7]', '[value-8]', '[value-9]', '[value-10]', '[value-11]', '[value-12]', '0000-00-00', '[value-14]', '[value-15]', '[value-16]', '[value-17]', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(7, 'mhmd', 'hkmat ', 'ayoub  ', 'mlak', 'moobarak', 'mhmd@1213.com', '81652480', '03146516', 'Lebanon', 'altybeh', 'Palestinian', '2014-01-13', '170', '11221', 'user1222', 'Insane120dddddd0!', '2025-04-27 20:27:19', '2025-05-05 15:36:52', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'abbass fadel', 'das ddandlnqjdndjfnf', '1745784804_d-16.jpg', '2025-04-27 20:13:24'),
(2, 'ddabdadajfakd', 'afdbsfnvsjhdahajvdhuf', '1745784839_wosm_0.jpg', '2025-04-27 20:13:59'),
(3, 'adafdafffsf', 'fsfsfsffsfd', '1745785890_photo_2025-04-21_22-03-00.jpg', '2025-04-27 20:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `news2`
--

DROP TABLE IF EXISTS `news2`;
CREATE TABLE IF NOT EXISTS `news2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news2`
--

INSERT INTO `news2` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'INT', 'abbass akal pizza', '1746444129_d-16.jpg', '2025-05-05 14:22:09'),
(2, 'first news ', 'dadadada', '1746532438_234419Image1.jpg', '2025-05-06 14:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `news3`
--

DROP TABLE IF EXISTS `news3`;
CREATE TABLE IF NOT EXISTS `news3` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news3`
--

INSERT INTO `news3` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'first news test', 'test my first news ', '1746532472_234419Image1.jpg', '2025-05-06 14:54:32'),
(2, 'first news test', 'test my first news ', '1746532536_234419Image1.jpg', '2025-05-06 14:55:36'),
(3, 'first news ', 'dadadada', '1746532568_234419Image1.jpg', '2025-05-06 14:56:08'),
(4, 'first news ', 'dadadada', '1746532731_234419Image1.jpg', '2025-05-06 14:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `requesttochangepass`
--

DROP TABLE IF EXISTS `requesttochangepass`;
CREATE TABLE IF NOT EXISTS `requesttochangepass` (
  `id` int NOT NULL AUTO_INCREMENT,
  `source_table` enum('individual','admins') DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_info` text,
  `request_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requesttochangepass`
--

INSERT INTO `requesttochangepass` (`id`, `source_table`, `username`, `email`, `password`, `full_info`, `request_time`) VALUES
(1, 'individual', 'user1', 'abbass2014_fadel_nasser@hotmail.com', 'Insane1200!', '{\"id\":1,\"first_name\":\"abbass\",\"father_name\":\"hussein\",\"last_name\":\"fadel\",\"mother_name\":\"hanan\",\"mother_family_name\":\"nasser\",\"email\":\"abbass2014_fadel_nasser@hotmail.com\",\"your_number\":\"76706181\",\"mother_number\":\"70721719\",\"country\":\"Lebanon\",\"city\":\"beirut\",\"nationality\":\"Lebanese\",\"date_of_birth\":\"2025-04-01\",\"civil_number\":\"168\",\"id_image\":\"11221\",\"username\":\"user1\",\"password\":\"Insane1200!\",\"created_at\":\"2025-04-24 11:58:26\",\"last_login\":null,\"is_active\":\"NO\"}', '2025-04-24 09:55:01'),
(2, 'individual', 'user1', 'abbass2014_fadel_nasser@hotmail.com', 'Insane1200!', '{\"id\":1,\"first_name\":\"abbass\",\"father_name\":\"hussein\",\"last_name\":\"fadel\",\"mother_name\":\"hanan\",\"mother_family_name\":\"nasser\",\"email\":\"abbass2014_fadel_nasser@hotmail.com\",\"your_number\":\"76706181\",\"mother_number\":\"70721719\",\"country\":\"Lebanon\",\"city\":\"beirut\",\"nationality\":\"Lebanese\",\"date_of_birth\":\"2025-04-01\",\"civil_number\":\"168\",\"id_image\":\"11221\",\"username\":\"user1\",\"password\":\"Insane1200!\",\"created_at\":\"2025-04-24 11:58:26\",\"last_login\":null,\"is_active\":\"NO\"}', '2025-04-24 09:55:12'),
(3, 'admins', 'abs', 'abbass2014_fadel_nasser@hotmail.com', 'abs123', '{\"id\":1,\"first_name\":\"abbass\",\"father_name\":\"hussein\",\"last_name\":\"fadel\",\"mother_name\":\"hanan\",\"mother_family_name\":\"nasser\",\"email\":\"abbass2014_fadel_nasser@hotmail.com\",\"your_number\":\"76706181\",\"mother_number\":\"70721719\",\"country\":\"lebanon\",\"city\":\"beirut\",\"nationality\":\"lebanese\",\"date_of_birth\":\"2003-09-20\",\"civil_number\":\"168\",\"id_image\":\"ss\",\"username\":\"abs\",\"password\":\"abs123\",\"last_login\":\"2025-04-24 11:19:52\",\"is_active\":\"YES\",\"created_at\":\"2025-04-24 10:50:35\"}', '2025-04-24 10:22:36'),
(4, 'individual', 'user1', 'abbass2014_fadel_nasser@hotmail.com', 'Insane1200!', '{\"id\":1,\"first_name\":\"abbass\",\"father_name\":\"hussein\",\"last_name\":\"fadel\",\"mother_name\":\"hanan\",\"mother_family_name\":\"nasser\",\"email\":\"abbass2014_fadel_nasser@hotmail.com\",\"your_number\":\"76706181\",\"mother_number\":\"70721719\",\"country\":\"Lebanon\",\"city\":\"beirut\",\"nationality\":\"Lebanese\",\"date_of_birth\":\"2017-04-12\",\"civil_number\":\"168\",\"id_image\":\"11221\",\"username\":\"user1\",\"password\":\"Insane1200!\",\"created_at\":\"2025-04-24 11:58:26\",\"last_login\":\"2025-04-27 16:56:39\",\"is_active\":\"YES\"}', '2025-04-27 14:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note` varchar(255) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `leader_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `note`, `schedule_date`, `leader_role`) VALUES
(1, 'daddad', '2025-05-20', ''),
(2, 'dla dmmabffbsnfnvfnvfnvfvg', '2025-05-15', ''),
(3, 'dla dmmabffbsnfnvfnvfnvfvg', '2025-05-15', ''),
(4, 'dla dmmabffbsnfnvfnvfnvfvg', '2025-05-15', ''),
(5, 'dla dmmabffbsnfnvfnvfnvfvg', '2025-05-15', ''),
(6, 'dla dmmabffbsnfnvfnvfnvfvg', '2025-05-15', ''),
(7, 'dla dmmabffbsnfnvfnvfnvfvg', '2025-05-15', ''),
(8, 'dasdad', '2025-05-07', ''),
(9, 'dasdad', '2025-05-07', ''),
(10, 'dadfs', '2025-05-24', ''),
(11, 'dadfs', '2025-05-24', ''),
(12, 'dadfs', '2025-05-24', ''),
(13, 'sdadda', '2025-05-03', ''),
(14, 'sdadda', '2025-05-03', '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule2`
--

DROP TABLE IF EXISTS `schedule2`;
CREATE TABLE IF NOT EXISTS `schedule2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note` varchar(255) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `leader_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedule2`
--

INSERT INTO `schedule2` (`id`, `note`, `schedule_date`, `leader_role`) VALUES
(1, 'abbass ma tensa tekol', '2025-05-17', '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule3`
--

DROP TABLE IF EXISTS `schedule3`;
CREATE TABLE IF NOT EXISTS `schedule3` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note` varchar(255) NOT NULL,
  `schedule_date` date NOT NULL,
  `leader_role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `deadline` date DEFAULT NULL,
  `leader_id` int DEFAULT NULL,
  `target_group` enum('cubs','juniors','youth') NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_path` varchar(255) DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `grade_over` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `deadline`, `leader_id`, `target_group`, `image`, `created_at`, `image_path`, `video_link`, `duration_minutes`, `grade_over`) VALUES
(1, 'abbass', 'ss', '2025-05-02', 1, 'cubs', NULL, '2025-04-27 13:41:12', NULL, NULL, NULL, NULL),
(2, 'abbass', ' xz z', '2025-04-03', 7, 'cubs', '1745841759_d-16.jpg', '2025-04-28 12:02:39', NULL, 'https://youtu.be/5IeErzmyfT8?si=ZnlZv5ZaUXUsNHmp', 2, NULL),
(3, 'abbass', ' xz z', '2025-04-03', 7, 'cubs', '1745841769_d-16.jpg', '2025-04-28 12:02:49', NULL, 'https://youtu.be/5IeErzmyfT8?si=ZnlZv5ZaUXUsNHmp', 2, NULL),
(4, 'abbass', ' xz z', '2025-04-03', 7, 'cubs', '1745843636_d-16.jpg', '2025-04-28 12:33:56', NULL, 'https://youtu.be/5IeErzmyfT8?si=ZnlZv5ZaUXUsNHmp', 2, NULL),
(5, 'abbass', ' xz z', '2025-04-03', 7, 'cubs', '1745844202_d-16.jpg', '2025-04-28 12:43:22', NULL, 'https://youtu.be/5IeErzmyfT8?si=ZnlZv5ZaUXUsNHmp', 2, NULL),
(6, 'abbass', 'ssd', '2025-04-21', 7, 'cubs', '', '2025-04-28 12:51:21', NULL, 'https://youtu.be/5IeErzmyfT8?si=ZnlZv5ZaUXUsNHmp', 2, NULL),
(7, 'hasas', 'dasdsadaddaasd', '2025-05-02', 7, 'cubs', '', '2025-04-30 08:19:41', NULL, '', 0, 10),
(8, 'hasas', 'dasdsadaddaasd', '2025-05-02', 7, 'cubs', '', '2025-04-30 08:20:57', NULL, '', 0, 10),
(9, 'edited 12222', 'sada', '2025-04-08', 7, 'cubs', '', '2025-04-30 08:25:31', NULL, 'https://youtu.be/5IeErzmyfT8?si=ZnlZv5ZaUXUsNHmp', 2, 10),
(10, 'eatedit22', '222', '2025-05-08', 7, 'cubs', '', '2025-05-05 14:24:02', NULL, '', 8, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tasks2`
--

DROP TABLE IF EXISTS `tasks2`;
CREATE TABLE IF NOT EXISTS `tasks2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `deadline` date NOT NULL,
  `leader_id` int DEFAULT NULL,
  `target_group` enum('cubs','juniors','youth') NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_path` varchar(255) DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `grade_over` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks2`
--

INSERT INTO `tasks2` (`id`, `title`, `description`, `deadline`, `leader_id`, `target_group`, `image`, `created_at`, `image_path`, `video_link`, `duration_minutes`, `grade_over`) VALUES
(1, 'eat', 'sad', '2025-05-08', 5, 'cubs', '1746444182_234419Image1.jpg', '2025-05-05 11:23:02', NULL, '', 8, 20),
(2, 'eat', 'sad', '2025-05-08', 5, 'cubs', '1746444505_234419Image1.jpg', '2025-05-05 11:28:25', NULL, '', 8, 20),
(3, 'eat', 'sad', '2025-05-08', 5, 'cubs', '1746444510_234419Image1.jpg', '2025-05-05 11:28:30', NULL, '', 8, 20),
(4, 'eatsd', 'dsdad', '2025-05-08', 7, 'cubs', '', '2025-05-05 11:39:35', NULL, '', 8, 20),
(5, 'eatsd', 'dsdad', '2025-05-08', 7, 'cubs', '', '2025-05-05 11:39:39', NULL, '', 8, 20),
(6, 'ssss', 'ss', '2025-05-14', 7, 'cubs', '', '2025-05-05 11:41:38', NULL, '', 0, 20),
(7, 'ssss', 'ss', '2025-05-14', 7, 'cubs', '', '2025-05-05 11:42:14', NULL, '', 0, 20),
(8, 'ssss', 'ss', '2025-05-14', 7, 'cubs', '', '2025-05-05 11:42:17', NULL, '', 0, 20),
(9, 'edited 122222222222222222222222222222', 'sada', '2025-04-08', 7, '', '', '2025-05-05 11:48:42', NULL, 'https://youtu.be/5IeErzmyfT8?si=ZnlZv5ZaUXUsNHmp', 2, 10),
(10, 'eatedit', 'dsdad', '2025-05-08', 7, '', '', '2025-05-05 11:49:00', NULL, '', 8, 20),
(11, 'test1 ', 'test1 for grades ', '2025-05-10', 5, 'cubs', '', '2025-05-05 14:26:30', NULL, '', 20, 20),
(12, 'test1 ', 'test1 for grades ', '2025-05-10', 5, 'cubs', '', '2025-05-05 14:26:44', NULL, '', 20, 20),
(13, 'test1 ', 'xsaxa', '2025-05-10', 5, 'cubs', '', '2025-05-06 09:27:54', NULL, '', 20, 20),
(14, 'test1 ', 'xsaxa', '2025-05-10', 5, 'cubs', '', '2025-05-06 09:28:00', NULL, '', 20, 20),
(15, 'test1 ', 'xsaxa', '2025-05-10', 5, 'cubs', '', '2025-05-06 09:33:58', NULL, '', 20, 20),
(16, 'test1 ', 'xsaxa', '2025-05-10', 5, 'cubs', '', '2025-05-06 09:34:35', NULL, '', 20, 20),
(17, 'test12', 'first test', '2025-05-10', 1, 'cubs', '', '2025-05-06 11:51:59', NULL, '', 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tasks3`
--

DROP TABLE IF EXISTS `tasks3`;
CREATE TABLE IF NOT EXISTS `tasks3` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `deadline` date DEFAULT NULL,
  `leader_id` int DEFAULT NULL,
  `target_group` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `video_link` text,
  `duration_minutes` int DEFAULT NULL,
  `grade_over` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks3`
--

INSERT INTO `tasks3` (`id`, `title`, `description`, `deadline`, `leader_id`, `target_group`, `image`, `image_path`, `video_link`, `duration_minutes`, `grade_over`, `created_at`) VALUES
(1, 'first test ', 'test1', '2025-05-21', 1, 'cubs', '', NULL, '', 20, 50, '2025-05-06 14:53:34');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
