-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2011 at 05:25 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `enid`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE IF NOT EXISTS `affiliates` (
  `affiliateId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`affiliateId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `affiliates`
--


-- --------------------------------------------------------

--
-- Table structure for table `cfg_modules`
--

CREATE TABLE IF NOT EXISTS `cfg_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `enabled` varchar(255) NOT NULL DEFAULT 'false',
  `sessionObject` varchar(255) NOT NULL DEFAULT 'NULL',
  `runStartupScript` varchar(255) NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cfg_modules`
--

INSERT INTO `cfg_modules` (`id`, `module`, `enabled`, `sessionObject`, `runStartupScript`) VALUES
(1, 'usermanager', 'true', 'usermanager', 'true'),
(2, 'admin', 'true', 'NULL', 'false'),
(3, 'affiliatemanager', 'true', 'NULL', 'false'),
(4, 'eventmanager', 'true', 'NULL', 'false'),
(5, 'healthjournal', 'true', 'NULL', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `cfg_usermanager`
--

CREATE TABLE IF NOT EXISTS `cfg_usermanager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'SETTINGS',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cfg_usermanager`
--


-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) DEFAULT NULL,
  `timestamp` datetime NOT NULL,
  `process` varchar(255) NOT NULL,
  `errorid` varchar(255) NOT NULL,
  `errordescription` varchar(255) NOT NULL,
  `errormessage` text NOT NULL,
  `clientIP` varchar(16) NOT NULL DEFAULT 'XXX.XXX.XXX.XXX',
  `details` text,
  `event` varchar(255) NOT NULL,
  `elapsedTime` varchar(255) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `returnData` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `error_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `timeHour` varchar(2) NOT NULL,
  `timeMinute` varchar(2) NOT NULL,
  `timeAMPM` varchar(2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `recurring` varchar(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`eventId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `events`
--


-- --------------------------------------------------------

--
-- Table structure for table `events_rsvp`
--

CREATE TABLE IF NOT EXISTS `events_rsvp` (
  `eventId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events_rsvp`
--


-- --------------------------------------------------------

--
-- Table structure for table `healthjournal_activities`
--

CREATE TABLE IF NOT EXISTS `healthjournal_activities` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `activityDate` varchar(255) NOT NULL,
  `activityType` varchar(255) NOT NULL,
  `activityCalories` int(11) NOT NULL,
  `activityLevel` varchar(255) NOT NULL,
  `activityDistanceValue` varchar(255) NOT NULL,
  `activityDistanceType` varchar(255) NOT NULL,
  `activityDurationHours` varchar(2) NOT NULL,
  `activityDurationMinutes` varchar(2) NOT NULL,
  `activityDurationSeconds` varchar(2) NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `healthjournal_activities`
--


-- --------------------------------------------------------

--
-- Table structure for table `healthjournal_body`
--

CREATE TABLE IF NOT EXISTS `healthjournal_body` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `neck` double NOT NULL,
  `shoulders` double NOT NULL,
  `chest` double NOT NULL,
  `leftBicep` double NOT NULL,
  `rightBicep` double NOT NULL,
  `leftForearm` double NOT NULL,
  `rightForearm` double NOT NULL,
  `waist` double NOT NULL,
  `hips` double NOT NULL,
  `leftThigh` double NOT NULL,
  `rightThigh` double NOT NULL,
  `leftCalf` double NOT NULL,
  `rightCalf` double NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `healthjournal_body`
--


-- --------------------------------------------------------

--
-- Table structure for table `healthjournal_diary`
--

CREATE TABLE IF NOT EXISTS `healthjournal_diary` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `diaryDate` varchar(255) NOT NULL,
  `diaryTitle` varchar(255) NOT NULL,
  `mood` varchar(255) NOT NULL,
  `energy` varchar(255) NOT NULL,
  `stress` varchar(255) NOT NULL,
  `anger` varchar(255) NOT NULL,
  `appetite` varchar(255) NOT NULL,
  `clarity` varchar(255) NOT NULL,
  `health` varchar(255) NOT NULL,
  `sleep` varchar(255) NOT NULL,
  `entry` text NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `healthjournal_diary`
--


-- --------------------------------------------------------

--
-- Table structure for table `healthjournal_food`
--

CREATE TABLE IF NOT EXISTS `healthjournal_food` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `meal` varchar(255) NOT NULL,
  `item` int(11) NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `healthjournal_food`
--


-- --------------------------------------------------------

--
-- Table structure for table `healthjournal_food_items`
--

CREATE TABLE IF NOT EXISTS `healthjournal_food_items` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `calories` double NOT NULL,
  `cholesterol` double NOT NULL,
  `carbs` double NOT NULL,
  `dietaryFiber` double NOT NULL,
  `totalFat` double NOT NULL,
  `sodium` double NOT NULL,
  `sugars` double NOT NULL,
  `protein` double NOT NULL,
  `autocomplete` int(1) NOT NULL,
  PRIMARY KEY (`recordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `healthjournal_food_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `healthjournal_vital`
--

CREATE TABLE IF NOT EXISTS `healthjournal_vital` (
  `recordId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `syc` int(11) NOT NULL COMMENT 'bloodPressure',
  `dya` int(11) NOT NULL COMMENT 'bloodPressure',
  `pulse` int(11) NOT NULL COMMENT 'bloodPressure',
  `glucose` int(11) NOT NULL,
  `ldl` int(11) NOT NULL COMMENT 'cholesterol',
  `hdl` int(11) NOT NULL COMMENT 'cholesterol',
  PRIMARY KEY (`recordId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `healthjournal_vital`
--


-- --------------------------------------------------------

--
-- Table structure for table `sec_affiliatemanager`
--

CREATE TABLE IF NOT EXISTS `sec_affiliatemanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(255) NOT NULL,
  `groupName` varchar(255) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `method` (`method`),
  KEY `groupName` (`groupName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sec_affiliatemanager`
--

INSERT INTO `sec_affiliatemanager` (`id`, `method`, `groupName`) VALUES
(1, 'CREATE_AFFILIATE', 'user'),
(2, 'UPDATE_AFFILIATE', 'user'),
(3, 'DELETE_AFFILIATE', 'user'),
(4, 'GET_ALL_AFFILIATES', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `sec_chartdata`
--

CREATE TABLE IF NOT EXISTS `sec_chartdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(255) NOT NULL,
  `groupName` varchar(255) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `method` (`method`),
  KEY `groupName` (`groupName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sec_chartdata`
--

INSERT INTO `sec_chartdata` (`id`, `method`, `groupName`) VALUES
(1, 'GET_CHART_DATA', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `sec_eventmanager`
--

CREATE TABLE IF NOT EXISTS `sec_eventmanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(255) NOT NULL,
  `groupName` varchar(255) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `method` (`method`),
  KEY `groupName` (`groupName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sec_eventmanager`
--

INSERT INTO `sec_eventmanager` (`id`, `method`, `groupName`) VALUES
(1, 'CREATE_EVENT', 'user'),
(2, 'UPDATE_EVENT', 'user'),
(3, 'DELETE_EVENT', 'user'),
(4, 'GET_EVENT', 'user'),
(5, 'GET_ALL_EVENTS', 'user'),
(6, 'RSVP', 'user'),
(7, 'CANCEL_RSVP', 'user'),
(8, 'GET_ALL_ATTENDEES', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `sec_healthjournal`
--

CREATE TABLE IF NOT EXISTS `sec_healthjournal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(255) NOT NULL,
  `groupName` varchar(255) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `method` (`method`),
  KEY `groupName` (`groupName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `sec_healthjournal`
--

INSERT INTO `sec_healthjournal` (`id`, `method`, `groupName`) VALUES
(1, 'CREATE_ACTIVITIES_RECORD', 'user'),
(2, 'UPDATE_ACTIVITIES_RECORD', 'user'),
(3, 'DELETE_ACTIVITIES_RECORD', 'user'),
(4, 'GET_ACTIVITIES_RECORD', 'user'),
(5, 'GET_ALL_ACTIVITIES_RECORDS', 'user'),
(6, 'CREATE_VITAL_RECORD', 'user'),
(7, 'UPDATE_VITAL_RECORD', 'user'),
(8, 'DELETE_VITAL_RECORD', 'user'),
(9, 'GET_VITAL_RECORD', 'user'),
(10, 'GET_ALL_VITAL_RECORDS', 'user'),
(11, 'CREATE_DIARY_RECORD', 'user'),
(12, 'UPDATE_DIARY_RECORD', 'user'),
(13, 'DELETE_DIARY_RECORD', 'user'),
(14, 'GET_DIARY_RECORD', 'user'),
(15, 'GET_ALL_DIARY_RECORDS', 'user'),
(16, 'CREATE_BODY_RECORD', 'user'),
(17, 'DELETE_BODY_RECORD', 'user'),
(18, 'UPDATE_BODY_RECORD', 'user'),
(19, 'GET_BODY_RECORD', 'user'),
(20, 'GET_ALL_BODY_RECORDS', 'user'),
(21, 'CREATE_FOOD_ITEM_RECORD', 'user'),
(22, 'UPDATE_FOOD_ITEM_RECORD', 'user'),
(23, 'DELETE_FOOD_ITEM_RECORD', 'user'),
(24, 'GET_FOOD_ITEM_RECORD', 'user'),
(25, 'GET_ALL_FOOD_ITEM_RECORDS', 'user'),
(26, 'CREATE_FOOD_RECORD', 'user'),
(27, 'UPDATE_FOOD_RECORD', 'user'),
(28, 'DELETE_FOOD_RECORD', 'user'),
(29, 'GET_FOOD_RECORD', 'user'),
(30, 'GET_ALL_FOOD_RECORDS', 'user'),
(31, 'GET_CHART_DATA', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `sec_usermanager`
--

CREATE TABLE IF NOT EXISTS `sec_usermanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(255) NOT NULL,
  `groupName` varchar(255) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `method` (`method`),
  KEY `groupName` (`groupName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `sec_usermanager`
--

INSERT INTO `sec_usermanager` (`id`, `method`, `groupName`) VALUES
(1, 'LOGIN', 'user'),
(2, 'LOGOUT', 'user'),
(3, 'CREATE_USER', 'admin'),
(4, 'CREATE_ADDRESS', 'admin'),
(5, 'CREATE_USER_PROFILE', 'admin'),
(6, 'CREATE_BILLING_PROFILE', 'admin'),
(7, 'CREATE_SHIPPING_PROFILE', 'admin'),
(8, 'CREATE_ACCOUNT_PROFILE', 'admin'),
(9, 'GET_USERID', 'user'),
(10, 'GET_USERS', 'manager'),
(11, 'DELETE_USER', 'admin'),
(12, 'GET_USER_INFORMATION', 'user'),
(13, 'SET_PASSWORD', 'admin'),
(14, 'UPDATE_USER_PROFILE', 'user'),
(15, 'CHANGE_PASSWORD', 'dispatcher'),
(16, 'SET_GROUP', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`) VALUES
(0),
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE IF NOT EXISTS `user_account` (
  `userId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  UNIQUE KEY `userId` (`userId`),
  KEY `group` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`userId`, `username`, `password`, `group`) VALUES
(0, 'defaultUser', '1db28df13c04ff53178ebf5aa1a098b8', 'user'),
(1, 'Administrator', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin'),
(2, 'steven', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_account_validation`
--

CREATE TABLE IF NOT EXISTS `user_account_validation` (
  `userId` int(11) NOT NULL,
  `validationCode` varchar(255) NOT NULL,
  `validated` tinyint(1) NOT NULL,
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account_validation`
--

INSERT INTO `user_account_validation` (`userId`, `validationCode`, `validated`) VALUES
(1, 't34kbt', 0),
(2, 'vipc1j', 0),
(3, 'df92w2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `addressId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `other` text NOT NULL,
  PRIMARY KEY (`addressId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`addressId`, `firstName`, `lastName`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `email`, `phone`, `other`) VALUES
(1, 'Azimuth', '360', '227 S. Fillmore Ave', '', 'Louisville', 'CO', '80027', 'US', 'contact@azimuth360.com', '', ''),
(2, 'Steven', 'Zurek', '', '', '', '', '80027', '', 'Steven.zurek@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_billingprofile`
--

CREATE TABLE IF NOT EXISTS `user_billingprofile` (
  `profileId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `currentAddress` int(11) DEFAULT NULL,
  PRIMARY KEY (`profileId`),
  UNIQUE KEY `userId` (`userId`),
  KEY `currentAddress` (`currentAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_billingprofile`
--

INSERT INTO `user_billingprofile` (`profileId`, `userId`, `currentAddress`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_elements`
--

CREATE TABLE IF NOT EXISTS `user_elements` (
  `elementName` varchar(255) NOT NULL,
  `groupName` varchar(255) NOT NULL,
  KEY `groupName` (`groupName`),
  KEY `elementName` (`elementName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_elements`
--

INSERT INTO `user_elements` (`elementName`, `groupName`) VALUES
('loggedIn', 'dispatcher');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `groupLevel` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(255) NOT NULL,
  PRIMARY KEY (`groupLevel`),
  UNIQUE KEY `groupName` (`groupName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`groupLevel`, `groupName`) VALUES
(1, 'admin'),
(3, 'dispatcher'),
(2, 'manager'),
(4, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `profileId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `currentAddress` int(11) NOT NULL,
  PRIMARY KEY (`profileId`),
  KEY `userId` (`userId`),
  KEY `currentAddress` (`currentAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`profileId`, `userId`, `currentAddress`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_shippingprofile`
--

CREATE TABLE IF NOT EXISTS `user_shippingprofile` (
  `profileId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `currentAddress` int(11) NOT NULL,
  PRIMARY KEY (`profileId`),
  UNIQUE KEY `userId` (`userId`),
  UNIQUE KEY `currentAddress` (`currentAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_shippingprofile`
--

INSERT INTO `user_shippingprofile` (`profileId`, `userId`, `currentAddress`) VALUES
(1, 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `error_log`
--
ALTER TABLE `error_log`
  ADD CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sec_affiliatemanager`
--
ALTER TABLE `sec_affiliatemanager`
  ADD CONSTRAINT `sec_affiliatemanager_ibfk_1` FOREIGN KEY (`groupName`) REFERENCES `user_groups` (`groupName`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sec_eventmanager`
--
ALTER TABLE `sec_eventmanager`
  ADD CONSTRAINT `sec_eventmanager_ibfk_1` FOREIGN KEY (`groupName`) REFERENCES `user_groups` (`groupName`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sec_healthjournal`
--
ALTER TABLE `sec_healthjournal`
  ADD CONSTRAINT `sec_healthjournal_ibfk_1` FOREIGN KEY (`groupName`) REFERENCES `user_groups` (`groupName`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sec_usermanager`
--
ALTER TABLE `sec_usermanager`
  ADD CONSTRAINT `sec_usermanager_ibfk_1` FOREIGN KEY (`groupName`) REFERENCES `user_groups` (`groupName`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_account_ibfk_2` FOREIGN KEY (`group`) REFERENCES `user_groups` (`groupName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_account_validation`
--
ALTER TABLE `user_account_validation`
  ADD CONSTRAINT `user_account_validation_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_billingprofile`
--
ALTER TABLE `user_billingprofile`
  ADD CONSTRAINT `user_billingprofile_ibfk_2` FOREIGN KEY (`currentAddress`) REFERENCES `user_address` (`addressId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_billingprofile_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_elements`
--
ALTER TABLE `user_elements`
  ADD CONSTRAINT `user_elements_ibfk_1` FOREIGN KEY (`groupName`) REFERENCES `user_groups` (`groupName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_profile_ibfk_2` FOREIGN KEY (`currentAddress`) REFERENCES `user_address` (`addressId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `user_shippingprofile`
--
ALTER TABLE `user_shippingprofile`
  ADD CONSTRAINT `user_shippingprofile_ibfk_2` FOREIGN KEY (`currentAddress`) REFERENCES `user_address` (`addressId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_shippingprofile_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
