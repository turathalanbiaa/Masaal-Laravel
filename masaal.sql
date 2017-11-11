-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 11, 2017 at 08:36 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `masaal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `lang` varchar(256) NOT NULL,
  `date` date NOT NULL,
  `manager` int(11) NOT NULL,
  `reviewer` int(11) NOT NULL,
  `distributor` int(11) NOT NULL,
  `respondent` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `announcement` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
CREATE TABLE IF NOT EXISTS `announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `active` tinyint(4) NOT NULL,
  `type` int(11) NOT NULL,
  `lang` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `content`, `time`, `active`, `type`, `lang`) VALUES
(1, 'testing annoucement', '2017-11-06 00:00:00', 1, 1, 'ar'),
(2, 'testing annoucement', '2017-11-06 00:00:00', 1, 1, 'ar');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `lang` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `lang` varchar(2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'فقهي او عقائدي',
  `categoryId` int(11) DEFAULT NULL COMMENT 'توحيد او صلاة او صوم او ...',
  `lang` varchar(2) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT 'NO_ANSWER,TEMP_ANSWER,APPROVED',
  `answer` text,
  `image` varchar(255) DEFAULT NULL,
  `videoLink` varchar(255) DEFAULT NULL,
  `externalLink` varchar(255) DEFAULT NULL,
  `adminId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `content`, `time`, `userId`, `type`, `categoryId`, `lang`, `status`, `answer`, `image`, `videoLink`, `externalLink`, `adminId`) VALUES
(6, 'Testing_Question', '2017-11-06 08:41:35', 1, 1, NULL, 'en', 2, NULL, NULL, NULL, NULL, NULL),
(7, 'Testing_Question', '2017-11-06 08:41:37', 1, 1, NULL, 'en', 2, NULL, NULL, NULL, NULL, NULL),
(8, 'Testing_Question', '2017-11-06 08:41:39', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(9, 'Testing_Question', '2017-11-06 08:41:41', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(10, 'Testing_Question', '2017-11-06 08:41:43', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(11, 'Testing_Question', '2017-11-06 08:41:44', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(12, 'Testing_Question', '2017-11-06 08:41:46', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(13, 'Testing_Question', '2017-11-06 08:41:48', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(14, 'Testing_Question', '2017-11-06 08:41:50', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(15, 'Testing_Question', '2017-11-06 08:41:52', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(16, 'Testing_Question', '2017-11-06 08:41:53', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(17, 'Testing_Question', '2017-11-06 08:41:54', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(18, 'Testing_Question', '2017-11-06 08:41:56', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(19, 'Testing_Question', '2017-11-06 08:41:58', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(20, 'Testing_Question', '2017-11-06 08:42:00', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(21, 'Testing_Question', '2017-11-06 08:45:29', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(22, 'Testing_Question', '2017-11-06 08:45:31', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question_tag`
--

DROP TABLE IF EXISTS `question_tag`;
CREATE TABLE IF NOT EXISTS `question_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `deviceType` tinyint(4) NOT NULL COMMENT 'ios,android',
  `deviceUUID` varchar(255) NOT NULL,
  `firebaseToken` varchar(1024) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registrationDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `deviceType`, `deviceUUID`, `firebaseToken`, `username`, `password`, `email`, `registrationDate`) VALUES
(1, 'testing_user', 1, 'DD', NULL, '', '', '', '2017-11-06 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
