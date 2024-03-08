<?php
include "incl/dashboardLib.php";
include $dbPath."incl/lib/connection.php";
include $dbPath."config/dashboard.php";
if(!$installed) {
	$check = $db->query("SHOW TABLES LIKE 'replies'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("CREATE TABLE `replies` (
			 `replyID` int(11) NOT NULL AUTO_INCREMENT,
			 `commentID` int(11) NOT NULL,
			 `accountID` int(11) NOT NULL,
			 `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
			 `timestamp` int(11) NOT NULL,
			 PRIMARY KEY (`replyID`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	$check = $db->query("SHOW TABLES LIKE 'demonlist'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("CREATE TABLE `demonlist` (
		 `levelID` int(11) NOT NULL,
		 `authorID` int(11) NOT NULL,
		 `pseudoPoints` int(11) NOT NULL,
		 `giveablePoints` int(11) NOT NULL,
		 `youtube` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
		 PRIMARY KEY (`levelID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	$check = $db->query("SHOW TABLES LIKE 'dlsubmits'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("CREATE TABLE `dlsubmits` (
			 `ID` int(11) NOT NULL AUTO_INCREMENT,
			 `accountID` int(11) NOT NULL,
			 `levelID` int(11) NOT NULL,
			 `atts` int(255) NOT NULL,
			 `ytlink` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
			 `auth` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
			 `approve` int(11) NOT NULL DEFAULT 0,
			 PRIMARY KEY (`ID`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	$check = $db->query("SHOW TABLES LIKE 'favsongs'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("CREATE TABLE `favsongs` (
			 `ID` int(20) NOT NULL AUTO_INCREMENT,
			 `songID` int(20) NOT NULL DEFAULT '0',
			 `accountID` int(20) NOT NULL DEFAULT '0',
			 `timestamp` int(20) NOT NULL DEFAULT '0',
			 PRIMARY KEY (`ID`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	$check = $db->query("SHOW TABLES LIKE 'clans'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("CREATE TABLE `clans` (
			 `ID` int(11) NOT NULL AUTO_INCREMENT,
			 `clan` varchar(255) NOT NULL DEFAULT '',
			 `desc` varchar(2048) NOT NULL DEFAULT '',
			 `clanOwner` int(11) NOT NULL DEFAULT '0',
			 `color` varchar(6) NOT NULL DEFAULT 'FFFFFF',
			 `isClosed` int(11) NOT NULL DEFAULT '0',
			 `creationDate` int(11) NOT NULL DEFAULT '0',
			 PRIMARY KEY (`ID`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8");
	$check = $db->query("SHOW TABLES LIKE 'clanrequests'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("CREATE TABLE `clanrequests` (
			 `ID` int(11) NOT NULL AUTO_INCREMENT,
			 `accountID` int(11) NOT NULL DEFAULT '0',
			 `clanID` int(11) NOT NULL DEFAULT '0',
			 `timestamp` int(11) NOT NULL DEFAULT '0',
			 PRIMARY KEY (`ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$check = $db->query("SHOW TABLES LIKE 'sfxs'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("CREATE TABLE `sfxs` (
			 `ID` int(11) NOT NULL AUTO_INCREMENT,
			 `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			 `authorName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			 `download` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
			 `milliseconds` int(11) NOT NULL DEFAULT '0',
			 `size` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			 `isDisabled` int(11) NOT NULL DEFAULT '0',
			 `levelsCount` int(11) NOT NULL DEFAULT '0',
			 `reuploadID` int(11) NOT NULL DEFAULT '0',
			 `reuploadTime` int(11) NOT NULL DEFAULT '0',
			 PRIMARY KEY (`ID`),
			 KEY `name` (`name`),
			 KEY `authorName` (`authorName`)
			) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardLevelPackCreate'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardLevelPackCreate INT NOT NULL DEFAULT '0' AFTER dashboardModTools");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardAddMod'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardAddMod INT NOT NULL DEFAULT '0' AFTER dashboardLevelPackCreate");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardManageSongs'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardManageSongs INT NOT NULL DEFAULT '0' AFTER dashboardAddMod");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardForceChangePassNick'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardForceChangePassNick INT NOT NULL DEFAULT '0' AFTER dashboardManageSongs");
		$check = $db->query("SHOW COLUMNS FROM `songs` LIKE 'reuploadID'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE songs ADD reuploadID INT NOT NULL DEFAULT '0' AFTER reuploadTime");
		$check = $db->query("SHOW COLUMNS FROM `users` LIKE 'banReason'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE users ADD banReason varchar(255) NOT NULL DEFAULT 'none' AFTER isCreatorBanned");
		$check = $db->query("SHOW COLUMNS FROM `accounts` LIKE 'auth'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE accounts ADD auth varchar(16) NOT NULL DEFAULT 'none' AFTER isActive");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'demonlistAdd'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE roles ADD demonlistAdd INT NOT NULL DEFAULT '0' AFTER dashboardForceChangePassNick");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'demonlistApprove'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE roles ADD demonlistApprove INT NOT NULL DEFAULT '0' AFTER demonlistAdd");
		$check = $db->query("SHOW COLUMNS FROM `users` LIKE 'clan'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE users ADD clan INT NOT NULL DEFAULT '0' AFTER userName");
		$check = $db->query("SHOW COLUMNS FROM `users` LIKE 'joinedAt'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE users ADD joinedAt INT NOT NULL DEFAULT '0' AFTER clan");
		$check = $db->query("SHOW COLUMNS FROM `users` LIKE 'dlPoints'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE users ADD dlPoints INT NOT NULL DEFAULT '0' AFTER joinedAt");
		$check = $db->query("SHOW COLUMNS FROM `gauntlets` LIKE 'timestamp'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE gauntlets ADD timestamp INT NOT NULL DEFAULT '0' AFTER level5");
		$check = $db->query("SHOW COLUMNS FROM `mappacks` LIKE 'timestamp'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE mappacks ADD timestamp INT NOT NULL DEFAULT '0' AFTER colors2");
		$check = $db->query("SHOW COLUMNS FROM `songs` LIKE 'duration'");
      		$exist = $check->fetchAll();
      		if(empty($exist)) $db->query("ALTER TABLE songs ADD duration INT NOT NULL DEFAULT '0' AFTER size");
	$lines = file($dbPath.'config/dashboard.php');
	$first_line = $lines[2];
	$lines = array_slice($lines, 1 + 2);
	$lines = array_merge(array($first_line, "\n"), $lines);
	$file = fopen($dbPath.'config/dashboard.php', 'w');
  	fwrite($file, "<?php\r\n");
  	fwrite($file, "\$installed = true; // Like i said, it changed!\r");
	fwrite($file, implode('', $lines));
  	fclose($file);
  	header('Location: .?installed=1');
} else header('Location: .');
?>