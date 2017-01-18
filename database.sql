-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2017 at 11:15 PM
-- Server version: 5.1.71-community-log
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_cvoltongdps`
--

-- --------------------------------------------------------

--
-- Table structure for table `acccomments`
--

CREATE TABLE IF NOT EXISTS `acccomments` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `secret` varchar(10) NOT NULL,
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=376 ;

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
  `saveData` longtext NOT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL,
  `friends` longtext NOT NULL,
  `blockedBy` longtext NOT NULL,
  `blocked` longtext NOT NULL,
  `mS` int(11) NOT NULL,
  `frS` int(11) NOT NULL,
  `youtubeurl` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `twitch` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  PRIMARY KEY (`accountID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=353 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `ID` int(11) NOT NULL DEFAULT '0',
  `person1` int(11) NOT NULL,
  `person2` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `percent` int(11) NOT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2213 ;

-- --------------------------------------------------------

--
-- Table structure for table `dailyfeatures`
--

CREATE TABLE IF NOT EXISTS `dailyfeatures` (
  `feaID` int(11) NOT NULL AUTO_INCREMENT,
  `levelID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`feaID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `friendreqs`
--

CREATE TABLE IF NOT EXISTS `friendreqs` (
  `accountID` int(11) NOT NULL,
  `toAccountID` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=208 ;

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE IF NOT EXISTS `friendships` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `person1` int(11) NOT NULL,
  `person2` int(11) NOT NULL,
  `isNew1` int(11) NOT NULL,
  `isNew2` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

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
  `starDemon` int(1) NOT NULL,
  `starAuto` varchar(1) NOT NULL,
  `starStars` int(11) NOT NULL,
  `uploadDate` varchar(1337) NOT NULL,
  `starCoins` int(11) NOT NULL,
  `starFeatured` int(11) NOT NULL DEFAULT '0',
  `starHall` int(11) NOT NULL,
  `starEpic` int(11) NOT NULL,
  `starDemonDiff` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `extID` varchar(255) NOT NULL,
  PRIMARY KEY (`levelID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3660 ;

-- --------------------------------------------------------

--
-- Table structure for table `levelscores`
--

CREATE TABLE IF NOT EXISTS `levelscores` (
  `scoreID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  PRIMARY KEY (`scoreID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `body` longtext NOT NULL,
  `subject` longtext NOT NULL,
  `accID` int(11) NOT NULL,
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `toAccountID` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `secret` varchar(10) NOT NULL,
  `isNew` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`messageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=140 ;

-- --------------------------------------------------------

--
-- Table structure for table `modips`
--

CREATE TABLE IF NOT EXISTS `modips` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(69) NOT NULL,
  `isMod` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5100004 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `isRegistered` int(11) NOT NULL,
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `extID` varchar(100) NOT NULL,
  `userName` varchar(69) NOT NULL DEFAULT 'undefined',
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
  `creatorPoints` int(11) NOT NULL,
  `IP` varchar(69) NOT NULL DEFAULT '127.0.0.1',
  `lastPlayed` int(11) NOT NULL,
  `diamonds` int(11) NOT NULL,
  `accSpider` int(11) NOT NULL,
  `accExplosion` int(11) NOT NULL,
  `chest1time` int(11) NOT NULL,
  `chest2time` int(11) NOT NULL,
  `chest1count` int(11) NOT NULL,
  `chest2count` int(11) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=559 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
