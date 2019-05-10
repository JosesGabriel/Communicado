-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 05, 2019 at 01:55 AM
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
(4, 7, 2);

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
(1, NULL, 10, 1, 0, '2019-04-24T19:17:59.346+0000', NULL),
(2, NULL, 14, 1, 0, '2019-04-25T00:06:24.851+0000', NULL),
(3, NULL, 14, 1, 0, '2019-04-25T11:50:54.979+0000', NULL),
(4, NULL, 13, 1, 0, '2019-04-25T00:00:49.159+0000', NULL),
(5, NULL, 15, 1, 0, '2019-05-01T02:06:45.774+0000', NULL),
(6, NULL, 15, 1, 0, '2019-04-29T11:33:10.364+0000', NULL),
(7, 'Team Arbitrage', 15, 0, 0, '2019-05-02T13:20:37.477+0000', '0430201975755imXTj217.png'),
(8, NULL, 16, 1, 0, '2019-04-25T06:10:50.035+0000', NULL),
(9, NULL, 16, 1, 0, '2019-04-25T07:27:29.205+0000', NULL),
(10, NULL, 17, 1, 0, '2019-04-27T03:59:01.311+0000', NULL),
(11, NULL, 18, 1, 0, '2019-04-28T09:05:04.449+0000', NULL),
(12, NULL, 10, 0, 0, '2019-04-29T04:22:41.701+0000', NULL),
(13, NULL, 19, 1, 0, '2019-04-30T15:19:43.934+0000', NULL),
(14, NULL, 19, 1, 0, '2019-04-30T02:58:20.978+0000', NULL),
(15, NULL, 15, 0, 0, '2019-04-30T16:20:36.620+0000', '04302019154111imQW1Bd15.jpg'),
(16, NULL, 20, 1, 0, '2019-05-02T11:31:08.325+0000', NULL),
(17, NULL, 20, 0, 0, '2019-05-02T11:31:50.745+0000', NULL);

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
(1, 5),
(1, 10),
(2, 13),
(2, 14),
(3, 12),
(3, 14),
(4, 12),
(4, 13),
(5, 14),
(5, 15),
(6, 13),
(6, 15),
(7, 15),
(8, 15),
(8, 16),
(9, 14),
(9, 16),
(7, 16),
(10, 12),
(10, 17),
(7, 17),
(11, 5),
(11, 18),
(12, 11),
(12, 12),
(12, 10),
(13, 15),
(13, 19),
(14, 14),
(14, 19),
(7, 14),
(7, 13),
(15, 5),
(15, 10),
(15, 11),
(15, 15),
(16, 14),
(16, 20),
(17, 13),
(17, 14),
(17, 20),
(7, 20);

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
--
-- Dumping data for table `im_message`
--

INSERT INTO `im_message` (`m_id`, `sender`, `receiver`, `message`, `onlyemoji`, `type`, `fileName`, `link`, `linkData`, `receiver_type`, `date`, `time`, `date_time`) VALUES
(1, 10, 1, 'hi', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:05:45', '2019-04-24T19:05:45.785+0000'),
(2, 5, 1, 'hello 🙂', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:06:06', '2019-04-24T19:06:06.462+0000'),
(3, 10, 1, 'all good now?', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:06:24', '2019-04-24T19:06:24.246+0000'),
(4, 10, 1, 'lets chat here', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:06:44', '2019-04-24T19:06:44.206+0000'),
(5, 5, 1, 'hi', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:06:51', '2019-04-24T19:06:51.946+0000'),
(6, 5, 1, 'I\'m trying to sign up', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:06:59', '2019-04-24T19:06:59.080+0000'),
(7, 10, 1, 'ok', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:07:12', '2019-04-24T19:07:12.436+0000'),
(8, 10, 1, 'upload a file', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:08:13', '2019-04-24T19:08:13.446+0000'),
(9, 10, 1, '04242019190843imcds2C1.jpg', 0, 'image', '57366681_834271640258735_2719450949683773440_n.jpg', 'https://vyndue.com/assets/im/group_1/04242019190843imcds2C1.jpg', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_1/04242019190843imcds2C1.jpg\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_1%2F04242019190843imcds2C1.jpg\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":359,\"type\":\"jpg\",\"mime\":\"image/jpeg\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":36680,\"url\":\"https://vyndue.com/assets/im/group_1/04242019190843imcds2C1.jpg\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_1/04242019190843imcds2C1.jpg\"}}', 'personal', '2019-04-24', '07:08:43', '2019-04-24T19:08:43.856+0000'),
(10, 10, 1, 'https://www.youtube.com/watch?v=xnWCfchKYkQ', 0, 'text', NULL, 'https://www.youtube.com/watch?v=xnWCfchKYkQ', '{\"mainUrl\":\"https://www.youtube.com/watch?v=xnWCfchKYkQ\",\"host\":\"www.youtube.com\",\"title\":\"The WORST Product I\'ve ever LOVED - Nubia Alpha Wrist-phone\",\"description\":\"Check out the Massdrop Koss Porta Pro Headset at https://dro.ps/linustechtips-portapro Enter the Builds.GG contest at https://lmg.gg/buildsggcoolcontest The ...\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FxnWCfchKYkQ%2Fmaxresdefault.jpg\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"https://i.ytimg.com/vi/xnWCfchKYkQ/maxresdefault.jpg\"}}', 'personal', '2019-04-24', '19:09:13', '2019-04-24T19:09:13.406+0000'),
(11, 5, 1, 'why I can\'t login and Sign up 😞', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:09:38', '2019-04-24T19:09:38.856+0000'),
(12, 5, 1, 'cache is cleared already', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:09:45', '2019-04-24T19:09:45.050+0000'),
(13, 10, 1, 'clear the cache in my way', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:10:11', '2019-04-24T19:10:11.956+0000'),
(14, 10, 1, 'from where you are trying to login ?', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:11:22', '2019-04-24T19:11:22.656+0000'),
(15, 10, 1, 'ok', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:11:56', '2019-04-24T19:11:56.576+0000'),
(16, 5, 1, 'let me use other browser that doesn\'t have cache of previous chat', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:11:59', '2019-04-24T19:11:59.533+0000'),
(17, 10, 1, 'see. you didn\'t properly clear the cache', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:14:14', '2019-04-24T19:14:14.606+0000'),
(18, 10, 1, 'no 😄', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:15:14', '2019-04-24T19:15:14.456+0000'),
(19, 10, 1, 'since we update some js file and system file. those users who logged in previously need to clear the cache one time to continue', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:16:50', '2019-04-24T19:16:50.986+0000'),
(20, 10, 1, 'because browser store that old files in hdd and didn\'t download the fresh copy from server', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '19:17:59', '2019-04-24T19:17:59.346+0000'),
(21, 14, 2, 'Test message', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '23:53:16', '2019-04-24T23:53:16.077+0000'),
(22, 14, 3, 'Hi Bel', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '23:54:17', '2019-04-24T23:54:17.733+0000'),
(23, 13, 4, 'We are so happy Bel. We love you!!!!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '23:54:30', '2019-04-24T23:54:30.206+0000'),
(24, 14, 2, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '23:54:40', '2019-04-24T23:54:40.685+0000'),
(25, 14, 3, 'You are the man.', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '23:54:59', '2019-04-24T23:54:59.755+0000'),
(26, 14, 3, 'Naka tumbling nako', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '23:55:09', '2019-04-24T23:55:09.503+0000'),
(27, 13, 2, 'Test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-24', '23:58:50', '2019-04-24T23:58:50.092+0000'),
(28, 13, 2, '04242019235925im83mdU2.png', 0, 'image', 'Facebook Post (2).png', 'https://vyndue.com/assets/im/group_2/04242019235925im83mdU2.png', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_2/04242019235925im83mdU2.png\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_2%2F04242019235925im83mdU2.png\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":587,\"type\":\"png\",\"mime\":\"image/png\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":356037,\"url\":\"https://vyndue.com/assets/im/group_2/04242019235925im83mdU2.png\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_2/04242019235925im83mdU2.png\"}}', 'personal', '2019-04-24', '11:59:25', '2019-04-24T23:59:25.869+0000'),
(29, 13, 4, '04242019235949imWhrOZ4.png', 0, 'image', 'Facebook Post (2).png', 'https://vyndue.com/assets/im/group_4/04242019235949imWhrOZ4.png', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_4/04242019235949imWhrOZ4.png\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_4%2F04242019235949imWhrOZ4.png\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":587,\"type\":\"png\",\"mime\":\"image/png\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":356037,\"url\":\"https://vyndue.com/assets/im/group_4/04242019235949imWhrOZ4.png\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_4/04242019235949imWhrOZ4.png\"}}', 'personal', '2019-04-24', '11:59:49', '2019-04-24T23:59:49.379+0000'),
(30, 13, 4, 'Bel, how to create private groups?', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '00:00:49', '2019-04-25T00:00:49.159+0000'),
(31, 13, 2, 'Tony', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '00:06:24', '2019-04-25T00:06:24.851+0000'),
(32, 15, 5, 'Hi', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '03:50:56', '2019-04-25T03:50:56.136+0000'),
(33, 15, 6, 'Hi', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '03:51:17', '2019-04-25T03:51:17.469+0000'),
(34, 15, 6, '😃', 1, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '03:52:28', '2019-04-25T03:52:28.174+0000'),
(35, 15, 6, '0425201935620imyttAq6.jpg', 0, 'image', 'arbitrage-chart7.jpg', 'https://vyndue.com/assets/im/group_6/0425201935620imyttAq6.jpg', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_6/0425201935620imyttAq6.jpg\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_6%2F0425201935620imyttAq6.jpg\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":385,\"type\":\"jpg\",\"mime\":\"image/jpeg\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":57867,\"url\":\"https://vyndue.com/assets/im/group_6/0425201935620imyttAq6.jpg\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_6/0425201935620imyttAq6.jpg\"}}', 'personal', '2019-04-25', '03:56:20', '2019-04-25T03:56:20.861+0000'),
(36, 15, 6, 'https://www.youtube.com/watch?v=176QQsj0GFI', 0, 'text', NULL, 'https://www.youtube.com/watch?v=176QQsj0GFI', '{\"mainUrl\":\"https://www.youtube.com/watch?v=176QQsj0GFI\",\"host\":\"www.youtube.com\",\"title\":\"ExpertOption® Online Investments. Regulated and Secure Trading Platform.\",\"description\":\"https://r.expertoption.com/ Get $10.000 on demo account. Sell or buy stocks, currencies, oil from your mobile phone or desktop. Open account now ExpertOption...\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2F176QQsj0GFI%2Fmaxresdefault.jpg\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"https://i.ytimg.com/vi/176QQsj0GFI/maxresdefault.jpg\"}}', 'personal', '2019-04-25', '03:58:41', '2019-04-25T03:58:41.192+0000'),
(37, 15, 6, 'https://arbitrage.ph/', 0, 'text', NULL, 'https://arbitrage.ph', '{\"mainUrl\":\"https://arbitrage.ph\",\"host\":\"arbitrage.ph\",\"title\":\"Login | Arbitrage\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":null,\"type\":null,\"size\":null,\"mainUrl\":null}}', 'personal', '2019-04-25', '03:59:24', '2019-04-25T03:59:24.533+0000'),
(38, 15, 5, 'test video - https://www.youtube.com/watch?v=wq-gba5nMrc', 0, 'text', NULL, 'https://www.youtube.com/watch?v=wq-gba5nMrc', '{\"mainUrl\":\"https://www.youtube.com/watch?v=wq-gba5nMrc\",\"host\":\"www.youtube.com\",\"title\":\"Bill Gates\'s Top 10 Rules For Success (@BillGates)\",\"description\":\"Check out these books by and about Bill Gates: * Business @ the Speed of Thought: https://amzn.to/2PAw27v * The Road Ahead: https://amzn.to/2QfWPDh * Gates: ...\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2Fwq-gba5nMrc%2Fmaxresdefault.jpg\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"https://i.ytimg.com/vi/wq-gba5nMrc/maxresdefault.jpg\"}}', 'personal', '2019-04-25', '04:21:34', '2019-04-25T04:21:34.744+0000'),
(39, 15, 7, 'Group chat test 🏢', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '04:38:33', '2019-04-25T04:38:33.444+0000'),
(40, 15, 7, 'Test Video - https://www.youtube.com/watch?v=KiOgWjClYGs', 0, 'text', NULL, 'https://www.youtube.com/watch?v=KiOgWjClYGs', '{\"mainUrl\":\"https://www.youtube.com/watch?v=KiOgWjClYGs\",\"host\":\"www.youtube.com\",\"title\":\"15 Signs You’re Not Ready To Be RICH\",\"description\":\"15 Signs You’re Not Ready To Be Rich | Sunday Motivational Video SUBSCRIBE to ALUX: https://www.youtube.com/channel/UCNjPtOCvMrKY5eLwr_-7eUg?sub_confirmation...\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FKiOgWjClYGs%2Fmaxresdefault.jpg\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"https://i.ytimg.com/vi/KiOgWjClYGs/maxresdefault.jpg\"}}', 'group', '2019-04-25', '04:40:14', '2019-04-25T04:40:14.296+0000'),
(41, 15, 7, 'https://www.youtube.com/watch?v=LZv8KXNzxho', 0, 'text', NULL, 'https://www.youtube.com/watch?v=LZv8KXNzxho', '{\"mainUrl\":\"https://www.youtube.com/watch?v=LZv8KXNzxho\",\"host\":\"www.youtube.com\",\"title\":\"15 Things You Didn\'t Know About The CyberSecurity Industry\",\"description\":\"15 Things You Didn\'t Know About The CyberSecurity Industry | INDUSTRY WEEK SUBSCRIBE to ALUX: https://www.youtube.com/channel/UCNjPtOCvMrKY5eLwr_-7eUg?sub_co...\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FLZv8KXNzxho%2Fmaxresdefault.jpg\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"https://i.ytimg.com/vi/LZv8KXNzxho/maxresdefault.jpg\"}}', 'group', '2019-04-25', '04:40:37', '2019-04-25T04:40:37.343+0000'),
(42, 15, 7, '16 is added by 15', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-25', '05:31:30', '2019-04-25T05:31:30.484+0000'),
(43, 15, 7, 'Car, welcome', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '05:31:44', '2019-04-25T05:31:44.156+0000'),
(44, 16, 7, 'hahahah amazing!', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '05:32:43', '2019-04-25T05:32:43.995+0000'),
(45, 15, 7, '15 change the group name to Arbitrage Group', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-25', '05:32:57', '2019-04-25T05:32:57.781+0000'),
(46, 16, 8, 'Sir bel 🙂', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:40:05', '2019-04-25T05:40:05.262+0000'),
(47, 15, 8, 'yeah?', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:46:17', '2019-04-25T05:46:17.533+0000'),
(48, 15, 8, 'nice eto noh?', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:46:28', '2019-04-25T05:46:28.327+0000'),
(49, 16, 8, 'Yes kaayo power!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:46:47', '2019-04-25T05:46:47.083+0000'),
(50, 15, 8, 'naay ta mga features na ibutang, so avoid doing ang HTML changes', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:48:09', '2019-04-25T05:48:09.856+0000'),
(51, 15, 8, 'sa CSS lng gyud', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:48:17', '2019-04-25T05:48:17.191+0000'),
(52, 16, 8, 'yes noted sir', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:48:41', '2019-04-25T05:48:41.363+0000'),
(53, 16, 8, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:50:21', '2019-04-25T05:50:21.002+0000'),
(54, 16, 8, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:50:23', '2019-04-25T05:50:23.435+0000'),
(55, 16, 8, 'te', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:50:24', '2019-04-25T05:50:24.795+0000'),
(56, 16, 8, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '05:50:28', '2019-04-25T05:50:28.295+0000'),
(57, 15, 8, '💂', 1, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '06:08:37', '2019-04-25T06:08:37.330+0000'),
(58, 15, 8, '0425201960924imrW3zO8.png', 0, 'image', 'sample_ads_1.png', 'https://vyndue.com/assets/im/group_8/0425201960924imrW3zO8.png', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_8/0425201960924imrW3zO8.png\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_8%2F0425201960924imrW3zO8.png\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":584,\"type\":\"png\",\"mime\":\"image/png\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":273947,\"url\":\"https://vyndue.com/assets/im/group_8/0425201960924imrW3zO8.png\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_8/0425201960924imrW3zO8.png\"}}', 'personal', '2019-04-25', '06:09:24', '2019-04-25T06:09:24.650+0000'),
(59, 15, 8, 'https://www.youtube.com/', 0, 'text', NULL, 'https://www.youtube.com', '{\"mainUrl\":\"https://www.youtube.com\",\"host\":\"www.youtube.com\",\"title\":\"YouTube\",\"description\":\"Enjoy the videos and music you love, upload original content, and share it all with friends, family, and the world on YouTube.\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=%2Fyts%2Fimg%2Fyt_1200-vfl4C3T0K.png\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"/yts/img/yt_1200-vfl4C3T0K.png\"}}', 'personal', '2019-04-25', '06:09:45', '2019-04-25T06:09:45.957+0000'),
(60, 15, 8, 'https://www.youtube.com/watch?v=TcMBFSGVi1c', 0, 'text', NULL, 'https://www.youtube.com/watch?v=TcMBFSGVi1c', '{\"mainUrl\":\"https://www.youtube.com/watch?v=TcMBFSGVi1c\",\"host\":\"www.youtube.com\",\"title\":\"Marvel Studios\' Avengers: Endgame - Official Trailer\",\"description\":\"Whatever it takes. Watch the brand-new trailer for Marvel Studios’ Avengers: Endgame. In theaters April 26. ► Learn more: https://marvel.com/movies/avengers-...\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FTcMBFSGVi1c%2Fmaxresdefault.jpg\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"https://i.ytimg.com/vi/TcMBFSGVi1c/maxresdefault.jpg\"}}', 'personal', '2019-04-25', '06:10:12', '2019-04-25T06:10:12.865+0000'),
(61, 16, 8, 'sir ayaw sa hehehe', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '06:10:22', '2019-04-25T06:10:22.266+0000'),
(62, 15, 8, 'This chat is great!', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '06:10:25', '2019-04-25T06:10:25.555+0000'),
(63, 16, 8, 'nag test ko sa boxes hehehe', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '06:10:34', '2019-04-25T06:10:34.352+0000'),
(64, 16, 8, 'gane sir pawer kaayo', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '06:10:41', '2019-04-25T06:10:41.732+0000'),
(65, 15, 8, 'aw, hahahaha, ok cge', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '06:10:50', '2019-04-25T06:10:50.035+0000'),
(66, 14, 7, 'This is nice, Guys.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '06:45:33', '2019-04-25T06:45:33.965+0000'),
(67, 16, 9, 'testing lang sir 🙂', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:14:26', '2019-04-25T07:14:26.685+0000'),
(68, 14, 9, 'Hi Car', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:24:23', '2019-04-25T07:24:23.136+0000'),
(69, 14, 9, 'Twst', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:24:29', '2019-04-25T07:24:29.941+0000'),
(70, 14, 9, 'Test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:24:35', '2019-04-25T07:24:35.195+0000'),
(71, 14, 9, 'Ang mga icons ato pud ilisan', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:25:11', '2019-04-25T07:25:11.417+0000'),
(72, 14, 7, 'Bel, unsaon pag join sa group chat?', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '07:25:46', '2019-04-25T07:25:46.072+0000'),
(73, 14, 7, 'Unsaon pud pag disproved sa request', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '07:26:13', '2019-04-25T07:26:13.954+0000'),
(74, 14, 7, 'I am on mobile', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '07:26:32', '2019-04-25T07:26:32.872+0000'),
(75, 16, 9, 'gello sir po sir ilisi', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:26:38', '2019-04-25T07:26:38.445+0000'),
(76, 16, 9, 'ilisan nako na ron sir', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:26:59', '2019-04-25T07:26:59.505+0000'),
(77, 16, 9, 'wait lang sirah hehehe nag edit pako dili nako makita ang font color heheh', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '07:27:29', '2019-04-25T07:27:29.205+0000'),
(78, 15, 7, 'Wala pa ko kabalo, pero let us list the features na need nato, I will handle it', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '07:35:41', '2019-04-25T07:35:41.630+0000'),
(79, 14, 7, 'Okay, Bel.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '09:05:03', '2019-04-25T09:05:03.107+0000'),
(80, 14, 7, '😎', 1, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '09:14:02', '2019-04-25T09:14:02.892+0000'),
(81, 16, 7, '16 left the group.', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-25', '10:19:12', '2019-04-25T10:19:12.715+0000'),
(82, 14, 7, 'Monicar left the group.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '10:20:15', '2019-04-25T10:20:15.116+0000'),
(83, 13, 7, '16 is added by 13', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-25', '11:21:14', '2019-04-25T11:21:14.915+0000'),
(84, 16, 7, 'Yey! lihis ug click leave sir. Thanks maam.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '11:22:38', '2019-04-25T11:22:38.789+0000'),
(85, 13, 7, '😄', 1, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '11:26:29', '2019-04-25T11:26:29.803+0000'),
(86, 13, 7, '😄', 1, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '11:26:42', '2019-04-25T11:26:42.241+0000'),
(87, 13, 7, 'Test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '11:26:58', '2019-04-25T11:26:58.491+0000'),
(88, 13, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '11:27:00', '2019-04-25T11:27:00.513+0000'),
(89, 13, 7, 'this is a test message', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '11:27:06', '2019-04-25T11:27:06.817+0000'),
(90, 13, 7, '13 change the group name to Team Arbitrage', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-25', '11:27:20', '2019-04-25T11:27:20.522+0000'),
(91, 14, 7, 'test message', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-25', '11:50:28', '2019-04-25T11:50:28.977+0000'),
(92, 14, 3, 'Hi Bel', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '11:50:54', '2019-04-25T11:50:54.979+0000'),
(93, 14, 5, 'Hi Bel', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-25', '11:51:42', '2019-04-25T11:51:42.375+0000'),
(94, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-26', '05:20:52', '2019-04-26T05:20:52.583+0000'),
(95, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-26', '14:10:32', '2019-04-26T14:10:32.578+0000'),
(96, 14, 7, '04262019141920imzJshw7.jpg', 0, 'image', 'arbitrage-chart7.jpg', 'https://vyndue.com/assets/im/group_7/04262019141920imzJshw7.jpg', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04262019141920imzJshw7.jpg\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_7%2F04262019141920imzJshw7.jpg\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":385,\"type\":\"jpg\",\"mime\":\"image/jpeg\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":57867,\"url\":\"https://vyndue.com/assets/im/group_7/04262019141920imzJshw7.jpg\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04262019141920imzJshw7.jpg\"}}', 'group', '2019-04-26', '02:19:20', '2019-04-26T14:19:20.570+0000'),
(97, 14, 7, 'let us achieve this.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-26', '14:19:57', '2019-04-26T14:19:57.164+0000'),
(98, 17, 10, 'hey', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-27', '03:59:01', '2019-04-27T03:59:01.311+0000'),
(99, 15, 7, '17 is added by 15', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-27', '03:59:38', '2019-04-27T03:59:38.804+0000'),
(100, 15, 7, 'Arp', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-27', '03:59:52', '2019-04-27T03:59:52.694+0000'),
(101, 17, 7, 'maydag!', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-27', '04:00:37', '2019-04-27T04:00:37.090+0000'),
(102, 15, 7, 'dfgdgdfg', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-27', '04:00:44', '2019-04-27T04:00:44.312+0000'),
(103, 17, 7, 'okie lageh', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-27', '04:00:44', '2019-04-27T04:00:44.922+0000'),
(104, 17, 7, 'may gad!', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-27', '04:00:47', '2019-04-27T04:00:47.868+0000'),
(105, 15, 7, 'tttttttttttttt', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-27', '10:07:59', '2019-04-27T10:07:59.156+0000'),
(106, 15, 7, 'jjhjhjhjhjhjhjhhjh', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-27', '10:33:15', '2019-04-27T10:33:15.792+0000'),
(107, 18, 11, 'aas', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-28', '09:03:16', '2019-04-28T09:03:16.120+0000'),
(108, 18, 11, '0428201990337imPtzws11.jpg', 0, 'image', 'temp.jpg', 'https://vyndue.com/assets/im/group_11/0428201990337imPtzws11.jpg', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_11/0428201990337imPtzws11.jpg\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_11%2F0428201990337imPtzws11.jpg\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":684,\"type\":\"jpg\",\"mime\":\"image/jpeg\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":52478,\"url\":\"https://vyndue.com/assets/im/group_11/0428201990337imPtzws11.jpg\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_11/0428201990337imPtzws11.jpg\"}}', 'personal', '2019-04-28', '09:03:37', '2019-04-28T09:03:37.355+0000'),
(109, 18, 11, 'i love you', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-28', '09:03:51', '2019-04-28T09:03:51.355+0000'),
(110, 18, 11, 'do you love me bby', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-28', '09:03:55', '2019-04-28T09:03:55.753+0000'),
(111, 18, 11, '😉😭', 1, 'text', NULL, NULL, NULL, 'personal', '2019-04-28', '09:05:04', '2019-04-28T09:05:04.449+0000'),
(112, 10, 12, 'hello', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '04:22:41', '2019-04-29T04:22:41.701+0000'),
(113, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '05:50:17', '2019-04-29T05:50:17.383+0000'),
(114, 14, 7, 'teset', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '09:03:30', '2019-04-29T09:03:30.510+0000'),
(115, 15, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '09:06:24', '2019-04-29T09:06:24.670+0000'),
(116, 14, 7, 'message for allan', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '09:06:41', '2019-04-29T09:06:41.593+0000'),
(117, 15, 5, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:19:44', '2019-04-29T11:19:44.608+0000'),
(118, 15, 5, 'new message from me', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:20:24', '2019-04-29T11:20:24.822+0000'),
(119, 15, 7, 'test message group', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '11:20:43', '2019-04-29T11:20:43.039+0000'),
(120, 15, 5, 'test 1', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:28:07', '2019-04-29T11:28:07.276+0000'),
(121, 15, 7, 'Test 2', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '11:28:12', '2019-04-29T11:28:12.614+0000'),
(122, 14, 7, 'tset', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '11:28:32', '2019-04-29T11:28:32.851+0000'),
(123, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '11:28:47', '2019-04-29T11:28:47.472+0000'),
(124, 14, 5, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:29:24', '2019-04-29T11:29:24.351+0000'),
(125, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '11:29:41', '2019-04-29T11:29:41.008+0000'),
(126, 15, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '11:30:10', '2019-04-29T11:30:10.269+0000'),
(127, 14, 7, '14 left the group.', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-29', '11:31:25', '2019-04-29T11:31:25.369+0000'),
(128, 15, 6, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:33:10', '2019-04-29T11:33:10.364+0000'),
(129, 19, 13, 'Hi sir', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:36:03', '2019-04-29T11:36:03.546+0000'),
(130, 19, 14, 'Hello sir', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:36:52', '2019-04-29T11:36:52.672+0000'),
(131, 14, 14, 'Ayos', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-29', '11:37:09', '2019-04-29T11:37:09.416+0000'),
(132, 15, 7, '14 is added by 15', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-29', '11:38:43', '2019-04-29T11:38:43.014+0000'),
(133, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '12:06:56', '2019-04-29T12:06:56.983+0000'),
(134, 14, 7, '😍', 1, 'text', NULL, NULL, NULL, 'group', '2019-04-29', '13:25:03', '2019-04-29T13:25:03.103+0000'),
(135, 15, 7, '13 is removed by 15', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-29', '05:34:37', '2019-04-29T17:34:37.600+0000'),
(136, 15, 7, '13 is added by 15', 0, 'update', NULL, NULL, NULL, 'group', '2019-04-29', '10:16:31', '2019-04-29T22:16:31.214+0000'),
(137, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '02:52:50', '2019-04-30T02:52:50.069+0000'),
(138, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '02:58:11', '2019-04-30T02:58:11.084+0000'),
(139, 14, 14, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '02:58:20', '2019-04-30T02:58:20.978+0000'),
(140, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '03:22:11', '2019-04-30T03:22:11.085+0000'),
(141, 14, 7, 'delayed ang sending sa message Bel.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '03:22:48', '2019-04-30T03:22:48.990+0000'),
(142, 14, 7, 'test 2', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '07:14:25', '2019-04-30T07:14:25.375+0000'),
(143, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '07:14:31', '2019-04-30T07:14:31.181+0000'),
(144, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '07:14:32', '2019-04-30T07:14:32.445+0000'),
(145, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '07:57:26', '2019-04-30T07:57:26.981+0000'),
(146, 15, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '09:22:50', '2019-04-30T09:22:50.879+0000'),
(147, 15, 7, 'test for a bunch of text - Sed mattis id justo non volutpat. In sed neque felis. Donec eget egestas sem. Fusce bibendum lectus quis purus auctor porta. Sed eros est, elementum eget erat quis, finibus condimentum arcu. Proin rhoncus odio dui, id pharetra turpis vestibulum ut. Fusce lectus quam, eleifend vel dictum in, volutpat eu nisi. Praesent a ullamcorper dui. Nunc scelerisque lobortis mauris, quis commodo enim laoreet eget. Maecenas elit magna, pretium in bibendum vel, scelerisque ac justo. Sed nibh erat, vehicula iaculis vestibulum non, lobortis ut purus. Nullam feugiat ut justo in ornare. Phasellus at posuere diam. Sed semper auctor venenatis. Aliquam erat volutpat. Aliquam faucibus ligula et justo tempus, at ultricies risus egestas.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '09:24:15', '2019-04-30T09:24:15.080+0000'),
(148, 15, 7, '0430201992513imf8IOM7.txt', 0, 'document', 'pass.txt', 'https://vyndue.com/download?f=assets/im/group_7/0430201992513imf8IOM7.txt&fn=pass.txt', '{\"mainUrl\":\"https://vyndue.com/download?f=assets/im/group_7/0430201992513imf8IOM7.txt&fn=pass.txt\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":null,\"type\":null,\"size\":null,\"mainUrl\":null}}', 'group', '2019-04-30', '09:25:13', '2019-04-30T09:25:13.515+0000'),
(149, 15, 7, '0430201992600imiyOUn7.txt', 0, 'document', 'arbotrage.txt', 'https://vyndue.com/download?f=assets/im/group_7/0430201992600imiyOUn7.txt&fn=arbotrage.txt', '{\"mainUrl\":\"https://vyndue.com/download?f=assets/im/group_7/0430201992600imiyOUn7.txt&fn=arbotrage.txt\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":null,\"type\":null,\"size\":null,\"mainUrl\":null}}', 'group', '2019-04-30', '09:26:00', '2019-04-30T09:26:00.282+0000'),
(150, 14, 7, 'working properly now?', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '11:14:39', '2019-04-30T11:14:39.634+0000'),
(151, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '13:21:40', '2019-04-30T13:21:40.731+0000'),
(152, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '13:22:55', '2019-04-30T13:22:55.845+0000'),
(153, 14, 7, 'this is a test message', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '13:23:41', '2019-04-30T13:23:41.366+0000'),
(154, 15, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:34:37', '2019-04-30T14:34:37.535+0000'),
(155, 15, 7, 'test 1', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:37:49', '2019-04-30T14:37:49.823+0000'),
(156, 15, 13, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '14:38:48', '2019-04-30T14:38:48.960+0000'),
(157, 15, 13, 'test 1', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '14:43:37', '2019-04-30T14:43:37.478+0000'),
(158, 15, 7, 'test 1', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:44:45', '2019-04-30T14:44:45.936+0000'),
(159, 15, 7, 'Test 2', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:45:01', '2019-04-30T14:45:01.517+0000'),
(160, 15, 7, 'test 1', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:49:05', '2019-04-30T14:49:05.461+0000'),
(161, 15, 7, 'today lang ni na problem vin noh', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:49:50', '2019-04-30T14:49:50.375+0000'),
(162, 14, 7, 'late gud nag abot imong messages bel.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:51:50', '2019-04-30T14:51:50.304+0000'),
(163, 14, 7, 'sabay sabay pa jud tanan.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:51:56', '2019-04-30T14:51:56.413+0000'),
(164, 14, 7, 'Tapos ang group pic, dili sya constant.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:52:12', '2019-04-30T14:52:12.386+0000'),
(165, 15, 7, 'gina troubleshoot nako karon', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:52:19', '2019-04-30T14:52:19.123+0000'),
(166, 14, 7, 'Okay.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:52:25', '2019-04-30T14:52:25.563+0000'),
(167, 14, 7, 'kani atong right side, bel. compress pa nato ha.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:52:36', '2019-04-30T14:52:36.763+0000'),
(168, 14, 7, 'daku ra ang spacing.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:52:46', '2019-04-30T14:52:46.173+0000'),
(169, 14, 7, 'same as sa left side.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:52:52', '2019-04-30T14:52:52.637+0000'),
(170, 15, 7, 'noted vin', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:53:13', '2019-04-30T14:53:13.916+0000'),
(171, 14, 7, '04302019145428imGeQgu7.png', 0, 'image', 'Screen Shot 2019-04-30 at 10.54.17 PM.png', 'https://vyndue.com/assets/im/group_7/04302019145428imGeQgu7.png', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019145428imGeQgu7.png\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_7%2F04302019145428imGeQgu7.png\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":151,\"type\":\"png\",\"mime\":\"image/png\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":44404,\"url\":\"https://vyndue.com/assets/im/group_7/04302019145428imGeQgu7.png\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019145428imGeQgu7.png\"}}', 'group', '2019-04-30', '02:54:28', '2019-04-30T14:54:28.150+0000'),
(172, 14, 7, 'lets remove the logo nalang on this part Bel.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:54:40', '2019-04-30T14:54:40.515+0000'),
(173, 14, 7, 'retain only the text.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:54:45', '2019-04-30T14:54:45.114+0000'),
(174, 14, 7, 'naa na man pud logo on the left side list.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:54:56', '2019-04-30T14:54:56.779+0000'),
(175, 15, 7, 'troubleshooting 4', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '14:58:11', '2019-04-30T14:58:11.388+0000'),
(176, 15, 7, 'l', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:09:45', '2019-04-30T15:09:45.713+0000'),
(177, 15, 7, 'troubleshooting 0001', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:10:02', '2019-04-30T15:10:02.283+0000'),
(178, 14, 7, '.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:18:22', '2019-04-30T15:18:22.376+0000'),
(179, 15, 13, 'hello', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '15:18:44', '2019-04-30T15:18:44.694+0000'),
(180, 15, 13, 'test 1', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '15:19:38', '2019-04-30T15:19:38.895+0000'),
(181, 15, 13, 'test 2', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '15:19:41', '2019-04-30T15:19:41.220+0000'),
(182, 15, 13, 'test 3', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '15:19:43', '2019-04-30T15:19:43.934+0000'),
(183, 15, 7, 'Vin', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:19:52', '2019-04-30T15:19:52.566+0000'),
(184, 15, 7, 'na fix na', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:19:57', '2019-04-30T15:19:57.901+0000'),
(185, 15, 7, 'pero gibalik usa nko tong image ug name sa sidebar', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:20:23', '2019-04-30T15:20:23.758+0000'),
(186, 14, 7, 'Yes', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:20:38', '2019-04-30T15:20:38.760+0000'),
(187, 14, 7, 'pansin nimo ng question mark na nagawas? pwede tangalon pud na sya, Bel?', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:20:58', '2019-04-30T15:20:58.314+0000'),
(188, 15, 7, 'hello', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:21:09', '2019-04-30T15:21:09.655+0000'),
(189, 14, 7, '04302019152125imAowu07.png', 0, 'image', 'Screen Shot 2019-04-30 at 11.21.15 PM.png', 'https://vyndue.com/assets/im/group_7/04302019152125imAowu07.png', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019152125imAowu07.png\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_7%2F04302019152125imAowu07.png\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":64,\"type\":\"png\",\"mime\":\"image/png\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":32289,\"url\":\"https://vyndue.com/assets/im/group_7/04302019152125imAowu07.png\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019152125imAowu07.png\"}}', 'group', '2019-04-30', '03:21:25', '2019-04-30T15:21:25.008+0000'),
(190, 15, 7, 'got it', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:21:34', '2019-04-30T15:21:34.585+0000'),
(191, 14, 7, 'tapos pwede align nalng ni', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:21:35', '2019-04-30T15:21:35.060+0000'),
(192, 15, 7, 'yes, on it now', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:22:33', '2019-04-30T15:22:33.621+0000'),
(193, 14, 7, 'mas better ba if we start communicating here?', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:24:21', '2019-04-30T15:24:21.155+0000'),
(194, 15, 7, 'wag muna, kasi meron mga core edits ako gina touch', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:24:46', '2019-04-30T15:24:46.171+0000'),
(195, 14, 7, 'okay.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:24:58', '2019-04-30T15:24:58.544+0000'),
(196, 14, 7, '04302019152515imfn7uW7.png', 0, 'image', 'Screen Shot 2019-04-30 at 11.25.05 PM.png', 'https://vyndue.com/assets/im/group_7/04302019152515imfn7uW7.png', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019152515imfn7uW7.png\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_7%2F04302019152515imfn7uW7.png\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":107,\"type\":\"png\",\"mime\":\"image/png\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":30533,\"url\":\"https://vyndue.com/assets/im/group_7/04302019152515imfn7uW7.png\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019152515imfn7uW7.png\"}}', 'group', '2019-04-30', '03:25:15', '2019-04-30T15:25:15.955+0000'),
(197, 14, 7, 'kanang blue line pud.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:25:35', '2019-04-30T15:25:35.920+0000'),
(198, 14, 7, '04302019152600imQAP0c7.png', 0, 'image', 'Screen Shot 2019-04-30 at 11.25.47 PM.png', 'https://vyndue.com/assets/im/group_7/04302019152600imQAP0c7.png', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019152600imQAP0c7.png\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_7%2F04302019152600imQAP0c7.png\",\"type\":\"file\",\"size\":{\"width\":700,\"height\":601,\"type\":\"png\",\"mime\":\"image/png\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":360383,\"url\":\"https://vyndue.com/assets/im/group_7/04302019152600imQAP0c7.png\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019152600imQAP0c7.png\"}}', 'group', '2019-04-30', '03:26:00', '2019-04-30T15:26:00.387+0000'),
(199, 14, 7, 'distorted ang mga images because sa zoom during hover.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:26:18', '2019-04-30T15:26:18.680+0000'),
(200, 14, 7, 'normal lang siguro dapat ni. wala na zoom effect.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:26:36', '2019-04-30T15:26:36.212+0000'),
(201, 15, 7, 'yeah, napansin nako, pero naa na ko solution', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:27:01', '2019-04-30T15:27:01.743+0000'),
(202, 14, 7, 'Ayos.', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:27:10', '2019-04-30T15:27:10.152+0000'),
(203, 15, 7, 'beyond na man gyud ni sa akong skill set, hehehehe, pero I\'m still trying 😃', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:27:39', '2019-04-30T15:27:39.651+0000'),
(204, 14, 7, 'hehehe', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:28:05', '2019-04-30T15:28:05.248+0000'),
(205, 14, 7, 'you know more than you think. 🙂', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:28:28', '2019-04-30T15:28:28.571+0000'),
(206, 15, 7, 'hello', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:32:34', '2019-04-30T15:32:34.088+0000'),
(207, 15, 15, 'hi', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:32:52', '2019-04-30T15:32:52.855+0000'),
(208, 15, 15, 'test 1', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:35:50', '2019-04-30T15:35:50.504+0000'),
(209, 15, 15, 'test 1', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:38:03', '2019-04-30T15:38:03.422+0000'),
(210, 15, 15, 'test 2', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:38:05', '2019-04-30T15:38:05.546+0000'),
(211, 15, 15, 'test 3', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:38:08', '2019-04-30T15:38:08.955+0000'),
(212, 15, 15, 'hello', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:41:16', '2019-04-30T15:41:16.497+0000'),
(213, 15, 15, 'it is now ok', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:42:07', '2019-04-30T15:42:07.284+0000'),
(214, 15, 15, '😥', 1, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:42:25', '2019-04-30T15:42:25.508+0000'),
(215, 15, 15, 'iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:42:33', '2019-04-30T15:42:33.498+0000'),
(216, 15, 15, 'https://media.giphy.com/media/kfpl7HUfm4YWeIS56b/giphy.gif', 0, 'text', NULL, 'https://media.giphy.com/media/kfpl7HUfm4YWeIS56b/giphy.gif', '{\"mainUrl\":\"https://media.giphy.com/media/kfpl7HUfm4YWeIS56b/giphy.gif\",\"host\":\"media.giphy.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fmedia.giphy.com%2Fmedia%2Fkfpl7HUfm4YWeIS56b%2Fgiphy.gif\",\"type\":\"file\",\"size\":{\"width\":480,\"height\":480,\"type\":\"gif\",\"mime\":\"image/gif\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":8103335,\"url\":\"https://media.giphy.com/media/kfpl7HUfm4YWeIS56b/giphy.gif\"},\"mainUrl\":\"https://media.giphy.com/media/kfpl7HUfm4YWeIS56b/giphy.gif\"}}', 'group', '2019-04-30', '15:44:08', '2019-04-30T15:44:08.078+0000'),
(217, 15, 15, '😂', 1, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:44:31', '2019-04-30T15:44:31.746+0000'),
(218, 15, 15, '😀', 1, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:44:51', '2019-04-30T15:44:51.697+0000'),
(219, 15, 15, 'https://media.giphy.com/media/KFPkdLLtI90lAPc4SP/giphy.gif', 0, 'text', NULL, 'https://media.giphy.com/media/KFPkdLLtI90lAPc4SP/giphy.gif', '{\"mainUrl\":\"https://media.giphy.com/media/KFPkdLLtI90lAPc4SP/giphy.gif\",\"host\":\"media.giphy.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fmedia.giphy.com%2Fmedia%2FKFPkdLLtI90lAPc4SP%2Fgiphy.gif\",\"type\":\"file\",\"size\":{\"width\":478,\"height\":350,\"type\":\"gif\",\"mime\":\"image/gif\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":1214670,\"url\":\"https://media.giphy.com/media/KFPkdLLtI90lAPc4SP/giphy.gif\"},\"mainUrl\":\"https://media.giphy.com/media/KFPkdLLtI90lAPc4SP/giphy.gif\"}}', 'group', '2019-04-30', '15:45:40', '2019-04-30T15:45:40.742+0000'),
(220, 15, 15, 'https://www.youtube.com/watch?v=IeH0DW1VHBA', 0, 'text', NULL, 'https://www.youtube.com/watch?v=IeH0DW1VHBA', '{\"mainUrl\":\"https://www.youtube.com/watch?v=IeH0DW1VHBA\",\"host\":\"www.youtube.com\",\"title\":\"Tom and Jerry, Episode 155 Rock \'n\' Rodent 1967 P1\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fi.ytimg.com%2Fvi%2FIeH0DW1VHBA%2Fhqdefault.jpg\",\"type\":\"image\",\"size\":null,\"mainUrl\":\"https://i.ytimg.com/vi/IeH0DW1VHBA/hqdefault.jpg\"}}', 'group', '2019-04-30', '15:46:32', '2019-04-30T15:46:32.103+0000'),
(221, 15, 7, 'test after mod2', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:53:03', '2019-04-30T15:53:03.025+0000'),
(222, 15, 7, 'test after mod 3', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:53:07', '2019-04-30T15:53:07.582+0000'),
(223, 15, 7, 'all goo', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:53:10', '2019-04-30T15:53:10.247+0000'),
(224, 15, 7, 'd', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '15:53:12', '2019-04-30T15:53:12.583+0000'),
(225, 15, 7, '04302019155642imTpCIh7.mp4', 0, 'video', 'Poets of the Fall - Late Goodbye.mp4', 'https://vyndue.com/assets/im/group_7/04302019155642imTpCIh7.mp4', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019155642imTpCIh7.mp4\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":null,\"type\":null,\"size\":null,\"mainUrl\":null}}', 'group', '2019-04-30', '03:56:42', '2019-04-30T15:56:42.163+0000'),
(226, 15, 7, '04302019155700imYWmK17.jpg', 0, 'image', '41105500_2247046655529297_3675306104776032256_n.jpg', 'https://vyndue.com/assets/im/group_7/04302019155700imYWmK17.jpg', '{\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019155700imYWmK17.jpg\",\"host\":\"vyndue.com\",\"title\":\"\",\"description\":\"\",\"playerOrImageUrl\":{\"url\":\"https://vyndue.com/image?u=https%3A%2F%2Fvyndue.com%2Fassets%2Fim%2Fgroup_7%2F04302019155700imYWmK17.jpg\",\"type\":\"file\",\"size\":{\"width\":525,\"height\":700,\"type\":\"jpg\",\"mime\":\"image/jpeg\",\"wUnits\":\"px\",\"hUnits\":\"px\",\"length\":106242,\"url\":\"https://vyndue.com/assets/im/group_7/04302019155700imYWmK17.jpg\"},\"mainUrl\":\"https://vyndue.com/assets/im/group_7/04302019155700imYWmK17.jpg\"}}', 'group', '2019-04-30', '03:57:00', '2019-04-30T15:57:00.559+0000'),
(227, 15, 15, 'test message 1', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '16:20:31', '2019-04-30T16:20:31.880+0000'),
(228, 15, 15, 'test message 2', 0, 'text', NULL, NULL, NULL, 'group', '2019-04-30', '16:20:36', '2019-04-30T16:20:36.620+0000'),
(229, 15, 5, 'test 1', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '16:54:45', '2019-04-30T16:54:45.663+0000'),
(230, 15, 5, 'test 2', 0, 'text', NULL, NULL, NULL, 'personal', '2019-04-30', '16:54:49', '2019-04-30T16:54:49.210+0000'),
(231, 14, 5, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-01', '02:06:45', '2019-05-01T02:06:45.774+0000'),
(232, 14, 7, '.', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-01', '14:35:29', '2019-05-01T14:35:29.445+0000'),
(233, 20, 16, 'test', 0, 'text', NULL, NULL, NULL, 'personal', '2019-05-02', '11:31:08', '2019-05-02T11:31:08.325+0000'),
(234, 20, 17, 'test group', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-02', '11:31:50', '2019-05-02T11:31:50.745+0000'),
(235, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-02', '13:19:56', '2019-05-02T13:19:56.819+0000'),
(236, 14, 7, 'test', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-02', '13:20:00', '2019-05-02T13:20:00.300+0000'),
(237, 14, 7, 'abeeeeeeeelllll', 0, 'text', NULL, NULL, NULL, 'group', '2019-05-02', '13:20:05', '2019-05-02T13:20:05.504+0000'),
(238, 14, 7, '20 is added by 14', 0, 'update', NULL, NULL, NULL, 'group', '2019-05-02', '01:20:37', '2019-05-02T13:20:37.477+0000');

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
--
-- Dumping data for table `im_receiver`
--

INSERT INTO `im_receiver` (`g_id`, `m_id`, `r_id`, `received`, `announced`, `time`) VALUES
(1, 20, 5, 1, 1, '2019-04-24T19:17:59.346+0000'),
(4, 30, 12, 1, 1, '2019-04-25T04:15:46.569+0000'),
(2, 31, 14, 1, 1, '2019-04-25T00:06:24.851+0000'),
(8, 65, 16, 1, 1, '2019-04-25T06:10:50.035+0000'),
(9, 77, 14, 1, 1, '2019-04-25T11:50:33.968+0000'),
(3, 92, 12, 0, 0, '2019-04-25T11:50:54.979+0000'),
(10, 98, 12, 0, 0, '2019-04-27T03:59:01.311+0000'),
(11, 111, 5, 0, 0, '2019-04-28T09:05:04.449+0000'),
(12, 112, 11, 0, 0, '2019-04-29T04:22:41.701+0000'),
(12, 112, 12, 0, 0, '2019-04-29T04:22:41.701+0000'),
(6, 128, 13, 0, 0, '2019-04-29T11:33:10.364+0000'),
(14, 139, 14, 1, 1, '2019-04-30T02:58:21.195+0000'),
(14, 139, 19, 0, 0, '2019-04-30T02:58:20.978+0000'),
(13, 182, 15, 1, 1, '2019-04-30T15:19:44.099+0000'),
(13, 182, 19, 0, 0, '2019-04-30T15:19:43.934+0000'),
(15, 228, 5, 0, 0, '2019-04-30T16:20:36.620+0000'),
(15, 228, 10, 0, 0, '2019-04-30T16:20:36.620+0000'),
(15, 228, 11, 0, 0, '2019-04-30T16:20:36.620+0000'),
(5, 231, 15, 1, 1, '2019-05-02T06:14:41.872+0000'),
(16, 233, 14, 0, 0, '2019-05-02T11:31:08.325+0000'),
(17, 234, 13, 0, 0, '2019-05-02T11:31:50.745+0000'),
(17, 234, 14, 1, 1, '2019-05-02T12:05:22.252+0000'),
(7, 237, 15, 1, 1, '2019-05-02T13:20:05.504+0000'),
(7, 237, 16, 0, 0, '2019-05-02T13:20:05.504+0000'),
(7, 237, 17, 0, 0, '2019-05-02T13:20:05.504+0000'),
(7, 237, 13, 0, 0, '2019-05-02T13:20:05.504+0000'),
(7, 237, 20, 1, 1, '2019-05-02T14:34:51.101+0000');

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
(5, 'JshJCcMYm3Hid5tY6hP8cXoXjmQHbbfQm6Pup75FQx5cVq4qGrsCxoh7wuWV', 'WvIh9EBf3oGeLavLAAAK', '2019-04-30T15:41:53.937+0000', '2019-04-29T19:04:44.090+0000'),
(5, 'JueApgNq1cAKHA0vAGN9v3oetKyeL71CEmReWNWJbp86NCOlseq9LDArTz6m', 'InK2RdK2I4sRziXVAAAL', '2019-04-30T15:41:53.937+0000', '2019-04-29T19:05:28.433+0000'),
(12, 'axctTidIaBnjbfcVVsUXHnMaPeuShwGjx73RT1i7fc63KOpRJt55uUFR9CEm', 'J21PB6F6tiap9MfJAADs', '2019-05-01T15:50:37.535+0000', '2019-05-06T14:45:34.897+0000'),
(14, 'G1BUi0q6AoKKJ3sSfAApG9DHRDsM2OBdtLKzc5DeJEjvn3vbcpNn1UzwzMDT', '23B5qWTxDj0iANLGAADx', '2019-05-01T15:28:26.981+0000', '2019-05-06T15:12:59.966+0000'),
(15, 'Cvpkru43ybadLcAoDoEY4Y9Wo8xEnvzXSvOWmPxso50KKxLED39xE6gzM3Us', 'M-E17_x-kJStzO3mAAA9', '2019-04-30T15:41:53.937+0000', '2019-04-30T04:45:35.233+0000'),
(15, 'tJ0DLaQhIq92AIqBpYr9mSWaFPPTddEd21kIMggmm2DG33LPps0dJQDyuL1n', 'P4GMVmh7SJBjmuXhAADh', '2019-04-30T15:41:53.937+0000', '2019-04-30T09:10:13.391+0000'),
(14, 'Nv427xU7nufn356wdnick4Dywrf7wWGI0WSif5sBLpnjjxTDHK3yGMI7DMd2', '8SEfEVgoSJxR4brgAAB2', '2019-04-30T15:41:53.937+0000', '2019-04-30T06:55:36.830+0000'),
(14, 'OfBYTgdKAemOpGeAAw91XCgnkNh4jaEtNyFi22vGiA7C7yI7RuPvfOXnLVQ4', 'aU1d6sv2Ik3_GdXPAACQ', '2019-04-30T15:41:53.937+0000', '2019-04-30T07:25:21.632+0000'),
(14, 'OXjQnHrhTwJ3o9RJovEWxpazVIwFbd3XNa47s21mCnRF7K1eVg2SH1dydcYI', 'vSeXCUaZELQQ56QgAADj', '2019-04-30T15:41:53.937+0000', '2019-04-30T09:11:34.802+0000'),
(14, 'Wl7vhqIJbpiYBV1SmS31pPpoAhexDecYGNxiyWIubcpveA0asp5e2VpDXxA3', 'idUE7BlMbbjQnf_UAADn', '2019-04-30T15:41:53.937+0000', '2019-04-30T09:14:59.493+0000'),
(15, 'B2JNYonlU0t1f54Inx9mGUABIMpDGs0ViXlmICDwlqInTiVfxkYiycSgi9Tt', '-3fC_3cldOOJX8tMAAGU', '2019-04-30T15:41:53.937+0000', '2019-04-30T19:34:56.597+0000'),
(14, 'uaDoe3nNuKoEy3kc9yS2U7J5dhPpfnF6hCMGs48CEzDfG2k8bHpGOswwf24K', 'OH6hhPlJxRFqRy4vAAEF', '2019-04-30T15:41:53.937+0000', '2019-04-30T10:20:56.113+0000'),
(14, '2a7pcGX0RJ0u7bkh8kfKSAqfR0LQ76CGPabxoeFw2tcAC5ncarY2Pb61sMad', '7bofRwgwHis3yCUqAAEq', '2019-05-02T12:34:33.357+0000', '2019-05-08T06:27:18.409+0000'),
(15, 'DD8QrhSQDBorzTDjG83xAo7XllVDsMoh0oBfVTWLOd0kQI1hoxWzq1dAmCxd', 'ONwED5FQdhiZJApMAABs', '2019-04-30T16:55:02.316+0000', '2019-05-05T16:54:22.312+0000'),
(14, 'apT56CJ1b1kH5A4Bbfrd2w6G9psXib8ieOgWIn6ex8U0TGFVocOesPK5el6F', 'u_ntP1nH9GH0uBiXAAGD', '2019-04-30T15:41:53.937+0000', '2019-04-30T17:14:37.030+0000'),
(15, 'e6nsAkYSdhiO8RLnTTLQRWNkPYxml8U0gzqWGz0U6igxTQ65p6KgtJoALzFa', 'DO1golzzhUaNLd2wAAGl', '2019-04-30T15:41:53.937+0000', '2019-05-01T04:28:06.538+0000'),
(17, 'nyLqvuzCXlk6Ff27onadx4niXGlckY1tmb9wQuFYlP98cpiXpGAdLEAUAfnj', '4AHjryewcCKBi9LbAAIe', '2019-04-30T15:41:53.937+0000', '2019-05-02T06:17:40.129+0000'),
(15, 'X3YcDdjrBLtHytdVARMw7NUXKTw6CMpE3oYe83M8DUl9GYWjkiz0tiXqy4ON', 'I1TpxmlCMOZPcKMdAABO', '2019-04-30T15:41:53.937+0000', '2019-05-04T11:44:51.508+0000'),
(18, '9WKW4k9yOPdmz2PFGn6K16QaqqefhBSM8rXSy9lcp7wx1XWJ4ixx2brXXg6o', 'B2W_mAAdTWaow_rHAAI6', '2019-04-30T15:41:53.937+0000', '2019-05-03T09:04:40.488+0000'),
(10, '1R2oRY3wO1c9yhoxRKSm2CK4SU6vYa8DQL24YfyFusumhlCfX2pPiwaC2Y2B', '7iX1MOZdeFYLthbyAAJN', '2019-04-30T15:41:53.937+0000', '2019-05-04T04:24:38.791+0000'),
(10, 'qS1ACeSHB8v8hLs6gnhYUsxOgbAzJ2EyRWPjY1db3GjKjQce1jonyuUADK2P', 'OBHXbeJB9jYX38I4AAJO', '2019-04-30T15:41:53.937+0000', '2019-05-04T04:25:21.435+0000'),
(19, 'mzlojpNR5TWNO5Tar1Q9xFKDrQi0X5a3sfoxFESOSmxTbKLWpSAUmfsYKEzG', 'CWZ_qjBYWpDUweOzAACX', '2019-04-30T15:41:53.937+0000', '2019-05-04T12:50:23.495+0000'),
(15, 'pp0fiATSX1Uw3cDKyUa1wHOzuFz4GcX8Of9RB6rIqjkFieJtJPzUg61lKloQ', 'uAJKepeJGs_02MzPAAEn', '2019-05-02T19:08:49.306+0000', '2019-05-07T19:08:30.651+0000'),
(15, '3qeQ8oqPfQq6MsjyR3pDNnN3aFTFH5YjKVjhwme8RVTdTAvQyCM4nIuaWeyE', 'Yt2hOgpE_7Bunj6yAAAs', '2019-04-30T16:25:34.890+0000', '2019-05-05T16:11:49.109+0000'),
(20, '8HPyFOYD9O0BAgr1brKpnanPwDvBGmYDJNobPAEHEMpTvmSXytEcNtLCB1Hq', '7j9nzKsY1sAPFfBtAAEp', '2019-05-03T01:06:20.530+0000', '2019-05-08T06:02:44.461+0000');

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
(20, '7j9nzKsY1sAPFfBtAAEp'),
(14, '7bofRwgwHis3yCUqAAEq');

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
(5, 'fX5mHGD7UW', 'anisul', 'hoque', 'anis@gmail.com', '$2y$10$.qRXVQTWkTe2oJTOb/UJbeI9DqcfXyTE4VURlFwrOWuk0u68otW3S', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2017-04-05 20:47:40'),
(7, 'MdE9UegmMV', 'admin', '', 'admin@admin.com', '$2y$10$.qRXVQTWkTe2oJTOb/UJbeI9DqcfXyTE4VURlFwrOWuk0u68otW3S', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 0, '2017-04-05 20:48:20'),
(10, 'btZSmNftbZ', 'Simon', 'hasan', 'simon@gmail.com', '$2y$10$.qRXVQTWkTe2oJTOb/UJbeI9DqcfXyTE4VURlFwrOWuk0u68otW3S', NULL, '0000-00-00 00:00:00', NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2018-03-13 14:09:59'),
(11, 'gsdkUwg5Er', 'Hasan', 'Zaman', 'hasan@gmail.com', '$2y$10$CN7oFFzwps4llUCculFz5ungWhdN91LTvrfXVZA0ydkVNnPz/s66W', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2017-10-29 20:49:55'),
(12, 'F6Y6EV3czN', 'Abel', 'Test', 'abel@gmail.com', '$2y$10$XLeHC0jVF4EFyKa76S4HDupt3ONLtDyRIZQsDSs4z0RtZfR9tLwBW', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-04-24 19:13:26'),
(13, 'xisbXVHRPa', 'Airene', 'Acuram', 'airene.acuram@gmail.com', '$2y$10$XeqRJMNlGdum9s4ruaBMAuJdJrCxcCuSmObrPnzVnIxFcbuLIy3wG', NULL, '1970-01-01 06:00:00', NULL, 1, 0, 1, NULL, '04252019114636profile13.png', NULL, 1, '2019-04-25 11:46:41'),
(14, 't793ArzKfU', 'Davin', 'Acuram', 'davin.acuram@gmail.com', '$2y$10$JUWDF4RVkGGvccee4ovWd.tmjKNOtrzAWkvIcixJZXjPmoXYLdLly', NULL, '1970-01-01 06:00:00', NULL, 1, 1, 1, NULL, '04252019114919profile14.png', NULL, 1, '2019-04-25 11:49:27'),
(15, 'PkflAnpkHC', 'Abelardo', 'Mazo', 'admin@arbitrage.ph', '$2y$10$m3oGR6wVHbdwo67xNabPU.KkNTS/fxK4NdGVRCgrS7jAtBio8DS4C', NULL, '1970-01-01 06:00:00', NULL, 1, 0, 1, NULL, '0425201943726profile15.jpg', NULL, 1, '2019-04-25 4:37:31'),
(16, 'mXTlIytb6X', 'monicar', 'gayo', 'nickgayo12@gmail.com', '$2y$10$ZxsAsDFx9AYCW4exC5eCreDe.RENPB/HYe1Wd74BwPZR6FAriXzIi', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-04-25 5:22:01'),
(17, 'Lzluo7cpHc', 'arphie', 'balboa', 'e3arphie@gmail.com', '$2y$10$enrTrxyVpFOq0ls6axK7/uu1XlemdkwBJF9WMwQovs3ZfxFSMo1Ei', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-04-27 3:58:09'),
(18, '0f8AEIabaf', 'mr', 'zhieend', 'zhieend@mailinator.com', '$2y$10$dVJINmTuGV0GMLcxU725zOemy0aZlQXdGzFdb0w1gx1kDfYAXdf/G', NULL, NULL, NULL, 1, 0, 1, NULL, '0428201990121profile18.png', NULL, 1, '2019-04-28 9:00:15'),
(19, 'PhqkJNefXg', 'nick', 'gayo', 'nickgayo1234@gmail.com', '$2y$10$6dQ3cThnLKrZyK2EvBM89eNW6lKQUXXy18O1Tn0B/F2CopOegUUA2', NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 1, '2019-04-29 11:35:32'),
(20, 'mP0TmtlYs2', 'Ralph', 'Tolipas', 'tolipasralphryan10@gmail.com', '$2y$10$Wgtjt9xzsF5Z5sxbHY5ydOCUxIvS/XZCFVi0OZ7oB0vfWtBy9zdxm', NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, 1, '2019-05-02 11:27:25');

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
  MODIFY `g_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `im_message`
--
ALTER TABLE `im_message`
  MODIFY `m_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;
