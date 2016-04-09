-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2016 at 06:49 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thayson`
--
CREATE DATABASE IF NOT EXISTS `thayson` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `thayson`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `CommentId` int(20) NOT NULL AUTO_INCREMENT,
  `FacebookIdComment` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `FacebookUserIdComment` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Message` text COLLATE utf8_unicode_ci,
  `CreateCommentTime` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `StatusId` int(20) DEFAULT NULL,
  `FeedId` int(20) DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CommentId`),
  KEY `fk_comments_status_idx` (`StatusId`),
  KEY `fk_comments_feeds_idx` (`FeedId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=360 ;

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE IF NOT EXISTS `feeds` (
  `FeedId` int(20) NOT NULL AUTO_INCREMENT,
  `FacebookIdFeed` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `FacebookUserIdFeed` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Message` text COLLATE utf8_unicode_ci,
  `CreateFeedTime` datetime DEFAULT NULL,
  `UpdateFeedTime` datetime DEFAULT NULL,
  `StatusId` int(20) DEFAULT NULL,
  `GroupId` int(20) DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`FeedId`),
  KEY `fk_feeds_status_idx` (`StatusId`),
  KEY `fk_feeds_groups_idx` (`GroupId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=502 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `GroupId` int(20) NOT NULL AUTO_INCREMENT,
  `FacebookGroupId` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Privacy` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Owner` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateGroupTime` timestamp NULL DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ParentGroupId` int(20) DEFAULT '0',
  PRIMARY KEY (`GroupId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=59 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`GroupId`, `FacebookGroupId`, `Name`, `Privacy`, `Description`, `Icon`, `Email`, `Owner`, `CreateGroupTime`, `CreateTime`, `ParentGroupId`) VALUES
(58, '548960115147783', 'Gà vật lộn', 'CLOSED', '', 'https://static.xx.fbcdn.net/rsrc.php/v2/y2/r/yOUyZI9bori.png', '548960115147783@groups.faceboo', '856760261071101', '0000-00-00 00:00:00', '2016-04-06 16:12:26', 0),
(57, '1649687745294539', 'Team work money', 'SECRET', '', 'https://static.xx.fbcdn.net/rsrc.php/v2/yM/r/tOv73myJSBM.png', '1649687745294539@groups.facebo', '856760261071101', '0000-00-00 00:00:00', '2016-04-05 18:03:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `groupuser`
--

CREATE TABLE IF NOT EXISTS `groupuser` (
  `GroupUserId` int(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UserId` int(20) DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`GroupUserId`),
  KEY `fk_groupuser_users_idx` (`UserId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groupuser`
--

INSERT INTO `groupuser` (`GroupUserId`, `Name`, `Description`, `UserId`, `CreateTime`, `UpdateTime`) VALUES
(1, 'D11CNPM', 'd11', 19, '2016-01-29 19:44:21', '2016-01-29 19:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `InboxId` int(20) NOT NULL AUTO_INCREMENT,
  `FromUserId` int(20) DEFAULT NULL,
  `ToUserId` int(20) DEFAULT NULL,
  `Subject` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Content` text COLLATE utf8_unicode_ci,
  `Status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sentdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`InboxId`),
  KEY `fk_inbox_users_from_idx` (`FromUserId`),
  KEY `fk_inbox_users_to_idx` (`ToUserId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `MemberId` int(20) NOT NULL AUTO_INCREMENT,
  `FacebookIdMember` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Administrator` tinyint(1) DEFAULT NULL,
  `GroupId` int(20) DEFAULT NULL,
  `RealName` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Birthday` datetime DEFAULT NULL,
  `PhoneNumber1` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PhoneNumber2` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Class` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `School` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FacebookLink` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FacebookProfileId` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UpdateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`MemberId`),
  KEY `fk_members_groups_idx` (`GroupId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`MemberId`, `FacebookIdMember`, `Name`, `Administrator`, `GroupId`, `RealName`, `Address1`, `Address2`, `Birthday`, `PhoneNumber1`, `PhoneNumber2`, `Email`, `Gender`, `Class`, `School`, `FacebookLink`, `FacebookProfileId`, `CreateTime`, `UpdateTime`) VALUES
(1, '141151552894521', 'Loan Loan', 0, 57, 'ABC1', 'ABC', 'ABC', '2016-09-08 00:00:00', '98632879344', '98632879344', 'triuewesd@yahoo.com', 'nam', 'D11CN6', 'PTIT', 'https://www.facebook.com/tritueviet01', '100002114043418', '0000-00-00 00:00:00', '2016-04-08 15:09:51'),
(2, '1473930516252716', 'Ngoco Co Ngo', 1, 57, 'ABC2', 'ABC', 'ABC', '2016-09-09 00:00:00', '98632879345', '98632879345', 'triuewesd@yahoo.com', 'nam', 'D11CN7', 'PTIT', 'https://www.facebook.com/tritueviet02', 'https://www.facebook.com', '0000-00-00 00:00:00', '2016-04-08 15:11:23'),
(3, '823428784432896', 'Nguyễn Thơ', 1, 57, 'ABC3 re', 'ABC', 'ABC', '2016-09-10 00:00:00', '98632879346', '98632879346', 'triuewesd@yahoo.com', 'nam', 'D11CN8', 'PTIT', 'https://www.facebook.com/tritueviet03', 'https://www.facebook.com', '0000-00-00 00:00:00', '2016-04-08 16:32:37'),
(4, '919473994785230', 'Đông Nguyên', 1, 57, 'ABC4  test', 'ABC', 'ABC', '2016-09-11 00:00:00', '98632879347', '98632879347', 'triuewesd@yahoo.com', 'nam', 'D11CN9', 'PTIT', 'https://www.facebook.com/tritueviet04', 'https://www.facebook.com', '0000-00-00 00:00:00', '2016-04-08 15:17:13'),
(5, '856760261071101', 'Tường Vũ', 1, 58, 'ABC1', 'ABC', 'ABC', '2016-09-08 00:00:00', '98632879344', '98632879344', 'triuewesd@yahoo.com', 'nam', 'D11CN6', 'PTIT', 'https://www.facebook.com/tritueviet01', '100002114043418', '0000-00-00 00:00:00', '2016-04-08 15:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `RoleId` int(20) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleId`, `RoleName`, `Description`) VALUES
(1, 'Admin', 'Cho phép cấp quyền cho thành viên khác, quyền cao nhất, có tất cả chức năng khác'),
(3, 'Quản lý nhóm', 'Quyền quản lý nhóm group facebook, có thể thêm nhóm và lấy các thông tin từ facebook mà mình quản lý, được cấp cho thành viên và quản trị'),
(2, 'Quản trị', 'Cấp cao hơn cấp thành viên nhằm phân biệt học sinh sinh viên và thầy giáo, có thể quản lý nhóm thành viên'),
(4, 'Thành viên', 'Mặc định khi đăng kí sẽ có quyền thành viên, tham gia vào cộng đồng, nhận tin xem group, k có quyền add group'),
(5, 'Sửa thông tin cá nhân', 'User tham gia hệ thống có thể Sửa thông tin cá nhân của mình');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `StatusId` int(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`StatusId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`StatusId`, `Name`, `Description`) VALUES
(1, 'Chưa duyệt', 'Chưa được duyệt qua bởi người quản lý'),
(2, 'Đang duyệt', 'Đang kiểm duyệt qua bởi người quản lý'),
(3, 'Đã duyệt', 'Đã được kiểm duyệt'),
(4, 'Có vấn đề', 'Có vấn đề với thông tin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(20) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `FullName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Birthday` datetime DEFAULT NULL,
  `PhoneNumber1` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Avatar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PhoneNumber2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Class` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `School` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FacebookId` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  KEY `avatar` (`Avatar`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`, `FullName`, `Address1`, `Birthday`, `PhoneNumber1`, `Email`, `Gender`, `CreateTime`, `UpdateTime`, `Avatar`, `PhoneNumber2`, `Address2`, `Class`, `School`, `FacebookId`) VALUES
(19, 'Admin', 'admin', 'Admin', '', '1993-05-10 00:00:00', '', 'admin@gmail.com', '2', '2016-01-29 19:40:59', '2016-04-08 16:34:37', NULL, NULL, NULL, '0', NULL, NULL),
(18, 'tritueviet', 'abc', 'TUONG VAN VU', 'Tổ 6 Mỗ Lao Hà Đông Hà Nội', '1993-12-08 00:00:00', '01674183276', 'tritueviet01@yahoo.com', '1', '2016-01-29 19:31:55', '2016-04-03 18:07:09', NULL, '01674183276', 'Thái bình', 'D11CN', 'PTIT', NULL),
(20, 'tho', '123', 'thơ', '1', '2012-12-12 00:00:00', '1', '1', '1', '2016-02-24 10:39:45', '2016-04-03 15:59:15', NULL, NULL, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `UserGroupId` int(20) NOT NULL AUTO_INCREMENT,
  `UserId` int(20) DEFAULT NULL,
  `GroupId` int(20) DEFAULT NULL,
  PRIMARY KEY (`UserGroupId`),
  KEY `fk_user_group_users_idx` (`UserId`),
  KEY `fk_user_group_groups_idx` (`GroupId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`UserGroupId`, `UserId`, `GroupId`) VALUES
(39, 19, 58),
(38, 19, 57),
(37, 19, 56);

-- --------------------------------------------------------

--
-- Table structure for table `user_groupuser`
--

CREATE TABLE IF NOT EXISTS `user_groupuser` (
  `UserGroupUserId` int(20) NOT NULL AUTO_INCREMENT,
  `UserId` int(20) DEFAULT NULL,
  `GroupUserId` int(20) DEFAULT NULL,
  PRIMARY KEY (`UserGroupUserId`),
  KEY `fk_user_groupuser_users_idx` (`UserId`),
  KEY `fk_user_groupuser_groupuser_idx` (`GroupUserId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `user_groupuser`
--

INSERT INTO `user_groupuser` (`UserGroupUserId`, `UserId`, `GroupUserId`) VALUES
(21, 20, 1),
(16, 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `UserRoleId` int(20) NOT NULL AUTO_INCREMENT,
  `RoleId` int(20) DEFAULT NULL,
  `UserId` int(20) DEFAULT NULL,
  PRIMARY KEY (`UserRoleId`),
  KEY `fk_user_role_users_idx` (`UserId`),
  KEY `fk_user_role_roles_idx` (`RoleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=80 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`UserRoleId`, `RoleId`, `UserId`) VALUES
(74, 3, 18),
(72, 4, 18),
(1, 1, 19),
(75, 2, 19),
(76, 3, 19),
(77, 4, 19),
(78, 5, 19),
(79, 5, 18);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;