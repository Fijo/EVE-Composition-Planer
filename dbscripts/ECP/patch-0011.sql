-- 2015-10-17_1-Fijo-Add-Eve-Api-Data

START TRANSACTION;

-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 17. Okt 2015 um 22:10
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
-- Tabellenstruktur für Tabelle `eveapi`
--

CREATE TABLE `eveapi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `keyId` int(10) unsigned NOT NULL,
  `vCode` varchar(64) NOT NULL,
  `status` varchar(256) NOT NULL,
  `lastComputed` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lastComputed` (`lastComputed`),
  KEY `eveapi_fi_f4311f` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `evecharacter`
--

CREATE TABLE `evecharacter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eveApiId` int(10) unsigned NOT NULL,
  `charName` varchar(32) NOT NULL,
  `charId` int(10) unsigned NOT NULL,
  `corpName` varchar(32) NOT NULL,
  `corpId` int(10) unsigned NOT NULL,
  `allyName` varchar(32) NOT NULL,
  `allyId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `evecharacter_fi_7350e6` (`eveApiId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `eveapi`
--
ALTER TABLE `eveapi`
  ADD CONSTRAINT `eveapi_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `evecharacter`
--
ALTER TABLE `evecharacter`
  ADD CONSTRAINT `evecharacter_fk_7350e6` FOREIGN KEY (`eveApiId`) REFERENCES `eveapi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

COMMIT;