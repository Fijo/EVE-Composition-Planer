-- 2015-9-3_1-Fijo-ECP

START TRANSACTION;

-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2015 at 02:14 PM
-- Server version: 5.5.27-log
-- PHP Version: 5.6.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecp`
--

-- --------------------------------------------------------

--
-- Table structure for table `comparison`
--

CREATE TABLE IF NOT EXISTS `comparison` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `comparison`
--

INSERT INTO `comparison` (`id`, `name`) VALUES
(1, 'Less than'),
(2, 'Equal to'),
(3, 'Greater than'),
(4, 'Starts with'),
(5, 'Does not start with'),
(6, 'Is'),
(7, 'Is not'),
(8, 'Contains'),
(9, 'Does not contain'),
(10, 'And'),
(11, 'Or');

-- --------------------------------------------------------

--
-- Table structure for table `compositionentity`
--

CREATE TABLE IF NOT EXISTS `compositionentity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `isListed` tinyint(4) NOT NULL,
  `forkedId` int(10) unsigned NOT NULL,
  `rulesetEntityId` int(10) unsigned NOT NULL,
  `lastModified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`userId`),
  KEY `compositionentity_fi_f4311f` (`userId`),
  KEY `compositionentity_fi_eb3721` (`forkedId`),
  KEY `compositionentity_fi_6b95a6` (`rulesetEntityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;


-- --------------------------------------------------------

--
-- Table structure for table `compositionrow`
--

CREATE TABLE IF NOT EXISTS `compositionrow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `compositionEntityId` int(10) unsigned NOT NULL,
  `shipId` int(10) unsigned NOT NULL,
  `fitName` varchar(128) NOT NULL,
  `notes` varchar(4096) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `compositionrow_fi_ba0ee5` (`compositionEntityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `fitentry`
--

CREATE TABLE IF NOT EXISTS `fitentry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `compositionRowId` int(10) unsigned NOT NULL,
  `ind3x` int(10) unsigned NOT NULL,
  `fitEntryTypeId` int(10) unsigned NOT NULL,
  `itemId` int(10) unsigned NOT NULL,
  `ammoId` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fitentry_fi_9ca08b` (`compositionRowId`),
  KEY `fitentry_fi_61f8f2` (`fitEntryTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=433 ;

-- --------------------------------------------------------

--
-- Table structure for table `fitentrytype`
--

CREATE TABLE IF NOT EXISTS `fitentrytype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `fitentrytype`
--

INSERT INTO `fitentrytype` (`id`, `name`) VALUES
(1, 'empty'),
(2, 'seperator'),
(3, 'none'),
(4, 'empty-high'),
(5, 'empty-med'),
(6, 'empty-low'),
(7, 'empty-rig');

-- --------------------------------------------------------

--
-- Table structure for table `fittingruleentity`
--

CREATE TABLE IF NOT EXISTS `fittingruleentity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `isListed` tinyint(4) NOT NULL,
  `forkedId` int(10) unsigned NOT NULL,
  `lastModified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`userId`),
  KEY `fittingruleentity_fi_f4311f` (`userId`),
  KEY `fittingruleentity_fi_88901b` (`forkedId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `fittingrulerow`
--

CREATE TABLE IF NOT EXISTS `fittingrulerow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fittingRuleEntityId` int(10) unsigned NOT NULL,
  `ind3x` int(10) unsigned NOT NULL,
  `concatenation` int(10) unsigned NOT NULL,
  `comparison` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fittingrulerow_fi_bd07e1` (`fittingRuleEntityId`),
  KEY `fittingrulerow_fi_89378e` (`concatenation`),
  KEY `fittingrulerow_fi_2c7fa1` (`comparison`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

-- --------------------------------------------------------

--
-- Table structure for table `itemfilterdef`
--

CREATE TABLE IF NOT EXISTS `itemfilterdef` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `typeId` int(10) unsigned NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `minlength` int(11) NOT NULL,
  `maxlength` int(11) NOT NULL,
  `depth` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `itemfilterdef_fi_af1a2f` (`typeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `itemfilterdef`
--

INSERT INTO `itemfilterdef` (`id`, `name`, `typeId`, `min`, `max`, `minlength`, `maxlength`, `depth`) VALUES
(1, 'CPU usage', 1, 0, 100000, 0, 0, 0),
(2, 'Group', 4, 0, 0, 0, 0, 2),
(3, 'Meta group', 4, 0, 0, 0, 0, 1),
(4, 'Meta level', 2, 0, 100, 0, 0, 0),
(5, 'Name', 3, 0, 0, 0, 1024, 0),
(6, 'Power usage', 1, 0, 100000, 0, 0, 0),
(7, 'Slot type', 4, 0, 0, 0, 0, 1),
(8, 'Volume', 1, 0, 1000000000, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `itemfilterrule`
--

CREATE TABLE IF NOT EXISTS `itemfilterrule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fittingRuleRowId` int(10) unsigned NOT NULL,
  `ind3x` int(10) unsigned NOT NULL,
  `concatenation` int(10) unsigned NOT NULL,
  `itemFilterDefId` int(10) unsigned NOT NULL,
  `comparison` int(10) unsigned NOT NULL,
  `value` varchar(1024) NOT NULL,
  `content1` int(10) unsigned NOT NULL,
  `content2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `itemfilterrule_fi_ba234f` (`fittingRuleRowId`),
  KEY `itemfilterrule_fi_89378e` (`concatenation`),
  KEY `itemfilterrule_fi_c56a57` (`itemFilterDefId`),
  KEY `itemfilterrule_fi_2c7fa1` (`comparison`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=259 ;

-- --------------------------------------------------------

--
-- Table structure for table `rulesetentity`
--

CREATE TABLE IF NOT EXISTS `rulesetentity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `isListed` tinyint(4) NOT NULL,
  `forkedId` int(10) unsigned NOT NULL,
  `minPilots` int(10) unsigned NOT NULL,
  `maxPilots` int(10) unsigned NOT NULL,
  `maxPoints` int(10) unsigned NOT NULL,
  `lastModified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`userId`),
  KEY `rulesetentity_fi_f4311f` (`userId`),
  KEY `rulesetentity_fi_b888e4` (`forkedId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `rulesetfilterrule`
--

CREATE TABLE IF NOT EXISTS `rulesetfilterrule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rulesetRuleRowId` int(10) unsigned NOT NULL,
  `ind3x` int(10) unsigned NOT NULL,
  `concatenation` int(10) unsigned NOT NULL,
  `fittingRuleEntityId` int(10) unsigned NOT NULL,
  `comparison` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rulesetfilterrule_fi_44b754` (`rulesetRuleRowId`),
  KEY `rulesetfilterrule_fi_89378e` (`concatenation`),
  KEY `rulesetfilterrule_fi_bd07e1` (`fittingRuleEntityId`),
  KEY `rulesetfilterrule_fi_2c7fa1` (`comparison`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `rulesetrulerow`
--

CREATE TABLE IF NOT EXISTS `rulesetrulerow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rulesetEntityId` int(10) unsigned NOT NULL,
  `ind3x` int(10) unsigned NOT NULL,
  `message` varchar(4096) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rulesetrulerow_fi_6b95a6` (`rulesetEntityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `rulesetship`
--

CREATE TABLE IF NOT EXISTS `rulesetship` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rulesetEntityId` int(10) unsigned NOT NULL,
  `shipId` int(10) unsigned NOT NULL,
  `points` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rulesetship_fi_6b95a6` (`rulesetEntityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9697 ;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'float'),
(2, 'int'),
(3, 'string'),
(4, 'select'),
(5, 'bool');

-- --------------------------------------------------------

--
-- Table structure for table `typecomparison`
--

CREATE TABLE IF NOT EXISTS `typecomparison` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeId` int(10) unsigned NOT NULL,
  `comparisonId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typecomparison_fk_af1a2f` (`typeId`),
  KEY `typecomparison_fk_0338d3` (`comparisonId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `typecomparison`
--

INSERT INTO `typecomparison` (`id`, `typeId`, `comparisonId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1),
(5, 2, 2),
(6, 2, 3),
(7, 3, 4),
(8, 3, 5),
(9, 3, 6),
(10, 3, 7),
(11, 3, 8),
(12, 3, 9),
(13, 4, 6),
(14, 4, 7),
(15, 5, 10),
(16, 5, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmation_code` varchar(32) NOT NULL,
  `recover_password_code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `confirmation_code` (`confirmation_code`),
  KEY `recover_password_code` (`recover_password_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compositionentity`
--
ALTER TABLE `compositionentity`
  ADD CONSTRAINT `compositionentity_fk_6b95a6` FOREIGN KEY (`rulesetEntityId`) REFERENCES `rulesetentity` (`id`),
  ADD CONSTRAINT `compositionentity_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `compositionrow`
--
ALTER TABLE `compositionrow`
  ADD CONSTRAINT `compositionrow_fk_ba0ee5` FOREIGN KEY (`compositionEntityId`) REFERENCES `compositionentity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fitentry`
--
ALTER TABLE `fitentry`
  ADD CONSTRAINT `fitentry_fk_61f8f2` FOREIGN KEY (`fitEntryTypeId`) REFERENCES `fitentrytype` (`id`),
  ADD CONSTRAINT `fitentry_fk_9ca08b` FOREIGN KEY (`compositionRowId`) REFERENCES `compositionrow` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fittingruleentity`
--
ALTER TABLE `fittingruleentity`
  ADD CONSTRAINT `fittingruleentity_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `fittingrulerow`
--
ALTER TABLE `fittingrulerow`
  ADD CONSTRAINT `fittingrulerow_fk_2c7fa1` FOREIGN KEY (`comparison`) REFERENCES `comparison` (`id`),
  ADD CONSTRAINT `fittingrulerow_fk_bd07e1` FOREIGN KEY (`fittingRuleEntityId`) REFERENCES `fittingruleentity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `itemfilterdef`
--
ALTER TABLE `itemfilterdef`
  ADD CONSTRAINT `itemfilterdef_fk_af1a2f` FOREIGN KEY (`typeId`) REFERENCES `type` (`id`);

--
-- Constraints for table `itemfilterrule`
--
ALTER TABLE `itemfilterrule`
  ADD CONSTRAINT `itemfilterrule_fk_2c7fa1` FOREIGN KEY (`comparison`) REFERENCES `comparison` (`id`),
  ADD CONSTRAINT `itemfilterrule_fk_ba234f` FOREIGN KEY (`fittingRuleRowId`) REFERENCES `fittingrulerow` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemfilterrule_fk_c56a57` FOREIGN KEY (`itemFilterDefId`) REFERENCES `itemfilterdef` (`id`);

--
-- Constraints for table `rulesetentity`
--
ALTER TABLE `rulesetentity`
  ADD CONSTRAINT `rulesetentity_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `rulesetfilterrule`
--
ALTER TABLE `rulesetfilterrule`
  ADD CONSTRAINT `rulesetfilterrule_fk_2c7fa1` FOREIGN KEY (`comparison`) REFERENCES `comparison` (`id`),
  ADD CONSTRAINT `rulesetfilterrule_fk_44b754` FOREIGN KEY (`rulesetRuleRowId`) REFERENCES `rulesetrulerow` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rulesetfilterrule_fk_bd07e1` FOREIGN KEY (`fittingRuleEntityId`) REFERENCES `fittingruleentity` (`id`);

--
-- Constraints for table `rulesetrulerow`
--
ALTER TABLE `rulesetrulerow`
  ADD CONSTRAINT `rulesetrulerow_fk_6b95a6` FOREIGN KEY (`rulesetEntityId`) REFERENCES `rulesetentity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rulesetship`
--
ALTER TABLE `rulesetship`
  ADD CONSTRAINT `rulesetship_fk_6b95a6` FOREIGN KEY (`rulesetEntityId`) REFERENCES `rulesetentity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `typecomparison`
--
ALTER TABLE `typecomparison`
  ADD CONSTRAINT `typecomparison_fk_0338d3` FOREIGN KEY (`comparisonId`) REFERENCES `comparison` (`id`),
  ADD CONSTRAINT `typecomparison_fk_af1a2f` FOREIGN KEY (`typeId`) REFERENCES `type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

COMMIT;