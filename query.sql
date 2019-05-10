-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 10, 2019 at 12:58 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `vyndue03_msgr`
--
CREATE DATABASE IF NOT EXISTS `vyndue03_msgr` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `vyndue03_msgr`;

-- --------------------------------------------------------

--
-- Table structure for table `admingroup`
--

DROP TABLE IF EXISTS `admingroup`;
CREATE TABLE `admingroup` (
  `id` int(10) UNSIGNED NOT NULL,
  `adminType` int(11) DEFAULT NULL,
  `adminInfo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `admingroup`
--

TRUNCATE TABLE `admingroup`;
--
-- Dumping data for table `admingroup`
--

INSERT INTO `admingroup` (`id`, `adminType`, `adminInfo`) VALUES
(1, 0, 'superUser'),
(2, 1, 'subUser'),
(3, 2, 'supersuperUser');

-- --------------------------------------------------------

--
-- Table structure for table `admintype`
--

DROP TABLE IF EXISTS `admintype`;
CREATE TABLE `admintype` (
  `id` int(10) UNSIGNED NOT NULL,
  `adminId` int(11) DEFAULT NULL,
  `adminType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `admintype`
--

TRUNCATE TABLE `admintype`;
--
-- Dumping data for table `admintype`
--

INSERT INTO `admintype` (`id`, `adminId`, `adminType`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `admin_contactinfo`
--

DROP TABLE IF EXISTS `admin_contactinfo`;
CREATE TABLE `admin_contactinfo` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `admin_contactinfo`
--

TRUNCATE TABLE `admin_contactinfo`;
-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

DROP TABLE IF EXISTS `friend_list`;
CREATE TABLE `friend_list` (
  `userId` bigint(11) UNSIGNED DEFAULT NULL,
  `friendId` bigint(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `friend_list`
--

TRUNCATE TABLE `friend_list`;
-- --------------------------------------------------------

--
-- Table structure for table `im_blocklist`
--

DROP TABLE IF EXISTS `im_blocklist`;
CREATE TABLE `im_blocklist` (
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `g_id` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `im_blocklist`
--

TRUNCATE TABLE `im_blocklist`;
-- --------------------------------------------------------

--
-- Table structure for table `im_group`
--

DROP TABLE IF EXISTS `im_group`;
CREATE TABLE `im_group` (
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `createdBy` bigint(11) UNSIGNED DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '1=personal,0=group',
  `block` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'unblock=0,block=1',
  `lastActive` varchar(100) DEFAULT NULL,
  `custom_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `im_group`
--

TRUNCATE TABLE `im_group`;
--
-- Dumping data for table `im_group`
--

INSERT INTO `im_group` (`g_id`, `name`, `createdBy`, `type`, `block`, `lastActive`, `custom_image`) VALUES
(1, 'Arbitrage Public Community', 2, 0, 0, '2019-05-10T10:25:25.631+0000', '05102019105210imfEypb1.png');

-- --------------------------------------------------------

--
-- Table structure for table `im_group_members`
--

DROP TABLE IF EXISTS `im_group_members`;
CREATE TABLE `im_group_members` (
  `g_id` bigint(11) UNSIGNED DEFAULT NULL,
  `u_id` bigint(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `im_group_members`
--

TRUNCATE TABLE `im_group_members`;
--
-- Dumping data for table `im_group_members`
--

INSERT INTO `im_group_members` (`g_id`, `u_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `im_message`
--

DROP TABLE IF EXISTS `im_message`;
CREATE TABLE `im_message` (
  `m_id` bigint(11) UNSIGNED NOT NULL,
  `sender` bigint(11) UNSIGNED DEFAULT NULL,
  `receiver` bigint(11) UNSIGNED DEFAULT NULL,
  `message` longtext,
  `onlyemoji` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'check string contains only emoji',
  `type` varchar(20) DEFAULT NULL COMMENT 'audio,video,image,document',
  `fileName` longtext COMMENT 'real file Name for audio,video,image,document',
  `link` varchar(500) DEFAULT NULL,
  `linkData` longtext,
  `receiver_type` varchar(255) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `date_time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `im_message`
--

TRUNCATE TABLE `im_message`;
-- --------------------------------------------------------

--
-- Table structure for table `im_mutelist`
--

DROP TABLE IF EXISTS `im_mutelist`;
CREATE TABLE `im_mutelist` (
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `g_id` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `im_mutelist`
--

TRUNCATE TABLE `im_mutelist`;
-- --------------------------------------------------------

--
-- Table structure for table `im_receiver`
--

DROP TABLE IF EXISTS `im_receiver`;
CREATE TABLE `im_receiver` (
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `m_id` bigint(11) UNSIGNED NOT NULL,
  `r_id` bigint(11) UNSIGNED NOT NULL,
  `received` int(1) NOT NULL,
  `announced` int(1) NOT NULL DEFAULT '0',
  `time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `im_receiver`
--

TRUNCATE TABLE `im_receiver`;
-- --------------------------------------------------------

--
-- Table structure for table `im_usersessions`
--

DROP TABLE IF EXISTS `im_usersessions`;
CREATE TABLE `im_usersessions` (
  `u_id` bigint(11) NOT NULL,
  `token` longtext NOT NULL,
  `socketId` longtext NOT NULL,
  `lastActiveTime` varchar(100) DEFAULT NULL,
  `validity` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `im_usersessions`
--

TRUNCATE TABLE `im_usersessions`;
--
-- Dumping data for table `im_usersessions`
--

INSERT INTO `im_usersessions` (`u_id`, `token`, `socketId`, `lastActiveTime`, `validity`) VALUES
(2, 'urKqHq9uoWiEhaJBjoAtW3YND7tPgpfWykbVqEQdnkMzwNYpzHrAYArartde', 'VpejAaO53K3JPOngAABp', '2019-05-10T10:54:42.459+0000', '2019-05-15T10:55:27.672+0000');

-- --------------------------------------------------------

--
-- Table structure for table `im_usersocket`
--

DROP TABLE IF EXISTS `im_usersocket`;
CREATE TABLE `im_usersocket` (
  `userId` bigint(11) UNSIGNED NOT NULL,
  `socketId` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `im_usersocket`
--

TRUNCATE TABLE `im_usersocket`;
--
-- Dumping data for table `im_usersocket`
--

INSERT INTO `im_usersocket` (`userId`, `socketId`) VALUES
(2, 'VpejAaO53K3JPOngAABp');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `migrations`
--

TRUNCATE TABLE `migrations`;
--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userId` bigint(11) UNSIGNED NOT NULL,
  `userSecret` varchar(255) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userMobile` varchar(30) DEFAULT NULL,
  `userDateOfBirth` timestamp NULL DEFAULT NULL,
  `userGender` varchar(15) DEFAULT NULL,
  `userStatus` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=inactive,1=active',
  `userVerification` int(11) DEFAULT NULL,
  `userAddress` varchar(255) DEFAULT NULL,
  `userProfilePicture` varchar(255) DEFAULT NULL,
  `userResetToken` varchar(255) DEFAULT NULL,
  `userType` int(11) NOT NULL,
  `lastModified` varchar(100) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userSecret`, `firstName`, `lastName`, `userEmail`, `userPassword`, `userMobile`, `userDateOfBirth`, `userGender`, `userStatus`, `active`, `userVerification`, `userAddress`, `userProfilePicture`, `userResetToken`, `userType`, `lastModified`) VALUES
(1, 'OpMuUlPy7Z', 'Arbitrage', 'Admininistrator', 'arbitrage@email.com', '$2y$10$VvPprLmMbfplQHCAiMiiluNUVHLk1DoN7deghMoX9cDvbEFaS2zPe', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 0, '2019-05-10 7:28:59'),
(2, 'Ncoi35f9k4', 'Arbitrage', 'Admininistrator', 'admin@email.com', '$2y$10$VsTBWYP0ylgNPcdAwqg4UunoTjF/hqrY2eW/dlKAsEW/T9Kj81fQa', NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, 1, '2019-05-10 10:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `type` int(2) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `users_roles`
--

TRUNCATE TABLE `users_roles`;
--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`type`, `role`) VALUES
(0, 'ROLE_ADMIN'),
(1, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Table structure for table `user_device`
--

DROP TABLE IF EXISTS `user_device`;
CREATE TABLE `user_device` (
  `userId` bigint(11) UNSIGNED NOT NULL,
  `deviceId` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `user_device`
--

TRUNCATE TABLE `user_device`;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `admingroup`
--
ALTER TABLE `admingroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admintype`
--
ALTER TABLE `admintype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_contactinfo`
--
ALTER TABLE `admin_contactinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `im_group`
--
ALTER TABLE `im_group`
  ADD PRIMARY KEY (`g_id`),
  ADD KEY `createdBy` (`createdBy`);

--
-- Indexes for table `im_message`
--
ALTER TABLE `im_message`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admingroup`
--
ALTER TABLE `admingroup`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admintype`
--
ALTER TABLE `admintype`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_contactinfo`
--
ALTER TABLE `admin_contactinfo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `im_group`
--
ALTER TABLE `im_group`
  MODIFY `g_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `im_message`
--
ALTER TABLE `im_message`
  MODIFY `m_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
