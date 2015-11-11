-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 09, 2015 at 12:19 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `1044236`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `accountID` int(11) NOT NULL AUTO_INCREMENT,
  `saveData` text NOT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`accountID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `secret` varchar(10) NOT NULL,
  `levelID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `gameVersion` int(11) NOT NULL,
  `binaryVersion` int(11) NOT NULL,
  `userName` text NOT NULL,
  `levelID` int(11) NOT NULL AUTO_INCREMENT,
  `levelName` text NOT NULL,
  `levelDesc` text NOT NULL,
  `levelVersion` int(11) NOT NULL,
  `levelLength` int(11) NOT NULL,
  `audioTrack` int(11) NOT NULL,
  `auto` int(11) NOT NULL,
  `password` text NOT NULL,
  `original` int(11) NOT NULL,
  `twoPlayer` int(11) NOT NULL,
  `songID` int(11) NOT NULL,
  `objects` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `requestedStars` int(11) NOT NULL,
  `extraString` text NOT NULL,
  `levelString` longtext NOT NULL,
  `levelInfo` text NOT NULL,
  `secret` text NOT NULL,
  `starDifficulty` int(11) NOT NULL DEFAULT '0' COMMENT '0=N/A 10=EASY 20=NORMAL 30=HARD 40=HARDER 50=INSANE 50=AUTO 50=DEMON',
  `downloads` int(11) NOT NULL DEFAULT '5',
  `likes` int(11) NOT NULL DEFAULT '3',
  `starDemon` varchar(1) NOT NULL,
  `starAuto` varchar(1) NOT NULL,
  `starStars` int(11) NOT NULL,
  `uploadDate` varchar(1337) NOT NULL,
  `starCoins` int(11) NOT NULL,
  `starFeatured` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`levelID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

-- --------------------------------------------------------

--
-- Table structure for table `mappacks`
--

CREATE TABLE IF NOT EXISTS `mappacks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `levels` varchar(100) NOT NULL COMMENT 'entered as "ID of level 1, ID of level 2, ID of level 3" for example "13,14,15" (without the "s)',
  `stars` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `rgbcolors` varchar(11) NOT NULL COMMENT 'entered as R,G,B',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `authorID` int(11) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `download` varchar(1337) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1337676 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `isRegistered` int(11) NOT NULL,
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `extID` varchar(100) NOT NULL,
  `userName` varchar(69) NOT NULL DEFAULT 'idk how but my name is bugged out',
  `stars` int(11) NOT NULL,
  `demons` int(11) NOT NULL,
  `icon` int(11) NOT NULL,
  `color1` int(11) NOT NULL,
  `color2` int(11) NOT NULL,
  `iconType` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `userCoins` int(11) NOT NULL,
  `special` int(11) NOT NULL,
  `gameVersion` int(11) NOT NULL,
  `secret` varchar(69) NOT NULL,
  `accIcon` int(11) NOT NULL,
  `accShip` int(11) NOT NULL,
  `accBall` int(11) NOT NULL,
  `accBird` int(11) NOT NULL,
  `accDart` int(11) NOT NULL,
  `accRobot` int(11) NOT NULL,
  `accGlow` int(11) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
