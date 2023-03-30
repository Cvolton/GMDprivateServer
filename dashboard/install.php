<?php
include "incl/dashboardLib.php";
include $dbPath."incl/lib/connection.php";
include $dbPath."config/dashboard.php";
if(!$installed) {
	$info = $db->query("SHOW VARIABLES like '%version%'")->fetchAll(PDO::FETCH_KEY_PAIR);
	$server  = strtok($info['version_comment']," ");
  	$ver = $info['version'];
  	if($server == 'MariaDB' AND $ver > 10) {
      $db->query("ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardLevelPackCreate INT NOT NULL DEFAULT '0' AFTER dashboardModTools; 
      ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardAddMod INT NOT NULL DEFAULT '0' AFTER dashboardLevelPackCreate; 
      ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardManageSongs INT NOT NULL DEFAULT '0' AFTER dashboardAddMod; 
      ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardForceChangePassNick INT NOT NULL DEFAULT '0' AFTER dashboardManageSongs; 
      ALTER TABLE songs ADD COLUMN IF NOT EXISTS reuploadID INT NOT NULL DEFAULT '0' AFTER reuploadTime; 
      ALTER TABLE users ADD COLUMN IF NOT EXISTS banReason varchar(255) NOT NULL DEFAULT 'none' AFTER isCreatorBanned;
	  ALTER TABLE accounts ADD COLUMN IF NOT EXISTS auth varchar(16) NOT NULL DEFAULT 'none' AFTER isActive;
	  ALTER TABLE roles ADD COLUMN IF NOT EXISTS demonlistAdd INT NOT NULL DEFAULT '0' AFTER dashboardForceChangePassNick;
	  ALTER TABLE roles ADD COLUMN IF NOT EXISTS demonlistApprove INT NOT NULL DEFAULT '0' AFTER demonlistAdd;
	  ALTER TABLE users ADD COLUMN IF NOT EXISTS clan INT NOT NULL DEFAULT '0' AFTER userName;
	  ALTER TABLE users ADD COLUMN IF NOT EXISTS joinedAt INT NOT NULL DEFAULT '0' AFTER clan");
	} else {
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
	}
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
	$lines = file($dbPath.'config/dashboard.php');
	$first_line = $lines[2];
	$lines = array_slice($lines, 1 + 2);
	$lines = array_merge(array($first_line, "\n"), $lines);
	$file = fopen($dbPath.'config/dashboard.php', 'w');
  	fwrite($file, "<?php\r\n");
  	fwrite($file, "\$installed = true; // Like i said, it changed!\r");
	fwrite($file, implode('', $lines));
  	fclose($file);
  	if(!file_exists("./download")) mkdir("./download", 0755);
  	header('Location: .?installed=1');
} else header('Location: .');
?>
