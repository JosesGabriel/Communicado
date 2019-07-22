-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 22, 2019 at 02:25 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `vyndue03_msgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `admingroup`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `admingroup` (
  `id` int(10) UNSIGNED NOT NULL,
  `adminType` int(11) DEFAULT NULL,
  `adminInfo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `admingroup`:
--

--
-- Dumping data for table `admingroup`
--

INSERT IGNORE INTO `admingroup` (`id`, `adminType`, `adminInfo`) VALUES
(1, 0, 'superUser'),
(2, 1, 'subUser'),
(3, 2, 'supersuperUser');

-- --------------------------------------------------------

--
-- Table structure for table `admintype`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `admintype` (
  `id` int(10) UNSIGNED NOT NULL,
  `adminId` int(11) DEFAULT NULL,
  `adminType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `admintype`:
--

--
-- Dumping data for table `admintype`
--

INSERT IGNORE INTO `admintype` (`id`, `adminId`, `adminType`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `admin_contactinfo`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `admin_contactinfo` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `admin_contactinfo`:
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `friend_list` (
  `userId` bigint(11) UNSIGNED DEFAULT NULL,
  `friendId` bigint(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `friend_list`:
--

--
-- Dumping data for table `friend_list`
--

INSERT IGNORE INTO `friend_list` (`userId`, `friendId`) VALUES
(5, 3),
(5, 4),
(5, 8),
(5, 7),
(3, 5),
(3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `group_type`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `group_type` (
  `id` int(11) UNSIGNED NOT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `group_type`:
--

--
-- Dumping data for table `group_type`
--

INSERT IGNORE INTO `group_type` (`id`, `description`) VALUES
(0, 'Private Community'),
(1, 'People'),
(2, 'Public Community');

-- --------------------------------------------------------

--
-- Table structure for table `im_blocklist`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_blocklist` (
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `g_id` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_blocklist`:
--

-- --------------------------------------------------------

--
-- Table structure for table `im_group`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_group` (
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `createdBy` bigint(11) UNSIGNED DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '1=personal chat,0=private group,2=public group',
  `block` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'unblock=0,block=1',
  `lastActive` varchar(100) DEFAULT NULL,
  `custom_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `im_group`:
--

--
-- Dumping data for table `im_group`
--

INSERT IGNORE INTO `im_group` (`g_id`, `name`, `createdBy`, `type`, `block`, `lastActive`, `custom_image`) VALUES
(1, 'Arbitrage Public Community', 2, 2, 0, '2019-06-07T01:16:33.018+0000', '05102019105210imfEypb1.png'),
(2, 'New Kappa', 5, 0, 0, '2019-07-11T06:41:28.606+0000', NULL),
(3, NULL, 3, 1, 0, '2019-05-20T05:55:40.711+0000', NULL),
(4, NULL, 8, 1, 0, '2019-05-14T01:25:19.242+0000', NULL),
(5, NULL, 8, 0, 0, '2019-07-11T08:45:59.436+0000', NULL),
(6, NULL, 8, 1, 0, '2019-05-14T08:53:25.274+0000', NULL),
(7, NULL, 8, 0, 0, '2019-06-04T12:01:19.428+0000', NULL),
(8, NULL, 5, 1, 0, '2019-07-05T08:23:29.311+0000', NULL),
(9, 'Payaman Palang', 5, 0, 0, '2019-07-11T08:43:15.642+0000', '05172019124118impHCVn9.jpg'),
(10, 'My new community', 5, 0, 0, '2019-06-07T01:18:18.392+0000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `im_group_invitations`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_group_invitations` (
  `id` int(11) NOT NULL,
  `token` char(40) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `expires_in` int(11) NOT NULL,
  `expired` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_group_invitations`:
--

--
-- Dumping data for table `im_group_invitations`
--

INSERT IGNORE INTO `im_group_invitations` (`id`, `token`, `group_id`, `user_id`, `timestamp`, `expires_in`, `expired`) VALUES
(58, '5243dac956a1fb6b534bf4ac326bebdf5f123188', 9, 5, 1563335333, 1563421733, 1),
(59, '466669f3cdcba6fadc79e0424bfbbc6b0d379c59', 9, 5, 1563425919, 1563512319, 0),
(60, '0cc188cc4164324320c0506eaf7294e135d098a1', 2, 5, 1563434929, 1563521329, 0),
(61, '2db417ef1b280d75993dba94af579d7788bb13d6', 9, 5, 1563457162, 1563543562, 0),
(62, 'cb89c54f2b4df34bb18552acd4be0272fde2f08a', 9, 5, 1563457444, 1563543844, 0),
(63, 'f16f8a9df7200e34a79aa0a06551b81a474ae93b', 9, 4, 1563457999, 1563544399, 0),
(64, 'dfacde60b1615178ec1e06e5af918d5f34bfbb37', 9, 4, 1563504421, 1563590821, 0),
(65, '885e55474750cffe04f195b2602c708b02435c8c', 9, 5, 1563770286, 1563856686, 0),
(66, '67dfc6e1e57daa589b2710c49770e7d8e3fc1297', 9, 5, 1563770295, 1563856695, 0),
(67, '15e65be99f4ff188f20f0040fe41e7ac2e5aced0', 9, 5, 1563770306, 1563856706, 0);

-- --------------------------------------------------------

--
-- Table structure for table `im_group_invitation_usage`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_group_invitation_usage` (
  `use_id` int(11) NOT NULL,
  `token_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_group_invitation_usage`:
--

--
-- Dumping data for table `im_group_invitation_usage`
--

INSERT IGNORE INTO `im_group_invitation_usage` (`use_id`, `token_id`, `user_id`, `timestamp`) VALUES
(41, 58, 5, 1563335992),
(42, 58, 5, 1563336074),
(44, 58, 5, 1563338566),
(56, 59, 8, 1563433924),
(59, 60, 8, 1563434947),
(66, 59, 5, 1563438136);

-- --------------------------------------------------------

--
-- Table structure for table `im_group_members`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_group_members` (
  `g_id` bigint(11) UNSIGNED DEFAULT NULL,
  `u_id` bigint(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_group_members`:
--

--
-- Dumping data for table `im_group_members`
--

INSERT IGNORE INTO `im_group_members` (`g_id`, `u_id`) VALUES
(1, 2),
(1, 3),
(2, 3),
(3, 3),
(5, 3),
(8, 3),
(9, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(1, 4),
(2, 4),
(3, 4),
(9, 4),
(10, 4),
(1, 5),
(2, 5),
(6, 5),
(8, 5),
(9, 5),
(10, 5),
(1, 6),
(4, 6),
(7, 6),
(1, 7),
(10, 7),
(1, 8),
(4, 8),
(5, 8),
(6, 8),
(7, 8),
(1, 9),
(7, 9),
(1, 10),
(15, 10),
(16, 10),
(17, 10),
(18, 10),
(19, 10),
(20, 10);

-- --------------------------------------------------------

--
-- Table structure for table `im_group_moderators`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_group_moderators` (
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_group_moderators`:
--

--
-- Dumping data for table `im_group_moderators`
--

INSERT IGNORE INTO `im_group_moderators` (`g_id`, `u_id`, `assigned_date`) VALUES
(2, 3, '2019-07-11 07:36:12'),
(2, 4, '2019-07-11 06:41:36'),
(5, 3, '2019-07-11 08:45:33'),
(9, 4, '2019-07-11 06:14:54'),
(9, 5, '2019-07-08 09:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `im_group_requests`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_group_requests` (
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `requested_date` datetime DEFAULT NULL,
  `accepted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_group_requests`:
--

--
-- Dumping data for table `im_group_requests`
--

INSERT IGNORE INTO `im_group_requests` (`g_id`, `u_id`, `requested_date`, `accepted_date`) VALUES
(9, 3, '2019-06-07 02:33:53', '2019-07-11 17:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `im_mention`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_mention` (
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `r_id` bigint(11) UNSIGNED NOT NULL,
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `date_time` varchar(100) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `seen_tstamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `im_mention`:
--

--
-- Dumping data for table `im_mention`
--

INSERT IGNORE INTO `im_mention` (`u_id`, `r_id`, `g_id`, `date_time`, `seen`, `seen_tstamp`) VALUES
(3, 5, 10, '2019-05-29T07:41:38.199+0000', 1, '2019-05-30 19:36:20'),
(3, 5, 2, '2019-05-29T07:52:10.287+0000', 1, '2019-06-07 09:24:15'),
(3, 5, 2, '2019-05-29T07:52:25.875+0000', 1, '2019-06-07 09:24:15'),
(3, 5, 2, '2019-05-29T10:05:20.506+0000', 1, '2019-06-07 09:24:15'),
(3, 5, 2, '2019-05-29T10:07:02.973+0000', 1, '2019-06-07 09:24:15'),
(4, 5, 2, '2019-05-29T11:48:22.429+0000', 1, '2019-06-07 09:24:15'),
(4, 5, 2, '2019-05-29T11:49:07.957+0000', 1, '2019-06-07 09:24:15'),
(3, 5, 2, '2019-05-29T11:50:35.338+0000', 1, '2019-06-07 09:24:15'),
(3, 5, 1, '2019-05-30T09:41:20.710+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 10, '2019-05-30T11:20:24.092+0000', 1, '2019-05-30 19:36:20'),
(3, 5, 10, '2019-05-30T11:21:19.914+0000', 1, '2019-05-30 19:36:20'),
(3, 5, 10, '2019-05-30T11:33:04.720+0000', 1, '2019-05-30 19:36:20'),
(3, 5, 1, '2019-05-30T11:33:26.832+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T06:52:18.493+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T06:52:46.082+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T06:54:10.446+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T06:56:59.589+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T06:58:37.512+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T08:00:23.698+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T08:28:34.903+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T08:29:40.001+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-05T08:31:45.323+0000', 1, '2019-06-06 14:00:04'),
(3, 5, 1, '2019-06-06T02:37:55.230+0000', 1, '2019-06-06 14:00:04'),
(5, 3, 1, '2019-06-07T01:16:33.018+0000', 1, '2019-06-07 10:30:27'),
(3, 5, 2, '2019-06-07T01:23:06.071+0000', 1, '2019-06-07 09:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `im_message`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

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
-- RELATIONSHIPS FOR TABLE `im_message`:
--

--
-- Dumping data for table `im_message`
--

INSERT IGNORE INTO `im_message` (`m_id`, `sender`, `receiver`, `message`, `onlyemoji`, `type`, `fileName`, `link`, `linkData`, `receiver_type`, `date`, `time`, `date_time`) VALUES
(2, 3, 1, 'New Group', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-10', '13:18:19', '2019-05-10T13:18:19.078+0000'),
(3, 5, 2, 'test group', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-10', '13:20:01', '2019-05-10T13:20:01.548+0000'),
(4, 3, 3, 'test john!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-10', '22:59:16', '2019-05-10T22:59:16.061+0000'),
(5, 8, 4, 'hello', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-14', '01:25:19', '2019-05-14T01:25:19.242+0000'),
(6, 8, 5, 'group test', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-14', '01:28:43', '2019-05-14T01:28:43.376+0000'),
(7, 8, 6, 'Hello Billy!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-14', '01:29:23', '2019-05-14T01:29:23.381+0000'),
(8, 8, 7, 'test only', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-14', '01:30:18', '2019-05-14T01:30:18.284+0000'),
(9, 10, 1, 'Hello to all!', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-14', '01:49:43', '2019-05-14T01:49:43.947+0000'),
(10, 3, 3, 'hello', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-14', '03:40:47', '2019-05-14T03:40:47.768+0000'),
(11, 4, 3, 'Hey!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-14', '03:51:24', '2019-05-14T03:51:24.629+0000'),
(12, 4, 3, 'you', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-14', '04:02:36', '2019-05-14T04:02:36.610+0000'),
(13, 4, 3, 'tsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-14', '04:02:45', '2019-05-14T04:02:45.379+0000'),
(14, 4, 3, 'dsad', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-14', '04:38:03', '2019-05-14T04:38:03.269+0000'),
(15, 8, 7, '7 is removed by 8', 0, 'update', NULL, NULL, NULL, 'group', '2019-05-14', '05:39:10', '2019-05-14T05:39:10.218+0000'),
(16, 3, 3, 'Yes!!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-15', '06:21:17', '2019-05-15T06:21:17.819+0000'),
(17, 4, 3, 'HAHA', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-15', '06:22:01', '2019-05-15T06:22:01.241+0000'),
(18, 3, 3, 'hello', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-17', '09:59:44', '2019-05-17T09:59:44.855+0000'),
(19, 5, 8, 'sdadas', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-17', '10:53:31', '2019-05-17T10:53:31.124+0000'),
(20, 5, 8, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-17', '11:22:00', '2019-05-17T11:22:00.316+0000'),
(21, 5, 8, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-17', '11:22:12', '2019-05-17T11:22:12.294+0000'),
(22, 5, 9, 'another group', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-17', '12:38:41', '2019-05-17T12:38:41.521+0000'),
(23, 5, 9, 'hahaa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-17', '12:38:57', '2019-05-17T12:38:57.894+0000'),
(24, 5, 9, '5 change the group name to Payaman Palang', 0, 'update', NULL, NULL, NULL, 'group', '2019-05-17', '12:41:01', '2019-05-17T12:41:01.116+0000'),
(25, 5, 10, 'Hello Friends!', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-18', '03:54:55', '2019-05-18T03:54:55.298+0000'),
(26, 5, 10, 'New Group Message', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-18', '05:34:47', '2019-05-18T05:34:47.825+0000'),
(27, 5, 10, '5 change the group name to My new community', 0, 'update', NULL, NULL, NULL, 'group', '2019-05-18', '05:35:10', '2019-05-18T05:35:10.858+0000'),
(28, 5, 8, 'Hello!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:26:12', '2019-05-20T05:26:12.365+0000'),
(29, 5, 8, 'Hey!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:29:08', '2019-05-20T05:29:08.198+0000'),
(30, 5, 8, 'Hu!!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:29:47', '2019-05-20T05:29:47.679+0000'),
(31, 3, 8, 'haha', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:30:02', '2019-05-20T05:30:02.201+0000'),
(32, 5, 8, 'hey', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:53:17', '2019-05-20T05:53:17.650+0000'),
(33, 5, 8, 'dsadas', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:54:10', '2019-05-20T05:54:10.503+0000'),
(34, 3, 3, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:55:40', '2019-05-20T05:55:40.711+0000'),
(35, 5, 8, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:55:49', '2019-05-20T05:55:49.415+0000'),
(36, 5, 8, '😍', 1, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '05:56:04', '2019-05-20T05:56:04.198+0000'),
(37, 5, 8, '0520201955629imp0nN08.jpg', 0, 'image', 'apple_logo.jpg', 'http://dev.vyndue.com/assets/im/group_8/0520201955629imp0nN08.jpg', '{\"mainUrl\":\"http://dev.vyndue.com/assets/im/group_8/0520201955629imp0nN08.jpg\",\"host\":\"dev.vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"http://dev.vyndue.com/image?u=http%3A%2F%2Fdev.vyndue.com%2Fassets%2Fim%2Fgroup_8%2F0520201955629imp0nN08.jpg\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":420,\"type\":\"jpg\",\"mime\":\"image/jpeg\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":17384,\"url\":\"http://dev.vyndue.com/assets/im/group_8/0520201955629imp0nN08.jpg\"},\"mainUrl\":\"http://dev.vyndue.com/assets/im/group_8/0520201955629imp0nN08.jpg\"}}', 'personal', '2019-05-20', '05:56:29', '2019-05-20T05:56:29.082+0000'),
(38, 5, 8, 'hello', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '06:15:54', '2019-05-20T06:15:54.900+0000'),
(39, 3, 2, 'hello', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-20', '06:22:51', '2019-05-20T06:22:51.831+0000'),
(40, 5, 2, 'Kamusta?', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-20', '06:22:58', '2019-05-20T06:22:58.926+0000'),
(41, 5, 2, 'Anu bago?', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-20', '06:23:12', '2019-05-20T06:23:12.181+0000'),
(42, 5, 2, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-20', '06:23:29', '2019-05-20T06:23:29.995+0000'),
(43, 5, 8, 'hays!! 😲 kamusta kana? 💖', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '06:28:53', '2019-05-20T06:28:53.540+0000'),
(44, 5, 8, 'dsdasdsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-20', '09:08:35', '2019-05-20T09:08:35.850+0000'),
(45, 8, 7, 'helllo Ben Tulfo', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:27:47', '2019-05-21T10:27:47.531+0000'),
(46, 8, 5, 'dsadas dsads dsa Jane Smith dsasa dd', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:29:18', '2019-05-21T10:29:18.324+0000'),
(47, 8, 5, 'hello sa lahat saldassad Ralph Tolipas', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:29:34', '2019-05-21T10:29:34.726+0000'),
(48, 8, 5, 'dsadsa dsa dsadsa ? . dsdsadas dsa Ralph Tolipas', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:30:34', '2019-05-21T10:30:34.765+0000'),
(49, 8, 5, '😍', 1, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:33:48', '2019-05-21T10:33:48.661+0000'),
(50, 8, 5, 'test 😝', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:34:10', '2019-05-21T10:34:10.031+0000'),
(51, 8, 5, 'hello @Jane Smith', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:35:39', '2019-05-21T10:35:39.345+0000'),
(52, 8, 5, 'hello', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-21', '10:41:36', '2019-05-21T10:41:36.744+0000'),
(66, 3, 2, 'sdsads', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-22', '05:08:31', '2019-05-22T05:08:31.316+0000'),
(67, 3, 2, 'dsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-22', '05:08:32', '2019-05-22T05:08:32.382+0000'),
(68, 3, 2, 'dsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-22', '05:08:33', '2019-05-22T05:08:33.197+0000'),
(69, 3, 2, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-22', '05:08:34', '2019-05-22T05:08:34.846+0000'),
(72, 3, 2, 'kamusta?', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-22', '05:50:51', '2019-05-22T05:50:51.479+0000'),
(76, 3, 2, 'hello kamusta <a href=\"#\" data-username=\"4\" class=\"mention\">@John Doe</a>?', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-22', '06:30:01', '2019-05-22T06:30:01.701+0000'),
(77, 3, 2, '<a href=\"https://arbitrage.ph/login/\">https://arbitrage.ph/login/</a>', 0, 'text', NULL, 'https://arbitrage.ph/login', '{\"mainUrl\":\"https://arbitrage.ph/login\",\"host\":\"arbitrage.ph\",\"title\":\"Login | Arbitrage\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":null,\"type\":null,\"size\":null,\"mainUrl\":null}}', 'group', '2019-05-22', '06:34:19', '2019-05-22T06:34:19.049+0000'),
(78, 3, 10, 'hello <a href=\"#\" data-username=\"4\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '07:37:26', '2019-05-23T07:37:26.146+0000'),
(79, 3, 10, '<a href=\"#\" data-username=\"4\" class=\"mention\">@John Doe</a>  ksadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '08:54:07', '2019-05-23T08:54:07.486+0000'),
(80, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '08:56:37', '2019-05-23T08:56:37.131+0000'),
(81, 5, 10, 'musta na? <a href=\"#\" data-username=\"3\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '09:29:59', '2019-05-23T09:29:59.786+0000'),
(82, 3, 10, 'hello', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '09:51:10', '2019-05-23T09:51:10.619+0000'),
(83, 3, 10, 'dito talaga oh', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '09:52:20', '2019-05-23T09:52:20.100+0000'),
(84, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '09:53:16', '2019-05-23T09:53:16.529+0000'),
(85, 3, 10, 'hello <a href=\"#\" data-username=\"4\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '09:54:29', '2019-05-23T09:54:29.135+0000'),
(86, 3, 10, 'hello <a href=\"#\" data-username=\"7\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '10:11:33', '2019-05-23T10:11:33.894+0000'),
(87, 3, 10, 'hello <a href=\"#\" data-username=\"7\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '10:14:43', '2019-05-23T10:14:43.042+0000'),
(88, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '10:16:53', '2019-05-23T10:16:53.477+0000'),
(89, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '10:21:23', '2019-05-23T10:21:23.524+0000'),
(90, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-23', '10:22:09', '2019-05-23T10:22:09.965+0000'),
(91, 3, 10, 'r', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '04:33:14', '2019-05-24T04:33:14.469+0000'),
(92, 3, 10, 'dsad', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '04:33:20', '2019-05-24T04:33:20.998+0000'),
(93, 3, 10, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '04:33:28', '2019-05-24T04:33:28.942+0000'),
(94, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '04:41:32', '2019-05-24T04:41:32.850+0000'),
(95, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '04:42:03', '2019-05-24T04:42:03.972+0000'),
(96, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '06:23:57', '2019-05-24T06:23:57.958+0000'),
(97, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '06:23:59', '2019-05-24T06:23:59.381+0000'),
(98, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '06:24:00', '2019-05-24T06:24:00.581+0000'),
(99, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '06:25:07', '2019-05-24T06:25:07.121+0000'),
(100, 3, 10, 'hello <a href=\"#\" data-username=\"5\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '06:25:08', '2019-05-24T06:25:08.214+0000'),
(101, 3, 10, 'hello <a href=\"#\" data-username=\"undefined\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '07:18:41', '2019-05-24T07:18:41.580+0000'),
(102, 3, 10, 'ralph <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '07:35:12', '2019-05-24T07:35:12.935+0000'),
(103, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>  and <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '08:13:34', '2019-05-24T08:13:34.928+0000'),
(104, 3, 10, 'sdadas', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '08:14:42', '2019-05-24T08:14:42.784+0000'),
(105, 3, 10, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:19:12', '2019-05-24T11:19:12.418+0000'),
(106, 3, 10, 'hello @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:23:32', '2019-05-24T11:23:32.715+0000'),
(107, 3, 10, '@', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:26:32', '2019-05-24T11:26:32.757+0000'),
(108, 3, 10, 'teasdadas @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:29:34', '2019-05-24T11:29:34.150+0000'),
(109, 3, 10, 'dsadsa @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:34:07', '2019-05-24T11:34:07.394+0000'),
(110, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>  and <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:44:12', '2019-05-24T11:44:12.272+0000'),
(111, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>  and <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:45:08', '2019-05-24T11:45:08.881+0000'),
(112, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>  and <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:48:08', '2019-05-24T11:48:08.075+0000'),
(113, 3, 10, 'hello kamusta na @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:52:15', '2019-05-24T11:52:15.017+0000'),
(114, 3, 10, 'hello @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '11:57:29', '2019-05-24T11:57:29.995+0000'),
(115, 3, 10, 'test <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:32:40', '2019-05-24T12:32:40.328+0000'),
(116, 3, 10, 'test <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:33:16', '2019-05-24T12:33:16.922+0000'),
(117, 3, 10, 'hello <a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>  <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:34:29', '2019-05-24T12:34:29.179+0000'),
(118, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>  @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:44:21', '2019-05-24T12:44:21.541+0000'),
(119, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a> <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a> @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:44:54', '2019-05-24T12:44:54.786+0000'),
(120, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>  <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>  kamusta', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:45:31', '2019-05-24T12:45:31.273+0000'),
(121, 3, 10, 'dsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:46:04', '2019-05-24T12:46:04.616+0000'),
(122, 3, 10, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>  <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>  <a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>  asdadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:46:20', '2019-05-24T12:46:20.100+0000'),
(123, 3, 10, 'hello anu na? <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-24', '12:48:15', '2019-05-24T12:48:15.609+0000'),
(124, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '03:52:51', '2019-05-25T03:52:51.885+0000'),
(125, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:00:09', '2019-05-25T04:00:09.970+0000'),
(126, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:00:33', '2019-05-25T04:00:33.780+0000'),
(127, 3, 10, 'hello <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:01:51', '2019-05-25T04:01:51.800+0000'),
(128, 5, 2, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:03:53', '2019-05-25T04:03:53.718+0000'),
(129, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:07:47', '2019-05-25T04:07:47.253+0000'),
(130, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:10:00', '2019-05-25T04:10:00.657+0000'),
(131, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:10:15', '2019-05-25T04:10:15.758+0000'),
(132, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:11:08', '2019-05-25T04:11:08.711+0000'),
(133, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:11:24', '2019-05-25T04:11:24.568+0000'),
(134, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>  😍', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:11:38', '2019-05-25T04:11:38.683+0000'),
(135, 5, 2, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:15:13', '2019-05-25T04:15:13.724+0000'),
(136, 5, 2, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:15:30', '2019-05-25T04:15:30.417+0000'),
(137, 5, 10, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:15:51', '2019-05-25T04:15:51.501+0000'),
(138, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '04:30:05', '2019-05-25T04:30:05.162+0000'),
(139, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:14:01', '2019-05-25T05:14:01.169+0000'),
(140, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:15:37', '2019-05-25T05:15:37.325+0000'),
(141, 3, 10, 'hello @', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:33:39', '2019-05-25T05:33:39.525+0000'),
(142, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:34:07', '2019-05-25T05:34:07.845+0000'),
(143, 3, 10, 'heheheh <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:34:49', '2019-05-25T05:34:49.999+0000'),
(144, 3, 10, '<a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:35:07', '2019-05-25T05:35:07.165+0000'),
(145, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:36:22', '2019-05-25T05:36:22.922+0000'),
(146, 3, 10, 'dsadsa <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:39:05', '2019-05-25T05:39:05.888+0000'),
(147, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:44:43', '2019-05-25T05:44:43.420+0000'),
(148, 3, 10, 'ui! <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:48:18', '2019-05-25T05:48:18.554+0000'),
(149, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:49:35', '2019-05-25T05:49:35.724+0000'),
(150, 5, 10, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:49:46', '2019-05-25T05:49:46.800+0000'),
(151, 3, 10, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:51:09', '2019-05-25T05:51:09.105+0000'),
(152, 5, 10, '<a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:51:24', '2019-05-25T05:51:24.104+0000'),
(153, 5, 10, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:51:29', '2019-05-25T05:51:29.957+0000'),
(154, 5, 10, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:55:41', '2019-05-25T05:55:41.383+0000'),
(155, 5, 10, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '05:59:25', '2019-05-25T05:59:25.788+0000'),
(156, 3, 10, 'hello <a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:36:15', '2019-05-25T06:36:15.843+0000'),
(157, 3, 10, 'hello again <a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:36:40', '2019-05-25T06:36:40.627+0000'),
(158, 3, 10, 'hello <a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:36:55', '2019-05-25T06:36:55.934+0000'),
(159, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:37:02', '2019-05-25T06:37:02.116+0000'),
(160, 3, 10, 'hey <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:37:25', '2019-05-25T06:37:25.525+0000'),
(161, 5, 10, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:37:39', '2019-05-25T06:37:39.773+0000'),
(162, 7, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:38:54', '2019-05-25T06:38:54.289+0000'),
(163, 7, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:39:17', '2019-05-25T06:39:17.202+0000'),
(164, 5, 10, '@<a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:39:42', '2019-05-25T06:39:42.595+0000'),
(165, 3, 10, '<a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:39:51', '2019-05-25T06:39:51.698+0000'),
(166, 3, 10, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:43:11', '2019-05-25T06:43:11.920+0000'),
(167, 3, 10, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:44:28', '2019-05-25T06:44:28.359+0000'),
(168, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:46:02', '2019-05-25T06:46:02.117+0000'),
(169, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:49:01', '2019-05-25T06:49:01.873+0000'),
(170, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:50:11', '2019-05-25T06:50:11.901+0000'),
(171, 3, 10, '<a href=\"#\" data-username=\"MPxLsw9lkp\" class=\"mention\">@Sarah Williams</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:52:53', '2019-05-25T06:52:53.921+0000'),
(172, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:53:07', '2019-05-25T06:53:07.030+0000'),
(173, 3, 10, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:55:02', '2019-05-25T06:55:02.924+0000'),
(174, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '06:55:15', '2019-05-25T06:55:15.777+0000'),
(175, 5, 2, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '07:14:21', '2019-05-25T07:14:21.652+0000'),
(176, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '07:14:45', '2019-05-25T07:14:45.983+0000'),
(177, 5, 2, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '07:14:57', '2019-05-25T07:14:57.090+0000'),
(178, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '07:55:45', '2019-05-25T07:55:45.504+0000'),
(179, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:03:12', '2019-05-25T08:03:12.356+0000'),
(180, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:17:41', '2019-05-25T08:17:41.802+0000'),
(181, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:20:46', '2019-05-25T08:20:46.737+0000'),
(182, 3, 2, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:21:27', '2019-05-25T08:21:27.812+0000'),
(183, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:22:00', '2019-05-25T08:22:00.964+0000'),
(184, 3, 2, 'hello . na <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:32:25', '2019-05-25T08:32:25.822+0000'),
(185, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:37:15', '2019-05-25T08:37:15.705+0000'),
(186, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:40:43', '2019-05-25T08:40:43.916+0000'),
(187, 3, 2, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:40:50', '2019-05-25T08:40:50.468+0000'),
(188, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:43:20', '2019-05-25T08:43:20.842+0000'),
(189, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:43:30', '2019-05-25T08:43:30.426+0000'),
(190, 3, 2, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:47:35', '2019-05-25T08:47:35.802+0000'),
(191, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:47:51', '2019-05-25T08:47:51.787+0000'),
(192, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:48:02', '2019-05-25T08:48:02.836+0000'),
(193, 3, 2, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:48:08', '2019-05-25T08:48:08.794+0000'),
(194, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>  <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:49:04', '2019-05-25T08:49:04.434+0000'),
(195, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:49:16', '2019-05-25T08:49:16.535+0000'),
(196, 3, 2, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:49:23', '2019-05-25T08:49:23.354+0000'),
(197, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a> <a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:49:36', '2019-05-25T08:49:36.393+0000'),
(198, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-25', '08:50:15', '2019-05-25T08:50:15.724+0000'),
(199, 3, 2, '<a href=\"#\" data-username=\"uBNvSBrIXg\" class=\"mention\">@John Doe</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-27', '11:12:29', '2019-05-27T11:12:29.497+0000'),
(200, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:28:35', '2019-05-29T05:28:35.784+0000'),
(201, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:31:44', '2019-05-29T05:31:44.306+0000'),
(202, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:37:50', '2019-05-29T05:37:50.104+0000'),
(203, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:38:56', '2019-05-29T05:38:56.291+0000'),
(204, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:40:10', '2019-05-29T05:40:10.294+0000'),
(205, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:41:04', '2019-05-29T05:41:04.618+0000'),
(206, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:43:03', '2019-05-29T05:43:03.118+0000'),
(207, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:44:03', '2019-05-29T05:44:03.821+0000'),
(208, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:45:18', '2019-05-29T05:45:18.160+0000'),
(209, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:45:29', '2019-05-29T05:45:29.325+0000'),
(210, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:47:05', '2019-05-29T05:47:05.206+0000'),
(211, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:47:13', '2019-05-29T05:47:13.925+0000'),
(212, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:47:46', '2019-05-29T05:47:46.847+0000'),
(213, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:48:22', '2019-05-29T05:48:22.546+0000'),
(214, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:52:24', '2019-05-29T05:52:24.674+0000'),
(215, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:54:02', '2019-05-29T05:54:02.602+0000'),
(216, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:54:13', '2019-05-29T05:54:13.518+0000'),
(217, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:54:54', '2019-05-29T05:54:54.441+0000'),
(218, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:55:00', '2019-05-29T05:55:00.833+0000'),
(219, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:58:13', '2019-05-29T05:58:13.308+0000'),
(220, 3, 2, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '05:59:22', '2019-05-29T05:59:22.338+0000'),
(221, 3, 10, 'dsadsad', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:00:28', '2019-05-29T06:00:28.943+0000'),
(222, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:00:45', '2019-05-29T06:00:45.119+0000'),
(223, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:00:46', '2019-05-29T06:00:46.721+0000'),
(224, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:00:48', '2019-05-29T06:00:48.952+0000'),
(225, 3, 2, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:00:58', '2019-05-29T06:00:58.973+0000'),
(226, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:01:06', '2019-05-29T06:01:06.738+0000'),
(227, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:03:59', '2019-05-29T06:03:59.580+0000'),
(228, 3, 10, 'dsad', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:04:02', '2019-05-29T06:04:02.925+0000'),
(229, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:04:11', '2019-05-29T06:04:11.655+0000'),
(230, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:04:14', '2019-05-29T06:04:14.881+0000'),
(231, 3, 10, 'dsadsad', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:04:19', '2019-05-29T06:04:19.019+0000'),
(232, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:39:26', '2019-05-29T06:39:26.615+0000'),
(233, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:40:05', '2019-05-29T06:40:05.007+0000'),
(234, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '06:40:12', '2019-05-29T06:40:12.484+0000'),
(235, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:04:49', '2019-05-29T07:04:49.612+0000'),
(236, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:04:56', '2019-05-29T07:04:56.207+0000'),
(237, 3, 10, 'wqewqewq', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:05:06', '2019-05-29T07:05:06.864+0000'),
(238, 3, 10, 'dsdsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:05:15', '2019-05-29T07:05:15.165+0000'),
(239, 3, 10, 'adsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:05:40', '2019-05-29T07:05:40.842+0000'),
(240, 3, 10, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:05:48', '2019-05-29T07:05:48.214+0000'),
(241, 3, 10, 'dsadsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:05:51', '2019-05-29T07:05:51.839+0000'),
(242, 3, 10, 'dsasa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:39:00', '2019-05-29T07:39:00.792+0000'),
(243, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:41:38', '2019-05-29T07:41:38.199+0000'),
(244, 3, 10, 'hehel', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:42:41', '2019-05-29T07:42:41.628+0000'),
(245, 3, 10, 'kamusta ha', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:43:32', '2019-05-29T07:43:32.534+0000'),
(246, 3, 2, 'ddsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:43:51', '2019-05-29T07:43:51.033+0000'),
(247, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:52:10', '2019-05-29T07:52:10.287+0000'),
(248, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '07:52:25', '2019-05-29T07:52:25.875+0000'),
(249, 3, 8, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-29', '08:48:22', '2019-05-29T08:48:22.740+0000'),
(250, 3, 8, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-29', '10:04:47', '2019-05-29T10:04:47.673+0000'),
(251, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '10:05:20', '2019-05-29T10:05:20.506+0000'),
(252, 3, 2, 'dsadsad', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '10:06:08', '2019-05-29T10:06:08.508+0000'),
(253, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '10:07:02', '2019-05-29T10:07:02.973+0000'),
(254, 4, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '11:48:22', '2019-05-29T11:48:22.429+0000'),
(255, 4, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '11:49:07', '2019-05-29T11:49:07.957+0000'),
(256, 4, 2, 'billy!!', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '11:49:16', '2019-05-29T11:49:16.808+0000'),
(257, 3, 8, 'billy!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-29', '11:49:57', '2019-05-29T11:49:57.637+0000'),
(258, 3, 8, 'billy!!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-29', '11:50:17', '2019-05-29T11:50:17.303+0000'),
(259, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-29', '11:50:35', '2019-05-29T11:50:35.338+0000'),
(260, 3, 8, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-29', '11:50:39', '2019-05-29T11:50:39.014+0000'),
(261, 3, 8, 'dsadsad', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-30', '09:40:19', '2019-05-30T09:40:19.087+0000'),
(262, 3, 8, 'dasdsad', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-30', '09:40:33', '2019-05-30T09:40:33.735+0000'),
(263, 3, 8, 'hellldsadsads', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-30', '09:40:54', '2019-05-30T09:40:54.952+0000'),
(264, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-30', '09:41:20', '2019-05-30T09:41:20.710+0000'),
(265, 3, 1, 'dsadsad', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-30', '09:41:24', '2019-05-30T09:41:24.957+0000'),
(266, 3, 1, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-30', '09:41:49', '2019-05-30T09:41:49.404+0000'),
(267, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-30', '11:20:24', '2019-05-30T11:20:24.092+0000'),
(268, 3, 10, 'hello <a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-30', '11:21:19', '2019-05-30T11:21:19.914+0000'),
(269, 3, 10, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-30', '11:33:04', '2019-05-30T11:33:04.720+0000'),
(270, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-30', '11:33:26', '2019-05-30T11:33:26.832+0000'),
(271, 5, 10, '3 is removed by 5', 0, 'update', NULL, NULL, NULL, 'group', '2019-06-04', '12:19:08', '2019-06-04T12:19:08.317+0000'),
(272, 5, 10, '3 is removed by 5', 0, 'update', NULL, NULL, NULL, 'group', '2019-06-04', '12:22:58', '2019-06-04T12:22:58.919+0000'),
(273, 3, 8, 'dsads', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-05', '06:07:04', '2019-06-05T06:07:04.967+0000'),
(274, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '06:52:18', '2019-06-05T06:52:18.493+0000'),
(275, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '06:52:46', '2019-06-05T06:52:46.082+0000'),
(276, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '06:54:10', '2019-06-05T06:54:10.446+0000'),
(277, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '06:56:59', '2019-06-05T06:56:59.589+0000'),
(278, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '06:58:37', '2019-06-05T06:58:37.512+0000'),
(279, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '08:00:23', '2019-06-05T08:00:23.698+0000'),
(280, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '08:28:34', '2019-06-05T08:28:34.903+0000'),
(281, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '08:29:40', '2019-06-05T08:29:40.001+0000'),
(282, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-05', '08:31:45', '2019-06-05T08:31:45.323+0000'),
(283, 3, 1, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-06', '02:37:55', '2019-06-06T02:37:55.230+0000'),
(284, 5, 8, 'hey', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-07', '01:16:12', '2019-06-07T01:16:12.643+0000'),
(285, 5, 8, 'hey', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-07', '01:16:21', '2019-06-07T01:16:21.010+0000'),
(286, 5, 1, '<a href=\"#\" data-username=\"b17ZyhRR5y\" class=\"mention\">@Ralph Tolipas</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-07', '01:16:33', '2019-06-07T01:16:33.018+0000'),
(287, 5, 10, 'hey', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-07', '01:18:18', '2019-06-07T01:18:18.392+0000'),
(288, 3, 2, '<a href=\"#\" data-username=\"Zjk3hVyYNy\" class=\"mention\">@Billy Cruz</a>', 0, 'text', NULL, NULL, NULL, 'group', '2019-06-07', '01:23:06', '2019-06-07T01:23:06.071+0000'),
(289, 3, 15, 'dsadsadas', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-15', '05:44:11', '2019-06-15T05:44:11.179+0000'),
(290, 3, 16, 'dsdsadsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-15', '05:47:44', '2019-06-15T05:47:44.273+0000'),
(291, 3, 17, 'dsads', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-15', '05:55:28', '2019-06-15T05:55:28.428+0000'),
(292, 3, 18, 'sdadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-15', '06:12:26', '2019-06-15T06:12:26.513+0000'),
(293, 3, 19, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-15', '06:15:55', '2019-06-15T06:15:55.391+0000'),
(294, 3, 20, 'dsadsa', 0, 'text', NULL, NULL, NULL, 'personal', '2019-06-15', '06:25:50', '2019-06-15T06:25:50.777+0000'),
(295, 3, 8, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-07-05', '08:23:29', '2019-07-05T08:23:29.311+0000'),
(296, 3, 5, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-07-05', '08:55:57', '2019-07-05T08:55:57.102+0000'),
(297, 3, 5, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-07-08', '04:28:52', '2019-07-08T04:28:52.495+0000'),
(298, 5, 2, '5 change the group name to New Community', 0, 'update', NULL, NULL, NULL, 'group', '2019-07-11', '06:41:09', '2019-07-11T06:41:09.081+0000'),
(299, 5, 2, '5 change the group name to New Kappa', 0, 'update', NULL, NULL, NULL, 'group', '2019-07-11', '06:41:29', '2019-07-11T06:41:29.020+0000'),
(300, 4, 9, '7 is removed by 4', 0, 'update', NULL, NULL, NULL, 'group', '2019-07-11', '08:43:15', '2019-07-11T08:43:15.216+0000'),
(301, 3, 5, '6 is removed by 3', 0, 'update', NULL, NULL, NULL, 'group', '2019-07-11', '08:45:59', '2019-07-11T08:45:59.012+0000');

-- --------------------------------------------------------

--
-- Table structure for table `im_mutelist`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_mutelist` (
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `g_id` bigint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_mutelist`:
--

-- --------------------------------------------------------

--
-- Table structure for table `im_notifications`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_notifications` (
  `n_id` bigint(11) NOT NULL,
  `u_id` bigint(11) UNSIGNED NOT NULL,
  `r_id` bigint(11) UNSIGNED NOT NULL,
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `t_id` bigint(11) UNSIGNED NOT NULL,
  `date_time` varchar(100) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `seen_tstamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `im_notifications`:
--

--
-- Dumping data for table `im_notifications`
--

INSERT IGNORE INTO `im_notifications` (`n_id`, `u_id`, `r_id`, `g_id`, `t_id`, `date_time`, `seen`, `seen_tstamp`) VALUES
(1, 3, 5, 9, 1, '2019-06-07 2:33:53', 1, '2019-06-07 11:56:03'),
(2, 5, 7, 9, 8, '2019-07-09 13:21:22', 0, NULL),
(3, 5, 7, 9, 8, '2019-07-09 13:27:38', 0, NULL),
(4, 5, 7, 9, 7, '2019-07-09 13:27:46', 0, NULL),
(5, 5, 7, 9, 8, '2019-07-09 13:27:48', 0, NULL),
(6, 5, 4, 9, 8, '2019-07-09 13:31:53', 0, NULL),
(7, 5, 4, 9, 7, '2019-07-09 13:32:45', 0, NULL),
(8, 5, 4, 9, 8, '2019-07-09 13:34:27', 0, NULL),
(9, 5, 4, 9, 7, '2019-07-09 13:34:36', 1, '2019-07-09 16:58:22'),
(10, 5, 4, 9, 8, '2019-07-09 13:38:01', 1, '2019-07-09 16:58:20'),
(11, 5, 4, 9, 7, '2019-07-09 13:38:09', 1, '2019-07-09 16:58:18'),
(12, 5, 4, 9, 8, '2019-07-09 13:39:44', 1, '2019-07-09 16:58:16'),
(13, 5, 4, 9, 7, '2019-07-09 13:59:22', 1, '2019-07-09 16:58:13'),
(14, 5, 4, 9, 8, '2019-07-09 14:04:25', 1, '2019-07-09 16:58:11'),
(15, 5, 4, 9, 7, '2019-07-09 14:05:07', 1, '2019-07-09 16:58:09'),
(16, 5, 4, 9, 8, '2019-07-09 14:06:09', 1, '2019-07-09 16:58:07'),
(17, 5, 4, 9, 7, '2019-07-09 14:31:08', 1, '2019-07-09 16:58:05'),
(18, 5, 4, 9, 8, '2019-07-09 14:31:16', 1, '2019-07-09 16:57:59'),
(19, 5, 4, 9, 7, '2019-07-09 14:51:11', 1, '2019-07-09 16:57:57'),
(20, 5, 4, 9, 8, '2019-07-09 15:02:54', 1, '2019-07-09 16:57:55'),
(21, 5, 4, 9, 7, '2019-07-09 15:04:22', 1, '2019-07-09 16:57:51'),
(22, 5, 4, 9, 8, '2019-07-09 15:06:38', 1, '2019-07-09 16:57:49'),
(23, 5, 4, 9, 7, '2019-07-09 15:07:37', 1, '2019-07-09 16:57:47'),
(24, 5, 4, 9, 8, '2019-07-09 16:00:40', 1, '2019-07-09 16:57:44'),
(25, 5, 7, 9, 7, '2019-07-09 16:07:17', 0, NULL),
(26, 5, 7, 9, 8, '2019-07-09 16:27:20', 0, NULL),
(27, 5, 4, 9, 7, '2019-07-09 16:27:22', 1, '2019-07-09 16:57:41'),
(28, 5, 4, 9, 8, '2019-07-09 16:38:46', 1, '2019-07-09 16:53:15'),
(29, 5, 7, 9, 7, '2019-07-09 16:38:49', 0, NULL),
(30, 5, 7, 9, 8, '2019-07-09 16:38:55', 0, NULL),
(31, 5, 4, 9, 7, '2019-07-09 16:38:57', 1, '2019-07-09 16:50:25'),
(32, 5, 4, 9, 8, '2019-07-09 16:39:04', 1, '2019-07-09 16:47:51'),
(33, 5, 4, 9, 7, '2019-07-09 16:39:05', 1, '2019-07-09 16:50:20'),
(34, 5, 4, 9, 8, '2019-07-09 16:39:06', 1, '2019-07-09 16:50:17'),
(35, 5, 7, 9, 7, '2019-07-09 16:39:09', 0, NULL),
(36, 5, 7, 9, 8, '2019-07-10 15:34:40', 0, NULL),
(37, 5, 7, 9, 7, '2019-07-10 15:34:42', 0, NULL),
(38, 5, 7, 9, 8, '2019-07-10 15:35:20', 0, NULL),
(39, 5, 4, 9, 7, '2019-07-10 15:58:18', 0, NULL),
(40, 5, 4, 9, 8, '2019-07-11 14:14:52', 0, NULL),
(41, 5, 4, 9, 7, '2019-07-11 14:14:54', 0, NULL),
(42, 5, 4, 2, 7, '2019-07-11 14:41:36', 0, NULL),
(43, 5, 3, 2, 7, '2019-07-11 15:36:12', 0, NULL),
(44, 8, 3, 5, 7, '2019-07-11 16:45:33', 1, '2019-07-11 16:45:52'),
(45, 4, 3, 9, 2, '2019-07-11 17:12:42', 0, NULL),
(46, 4, 3, 9, 2, '2019-07-11 17:13:13', 1, '2019-07-11 17:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `im_notification_types`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_notification_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `badge` varchar(30) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_notification_types`:
--

--
-- Dumping data for table `im_notification_types`
--

INSERT IGNORE INTO `im_notification_types` (`id`, `type`, `description`, `badge`, `icon`) VALUES
(1, 'Community Join Request', 'has a request to join', 'user-plus', 'users'),
(2, 'Community Join Request Approved', 'has approved your request to join', 'thumbs-up', 'users'),
(3, 'Member chatted a community', 'has a new message', 'info-circle', 'users'),
(4, 'Member mentioned a member', 'has mentioned you', 'at', 'users'),
(5, 'Person received a personal chat', 'has a new message', 'info-circle', 'user'),
(6, 'Community Join Request Disapproved', 'has disapproved your request to join', 'thumbs-down', 'users'),
(7, 'Community Administrator promote Member to Moderator', 'has promoted you as a Moderator', 'balance-scale', 'user\n'),
(8, 'Community Administrator demote Moderator to Member', 'has removed you as a Moderator', 'info-circle', 'user\n');

-- --------------------------------------------------------

--
-- Table structure for table `im_receiver`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_receiver` (
  `g_id` bigint(11) UNSIGNED NOT NULL,
  `m_id` bigint(11) UNSIGNED NOT NULL,
  `r_id` bigint(11) UNSIGNED NOT NULL,
  `received` int(1) NOT NULL,
  `announced` int(1) NOT NULL DEFAULT '0',
  `time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `im_receiver`:
--

--
-- Dumping data for table `im_receiver`
--

INSERT IGNORE INTO `im_receiver` (`g_id`, `m_id`, `r_id`, `received`, `announced`, `time`) VALUES
(1, 286, 2, 0, 0, '2019-06-07T01:16:33.018+0000'),
(1, 286, 3, 1, 1, '2019-06-07T02:30:27.257+0000'),
(1, 286, 4, 1, 1, '2019-07-10T07:27:11.158+0000'),
(1, 286, 5, 1, 1, '2019-06-07T01:16:33.348+0000'),
(1, 286, 6, 0, 0, '2019-06-07T01:16:33.018+0000'),
(1, 286, 7, 0, 0, '2019-06-07T01:16:33.018+0000'),
(1, 286, 8, 1, 1, '2019-07-11T08:45:18.101+0000'),
(1, 286, 9, 0, 0, '2019-06-07T01:16:33.018+0000'),
(1, 286, 10, 1, 1, '2019-06-15T06:11:02.508+0000'),
(10, 287, 4, 1, 1, '2019-07-09T09:07:23.796+0000'),
(10, 287, 5, 1, 1, '2019-06-07T01:18:18.563+0000'),
(10, 287, 7, 0, 0, '2019-06-07T01:18:18.392+0000'),
(2, 288, 4, 1, 1, '2019-07-09T09:00:39.062+0000'),
(2, 288, 5, 1, 1, '2019-06-07T01:24:15.413+0000'),
(15, 289, 10, 0, 0, '2019-06-15T05:44:11.179+0000'),
(16, 290, 10, 0, 0, '2019-06-15T05:47:44.273+0000'),
(17, 291, 10, 1, 1, '2019-06-15T06:10:52.364+0000'),
(18, 292, 10, 0, 0, '2019-06-15T06:12:26.513+0000'),
(19, 293, 10, 0, 0, '2019-06-15T06:15:55.391+0000'),
(20, 294, 10, 0, 0, '2019-06-15T06:25:50.777+0000'),
(8, 295, 5, 1, 1, '2019-07-08T06:01:36.866+0000'),
(5, 297, 8, 1, 1, '2019-07-11T08:45:19.335+0000');

-- --------------------------------------------------------

--
-- Table structure for table `im_usersessions`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_usersessions` (
  `u_id` bigint(11) NOT NULL,
  `token` longtext NOT NULL,
  `socketId` longtext NOT NULL,
  `lastActiveTime` varchar(100) DEFAULT NULL,
  `validity` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `im_usersessions`:
--

--
-- Dumping data for table `im_usersessions`
--

INSERT IGNORE INTO `im_usersessions` (`u_id`, `token`, `socketId`, `lastActiveTime`, `validity`) VALUES
(3, 'xut5EtkO8UNgYeVUn6MAzAxj9FDeBMixNI0Fl0MOho7jW9ycE40fWrGSSPzv', 'FS8RBDH0Kmx0siISAAAC', '2019-07-15T09:01:30.925+0000', '2019-07-16T09:13:09.195+0000'),
(3, 'X49AfdAhf0kaLkfChGp1e2lvlmp184c4wy2ehJIneMtYo0uv6YrYXBbClFoO', 'CXKQ24ZxQRsGOiBgAAAI', '2019-07-16T03:04:20.724+0000', '2019-07-21T03:09:01.556+0000'),
(5, 'xyz4gMGNJrblTzihHla1slN9qNRKTaCjrn3q4l8SuIhAm9f0PMhS0diWalY2', 'v_8lPNEcIpFKD6GBAAAG', NULL, '2019-07-21T03:05:26.288+0000');

-- --------------------------------------------------------

--
-- Table structure for table `im_usersocket`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `im_usersocket` (
  `userId` bigint(11) UNSIGNED NOT NULL,
  `socketId` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `im_usersocket`:
--

--
-- Dumping data for table `im_usersocket`
--

INSERT IGNORE INTO `im_usersocket` (`userId`, `socketId`) VALUES
(5, 'v_8lPNEcIpFKD6GBAAAG'),
(3, 'CXKQ24ZxQRsGOiBgAAAI');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `migrations`:
--

--
-- Dumping data for table `migrations`
--

INSERT IGNORE INTO `migrations` (`version`) VALUES
(11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

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
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Dumping data for table `users`
--

INSERT IGNORE INTO `users` (`userId`, `userSecret`, `firstName`, `lastName`, `userEmail`, `userPassword`, `userMobile`, `userDateOfBirth`, `userGender`, `userStatus`, `active`, `userVerification`, `userAddress`, `userProfilePicture`, `userResetToken`, `userType`, `lastModified`) VALUES
(1, 'OpMuUlPy7Z', 'Arbitrage', 'Admininistrator', 'arbitrage@email.com', '$2y$10$VvPprLmMbfplQHCAiMiiluNUVHLk1DoN7deghMoX9cDvbEFaS2zPe', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 0, '2019-05-10 7:28:59'),
(2, 'Ncoi35f9k4', 'Arbitrage', 'Admininistrator', 'admin@email.com', '$2y$10$VsTBWYP0ylgNPcdAwqg4UunoTjF/hqrY2eW/dlKAsEW/T9Kj81fQa', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-05-10 10:17:57'),
(3, 'b17ZyhRR5y', 'Ralph', 'Tolipas', 'ralph@email.com', '$2y$10$0ifKcoGF8uHOyFC/y5rRcewn5Y3zti9eNQmk022E3UV8h/nl2U07G', NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, 1, '2019-05-10 12:32:56'),
(4, 'uBNvSBrIXg', 'John', 'Doe', 'john@email.com', '$2y$10$QBnuTZKF5/Ys0m.V7A5T1.JZsxPyeeoYuodPuClFy4ln2Wmjvxjw.', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-05-10 13:15:55'),
(5, 'Zjk3hVyYNy', 'Billy', 'Cruz', 'billy@email.com', '$2y$10$pDUU5MN1ac385VfOO2vPBelfGwJ4wK.o3rn69vFKtsXdTYl7oRfba', NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, 1, '2019-05-10 13:19:30'),
(6, 'HPHJIkyXtt', 'Jane', 'Smith', 'jane@email.com', '$2y$10$c.eBOj/6uPR.dQu58pxGKuV13HtThv0XbuXLMeMDDpfQxi1YO.xaC', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-05-13 6:14:59'),
(7, 'MPxLsw9lkp', 'Sarah', 'Williams', 'sarah@email.com', '$2y$10$5KWITVVMyDk.Pag8qgVdzOTk0v40lILv69hlv3SWxTlNVaYkd90Ra', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-05-13 6:15:44'),
(8, '4aESvTlAOm', 'Tim', 'Ryans', 'tim@email.com', '$2y$10$vg4A8LOomZUbj5cgosDa/uY5tozE6e.YTW.0prYuEelzvv7pZhs42', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-05-13 6:16:34'),
(9, 'JK9uraBGru', 'Ben', 'Tulfo', 'ben@email.com', '$2y$10$X9WhVt6RDSsLKCQW9Tf6rO0qN6tnzWfo9p8MC/vzLoz1duH/wpekq', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-05-13 6:17:02'),
(10, 'EzoFSyWUc9', 'Terisa', 'Chuvakano', 'terisa@email.com', '$2y$10$lJJk9rJuG.5Az/2ljvbdsO9vjE1MQLGG8npp.OKMJ9Jg5Fo2kikOa', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-05-14 1:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `users_roles` (
  `type` int(2) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `users_roles`:
--

--
-- Dumping data for table `users_roles`
--

INSERT IGNORE INTO `users_roles` (`type`, `role`) VALUES
(0, 'ROLE_ADMIN'),
(1, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Table structure for table `user_device`
--
-- Creation: Jul 22, 2019 at 12:22 PM
--

CREATE TABLE `user_device` (
  `userId` bigint(11) UNSIGNED NOT NULL,
  `deviceId` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `user_device`:
--

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
-- Indexes for table `group_type`
--
ALTER TABLE `group_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `im_blocklist`
--
ALTER TABLE `im_blocklist`
  ADD UNIQUE KEY `nodup` (`u_id`,`g_id`);

--
-- Indexes for table `im_group`
--
ALTER TABLE `im_group`
  ADD PRIMARY KEY (`g_id`),
  ADD KEY `createdBy` (`createdBy`);

--
-- Indexes for table `im_group_invitations`
--
ALTER TABLE `im_group_invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `im_group_invitation_usage`
--
ALTER TABLE `im_group_invitation_usage`
  ADD PRIMARY KEY (`use_id`);

--
-- Indexes for table `im_group_members`
--
ALTER TABLE `im_group_members`
  ADD UNIQUE KEY `nodup` (`u_id`,`g_id`);

--
-- Indexes for table `im_group_moderators`
--
ALTER TABLE `im_group_moderators`
  ADD PRIMARY KEY (`g_id`,`u_id`);

--
-- Indexes for table `im_group_requests`
--
ALTER TABLE `im_group_requests`
  ADD PRIMARY KEY (`g_id`,`u_id`);

--
-- Indexes for table `im_message`
--
ALTER TABLE `im_message`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `im_mutelist`
--
ALTER TABLE `im_mutelist`
  ADD UNIQUE KEY `nodup` (`u_id`,`g_id`);

--
-- Indexes for table `im_notifications`
--
ALTER TABLE `im_notifications`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `im_notification_types`
--
ALTER TABLE `im_notification_types`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_contactinfo`
--
ALTER TABLE `admin_contactinfo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `im_group`
--
ALTER TABLE `im_group`
  MODIFY `g_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `im_group_invitations`
--
ALTER TABLE `im_group_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `im_group_invitation_usage`
--
ALTER TABLE `im_group_invitation_usage`
  MODIFY `use_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `im_message`
--
ALTER TABLE `im_message`
  MODIFY `m_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT for table `im_notifications`
--
ALTER TABLE `im_notifications`
  MODIFY `n_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `im_notification_types`
--
ALTER TABLE `im_notification_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;
