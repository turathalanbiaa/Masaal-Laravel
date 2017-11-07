-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2017 at 08:30 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `masaal`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `content`, `time`, `active`) VALUES
(1, 'testing annoucement', '2017-11-06 00:00:00', 1),
(2, 'testing annoucement', '2017-11-06 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `lang` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `lang` varchar(2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
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
  `adminId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `content`, `time`, `userId`, `type`, `categoryId`, `lang`, `status`, `answer`, `image`, `videoLink`, `externalLink`, `adminId`) VALUES
(6, 'Testing_Question', '2017-11-06 08:41:35', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
(7, 'Testing_Question', '2017-11-06 08:41:37', 1, 1, NULL, 'en', 0, NULL, NULL, NULL, NULL, NULL),
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

CREATE TABLE `question_tag` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `deviceType` tinyint(4) NOT NULL COMMENT 'ios,android',
  `deviceUUID` varchar(255) NOT NULL,
  `firebaseToken` varchar(1024) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registrationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `deviceType`, `deviceUUID`, `firebaseToken`, `username`, `password`, `email`, `registrationDate`) VALUES
(1, 'testing_user', 1, 'DD', NULL, '', '', '', '2017-11-06 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_tag`
--
ALTER TABLE `question_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `question_tag`
--
ALTER TABLE `question_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
