-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2015 at 10:00 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `geometrydash`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountcomments`
--

CREATE TABLE IF NOT EXISTS `accountcomments` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `secret` varchar(10) NOT NULL,
  `accID` int(11) NOT NULL,
`commentID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL,
`accountID` int(11) NOT NULL,
  `saveData` text NOT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
`commentID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `gameVersion` int(11) NOT NULL,
  `binaryVersion` int(11) NOT NULL,
  `userName` text NOT NULL,
`levelID` int(11) NOT NULL,
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
  `userID` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mappacks`
--

CREATE TABLE IF NOT EXISTS `mappacks` (
`ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `levels` varchar(100) NOT NULL COMMENT 'entered as "ID of level 1, ID of level 2, ID of level 3" for example "13,14,15" (without the "s)',
  `stars` int(11) NOT NULL,
  `coins` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `rgbcolors` varchar(11) NOT NULL COMMENT 'entered as R,G,B'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
`ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `authorID` int(11) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `download` varchar(1337) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `isRegistered` int(11) NOT NULL,
`userID` int(11) NOT NULL,
  `extID` varchar(100) NOT NULL,
  `userName` varchar(69) NOT NULL DEFAULT 'idk how but my name is bugged out',
  `stars` int(11) NOT NULL,
  `demons` int(11) NOT NULL,
  `creatorPoints` int(11) NOT NULL DEFAULT '0',
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
  `accGlow` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountcomments`
--
ALTER TABLE `accountcomments`
 ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
 ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
 ADD PRIMARY KEY (`levelID`);

--
-- Indexes for table `mappacks`
--
ALTER TABLE `mappacks`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountcomments`
--
ALTER TABLE `accountcomments`
MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
MODIFY `levelID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mappacks`
--
ALTER TABLE `mappacks`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
