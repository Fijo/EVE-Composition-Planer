-- 2015-10-6_1-Fijo-Add-Group-Tables

START TRANSACTION;

-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 09. Okt 2015 um 18:07
-- Server Version: 5.5.44-0ubuntu0.14.04.1-log
-- PHP-Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `ecp`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `entitytype`
--

CREATE TABLE IF NOT EXISTS `entitytype` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `entitytype`
--

INSERT INTO `entitytype` (`id`, `name`) VALUES
(3, 'CompositionEntity'),
(1, 'FittingRuleEntity'),
(4, 'Group'),
(2, 'RulesetEntity');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gr0up`
--

CREATE TABLE IF NOT EXISTS `gr0up` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `lastComputed` date NOT NULL,
  `lastModified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lastModified` (`lastModified`),
  KEY `lastComputed` (`lastComputed`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groupaccess`
--

CREATE TABLE IF NOT EXISTS `groupaccess` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entityTypeId` tinyint(4) unsigned NOT NULL,
  `entityId` int(10) unsigned NOT NULL,
  `groupId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupaccess_fi_7828d6` (`entityTypeId`),
  KEY `groupaccess_fi_179606` (`groupId`),
  KEY `entityTypeId` (`entityTypeId`,`groupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groupeveperson`
--

CREATE TABLE IF NOT EXISTS `groupeveperson` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupId` int(10) unsigned NOT NULL,
  `groupPersonTypeId` tinyint(3) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupeveperson_fi_7718b8` (`groupId`),
  KEY `groupeveperson_fi_390f30` (`groupPersonTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groupperson`
--

CREATE TABLE IF NOT EXISTS `groupperson` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupId` int(10) unsigned NOT NULL,
  `groupPersonTypeId` tinyint(3) unsigned NOT NULL,
  `groupEvePersonId` int(10) unsigned DEFAULT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupperson_fi_7718b8` (`groupId`),
  KEY `groupperson_fi_390f30` (`groupPersonTypeId`),
  KEY `groupperson_fi_aca593` (`groupEvePersonId`),
  KEY `groupperson_fi_f4311f` (`userId`),
  KEY `groupId` (`groupId`,`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `grouppersontype`
--

CREATE TABLE IF NOT EXISTS `grouppersontype` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(8) NOT NULL,
  `title` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `grouppersontype`
--

INSERT INTO `grouppersontype` (`id`, `name`, `title`) VALUES
(1, 'member', 'Members'),
(2, 'admin', 'Admins');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `groupaccess`
--
ALTER TABLE `groupaccess`
  ADD CONSTRAINT `groupaccess_fk_7828d6` FOREIGN KEY (`entityTypeId`) REFERENCES `entitytype` (`id`),
  ADD CONSTRAINT `groupaccess_fk_179606` FOREIGN KEY (`groupId`) REFERENCES `gr0up` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `groupeveperson`
--
ALTER TABLE `groupeveperson`
  ADD CONSTRAINT `groupeveperson_fk_390f30` FOREIGN KEY (`groupPersonTypeId`) REFERENCES `grouppersontype` (`id`),
  ADD CONSTRAINT `groupeveperson_fk_7718b8` FOREIGN KEY (`groupId`) REFERENCES `gr0up` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `groupperson`
--
ALTER TABLE `groupperson`
  ADD CONSTRAINT `groupperson_fk_390f30` FOREIGN KEY (`groupPersonTypeId`) REFERENCES `grouppersontype` (`id`),
  ADD CONSTRAINT `groupperson_fk_7718b8` FOREIGN KEY (`groupId`) REFERENCES `gr0up` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupperson_fk_aca593` FOREIGN KEY (`groupEvePersonId`) REFERENCES `groupeveperson` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupperson_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

COMMIT;