<?php
class Cron {
	public static function autoban($accountID, $checkForTime) {
		require __DIR__."/connection.php";
		require_once __DIR__."/mainLib.php";
		$gs = new mainLib();
		if($checkForTime) {
			$check = $db->prepare("SELECT count(*) FROM actions WHERE type = 39 AND timestamp >= :timestamp");
			$check->execute([':timestamp' => time() - 30]);
			$check = $check->fetchColumn();
			if($check) return false;
		}
		$query = $db->prepare("SELECT
		10 + IFNULL(FLOOR(coins.coins * 1.25) + (coins1.coins), 0) as coins,
		3 + IFNULL(FLOOR(levels.demons * 1.0625) + (demons.demons), 0) as demons,
		212 + FLOOR((IFNULL(levels.stars, 0) + IFNULL(gauntlets.stars, 0) + IFNULL(mappacks.stars, 0)) + IFNULL(stars.stars, 0) * 1.25) as stars,
		25 + IFNULL(moons.moons, 0) as moons
		FROM
			(SELECT SUM(coins) as coins FROM levels WHERE starCoins <> 0) coins
			JOIN
				(SELECT SUM(starDemon) as demons, SUM(starStars) as stars FROM levels) levels
			 JOIN 
				(SELECT SUM(starStars) as stars FROM dailyfeatures 
				INNER JOIN levels on levels.levelID = dailyfeatures.levelID) stars
			JOIN
				(SELECT SUM(starCoins) as coins FROM dailyfeatures 
				INNER JOIN levels on levels.levelID = dailyfeatures.levelID) coins1
			JOIN
				(SELECT SUM(starDemon) as demons FROM dailyfeatures 
				INNER JOIN levels on levels.levelID = dailyfeatures.levelID) demons
			JOIN
			(
				SELECT (level1.stars + level2.stars + level3.stars + level4.stars + level5.stars) as stars FROM
					(SELECT SUM(starStars) as stars FROM gauntlets
					INNER JOIN levels on levels.levelID = gauntlets.level1) level1
				JOIN
					(SELECT SUM(starStars) as stars FROM gauntlets
					INNER JOIN levels on levels.levelID = gauntlets.level2) level2
				JOIN
					(SELECT SUM(starStars) as stars FROM gauntlets
					INNER JOIN levels on levels.levelID = gauntlets.level3) level3
				JOIN
					(SELECT SUM(starStars) as stars FROM gauntlets
					INNER JOIN levels on levels.levelID = gauntlets.level4) level4
				JOIN
					(SELECT SUM(starStars) as stars FROM gauntlets
					INNER JOIN levels on levels.levelID = gauntlets.level5) level5
			) gauntlets
			JOIN
				(SELECT SUM(stars) as stars FROM mappacks) mappacks
			JOIN 
				(SELECT SUM(starStars) as moons FROM levels WHERE levelLength = 5) moons
		");
		$query->execute();
		$levelstuff = $query->fetch();
		$stars = $levelstuff['stars'];
		$coins = $levelstuff['coins'];
		$demons = $levelstuff['demons'];
		$moons = $levelstuff['moons']; 
		$query = $db->prepare("SELECT userID FROM users WHERE stars > :stars OR demons > :demons OR userCoins > :coins OR moons > :moons OR stars < 0 OR demons < 0 OR coins < 0 OR userCoins < 0 OR diamonds < 0 OR moons < 0");
		$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins, ':moons' => $moons]);
		$query = $query->fetchAll();
		foreach($query AS &$ban) {
			$getUser = $db->prepare('SELECT stars, demons, userCoins, moons FROM users WHERE userID = :userID');
			$getUser->execute([':userID' => $ban['userID']]);
			$getUser = $getUser->fetch();
			$maxText = 'MAX: ⭐'.$stars.' • 🌙'.$moons.' • 👿'.$demons.' • 🪙'.$coins.' | USER: ⭐'.$getUser['stars'].' • 🌙'.$getUser['moons'].' • 👿'.$getUser['demons'].' • 🪙'.$getUser['userCoins'];
			$gs->banPerson(0, $ban['userID'], $maxText, 0, 1, 2147483647);
		}
		$gs->logAction($accountID, 39, $stars, $coins, $demons, $moons, count($query));
		return true;
	}
	public static function updateCreatorPoints($accountID, $checkForTime) {
		require __DIR__."/connection.php";
		require_once __DIR__."/mainLib.php";
		$gs = new mainLib();
		if($checkForTime) {
			$check = $db->prepare("SELECT count(*) FROM actions WHERE type = 40 AND timestamp >= :timestamp");
			$check->execute([':timestamp' => time() - 30]);
			$check = $check->fetchColumn();
			if($check) return false;
		}
		$people = [];
		/*
			Creator Points for rated levels
		*/
		$query = $db->prepare("UPDATE users
			LEFT JOIN
			(
				SELECT usersTable.userID, (IFNULL(starredTable.starred, 0) + IFNULL(featuredTable.featured, 0) + (IFNULL(epicTable.epic,0))) as CP FROM (
					SELECT userID FROM users
				) AS usersTable
				LEFT JOIN
				(
					SELECT count(*) as starred, userID FROM levels WHERE starStars != 0 AND isCPShared = 0 GROUP BY(userID) 
				) AS starredTable ON usersTable.userID = starredTable.userID
				LEFT JOIN
				(
					SELECT count(*) as featured, userID FROM levels WHERE starFeatured != 0 AND isCPShared = 0 GROUP BY(userID) 
				) AS featuredTable ON usersTable.userID = featuredTable.userID
				LEFT JOIN
				(
					SELECT starEpic as epic, userID FROM levels WHERE starEpic != 0 AND isCPShared = 0 GROUP BY(userID) 
				) AS epicTable ON usersTable.userID = epicTable.userID
			) calculated
			ON users.userID = calculated.userID
			SET users.creatorPoints = IFNULL(calculated.CP, 0)");
		$query->execute();
		/*
			Creator Points sharing
		*/
		$query = $db->prepare("SELECT levelID, userID, starStars, starFeatured, starEpic FROM levels WHERE isCPShared != 0");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result AS &$level) {
			$deservedcp = 0;
			if($level["starStars"] != 0) $deservedcp++;
			if($level["starFeatured"] != 0) $deservedcp++;
			if($level["starEpic"] != 0) $deservedcp += $level["starEpic"];
			$query = $db->prepare("SELECT userID FROM cpshares WHERE levelID = :levelID");
			$query->execute([':levelID' => $level["levelID"]]);
			$sharecount = $query->rowCount() + 1;
			$addcp = $deservedcp / $sharecount;
			$shares = $query->fetchAll();
			foreach($shares as &$share) $people[$share["userID"]] += $addcp;
			$people[$level["userID"]] += $addcp;
		}
		/*
			Creator Points for levels in Map Packs
		*/
		$query = $db->prepare("SELECT levels FROM mappacks");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result AS &$pack) {
			$query = $db->prepare("SELECT userID FROM levels WHERE levelID IN (".$pack['levels'].")");
			$query->execute();
			$levels = $query->fetch();
			foreach($levels AS &$level) $people[$level["userID"]] += 1;
		}
		/*
			Creator Points for levels in Gauntlets
		*/
		$query = $db->prepare("SELECT level1, level2, level3, level4, level5 FROM gauntlets");
		$query->execute();
		$result = $query->fetchAll();
		foreach($result AS &$gauntlet) {
			for($x = 1; $x < 6; $x++) {
				$query = $db->prepare("SELECT userID FROM levels WHERE levelID = :levelID");
				$query->execute([':levelID' => $gauntlet["level".$x]]);
				$result = $query->fetch();
				if($result) $people[$result["userID"]] += 1;
			}
		}
		/*
			Creator Points for Daily/Weekly levels
		*/
		$query = $db->prepare("SELECT levelID FROM dailyfeatures WHERE timestamp < :time");
		$query->execute([':time' => time()]);
		$result = $query->fetchAll();
		foreach($result AS &$daily) {
			$query = $db->prepare("SELECT userID, levelID FROM levels WHERE levelID = :levelID");
			$query->execute([':levelID' => $daily["levelID"]]);
			$result = $query->fetch();
			if($result) $people[$result["userID"]] += 1;
		}
		/*
			Creator Points for Event levels
		*/
		$query = $db->prepare("SELECT levelID FROM events WHERE timestamp < :time");
		$query->execute([':time' => time()]);
		$result = $query->fetchAll();
		foreach($result AS &$event) {
			$query = $db->prepare("SELECT userID, levelID FROM levels WHERE levelID = :levelID");
			$query->execute([':levelID' => $event["levelID"]]);
			$result = $query->fetch();
			if($result) $people[$result["userID"]] += 1;
		}
		/*
			Done
		*/
		foreach($people AS $user => $cp) {
			$query4 = $db->prepare("UPDATE users SET creatorPoints = (creatorpoints + :creatorpoints) WHERE userID = :userID");
			$query4->execute([':userID' => $user, ':creatorpoints' => $cp]);
		}
		$gs->logAction($accountID, 40);
		return true;
	}
	public static function fixUsernames($accountID, $checkForTime) {
		require __DIR__."/connection.php";
		require_once __DIR__."/mainLib.php";
		$gs = new mainLib();
		if($checkForTime) {
			$check = $db->prepare("SELECT count(*) FROM actions WHERE type = 41 AND timestamp >= :timestamp");
			$check->execute([':timestamp' => time() - 30]);
			$check = $check->fetchColumn();
			if($check) return false;
		}
		$query = $db->prepare("UPDATE users
			INNER JOIN accounts ON accounts.accountID = users.extID
			SET users.userName = accounts.userName
			WHERE users.extID REGEXP '^-?[0-9]+$'
			AND LENGTH(accounts.userName) <= 69");
		$query->execute();
		$gs->logAction($accountID, 41);
		return true;
	}
	public static function updateFriendsCount($accountID, $checkForTime) {
		require __DIR__."/connection.php";
		require_once __DIR__."/mainLib.php";
		$gs = new mainLib();
		if($checkForTime) {
			$check = $db->prepare("SELECT count(*) FROM actions WHERE type = 42 AND timestamp >= :timestamp");
			$check->execute([':timestamp' => time() - 30]);
			$check = $check->fetchColumn();
			if($check) return false;
		}
		$query = $db->prepare("UPDATE accounts
			LEFT JOIN
			(
				SELECT a.person, (IFNULL(a.friends, 0) + IFNULL(b.friends, 0)) AS friends FROM (
					SELECT count(*) as friends, person1 AS person FROM friendships GROUP BY(person1) 
				) AS a
				JOIN
				(
					SELECT count(*) as friends, person2 AS person FROM friendships GROUP BY(person2) 
				) AS b ON a.person = b.person
			) calculated
			ON accounts.accountID = calculated.person
			SET accounts.friendsCount = IFNULL(calculated.friends, 0)");
		$query->execute();
		$gs->logAction($accountID, 42);
		return true;
	}
	public static function miscFixes($accountID, $checkForTime) {
		require __DIR__."/connection.php";
		require_once __DIR__."/mainLib.php";
		$gs = new mainLib();
		if($checkForTime) {
			$check = $db->prepare("SELECT count(*) FROM actions WHERE type = 43 AND timestamp >= :timestamp");
			$check->execute([':timestamp' => time() - 30]);
			$check = $check->fetchColumn();
			if($check) return false;
		}
		/*
			Unbanning everyone who has expired ban
		*/
		$bans = $db->prepare('UPDATE bans SET isActive = 0 WHERE expires < :time');
		$bans->execute([':time' => time()]);
		/*
			Unbanning IPs
		*/
		$getIPBans = $db->prepare("SELECT person FROM bans WHERE personType = 2 AND banType = 4 AND isActive = 0");
		$getIPBans->execute();
		$getIPBans = $getIPBans->fetchAll();
		$IPBans = [];
		foreach($getIPBans AS &$ban) {
			$IPBans[] = $gs->IPForBan($ban['person'], true);
		}
		$bannedIPsString = implode("|", $IPBans);
		$unbanIPs = $db->prepare('DELETE FROM bannedips WHERE IP REGEXP "'.$bannedIPsString.'"');
		$unbanIPs->execute();
		$gs->logAction($accountID, 43);
		return true;
	}
	public static function updateSongsUsage($accountID, $checkForTime) {
		require __DIR__."/connection.php";
		require_once __DIR__."/mainLib.php";
		$gs = new mainLib();
		if($checkForTime) {
			$check = $db->prepare("SELECT count(*) FROM actions WHERE type = 44 AND timestamp >= :timestamp");
			$check->execute([':timestamp' => time() - 30]);
			$check = $check->fetchColumn();
			if($check) return false;
		}
		$query = $db->prepare("SELECT songID, songIDs, sfxIDs FROM levels");
		$query->execute();
		$levels = $query->fetchAll();
		$songsUsage = $sfxsUsage = [];
		/*
			Count songs and SFXs usage
		*/
		$songsLibrary = json_decode(file_get_contents(__DIR__.'/../../music/ids.json'), true) ?: [];
		$sfxsLibrary = json_decode(file_get_contents(__DIR__.'/../../sfx/ids.json'), true) ?: [];
		foreach($levels AS &$level) {
			$mainSong = $gs->getSongInfo($level['songID'], "*", $songsLibrary);
			if($mainSong && $mainSong['isLocalSong']) $songsUsage[$mainSong['ID']]++;
			$extraSongs = explode(',', $level['songIDs']);
			foreach($extraSongs AS &$song) {
				if(empty($song)) continue;
				$extraSong = $gs->getSongInfo($song, "*", $songsLibrary);
				if($extraSong && $extraSong['isLocalSong']) $songsUsage[$extraSong['ID']]++;
			}
			$extraSFXs = explode(',', $level['sfxIDs']);
			foreach($extraSFXs AS &$sfx) {
				if(empty($sfx)) continue;
				$extraSFX = $gs->getLibrarySongInfo($sfx, 'sfx', $sfxsLibrary);
				if($extraSFX && $extraSFX['isLocalSFX']) $sfxsUsage[$extraSFX['originalID']]++;
			}
		}
		/*
			Add this info to SQL
		*/
		$db->query("UPDATE songs SET levelsCount = 0");
		$db->query("UPDATE sfxs SET levelsCount = 0");
		foreach($songsUsage AS $song => $usage) {
			$addInfo = $db->prepare("UPDATE songs SET levelsCount = :usage WHERE ID = :songID");
			$addInfo->execute([':usage' => $usage, ':songID' => $song]);
		}
		foreach($sfxsUsage AS $sfx => $usage) {
			$addInfo = $db->prepare("UPDATE sfxs SET levelsCount = :usage WHERE ID = :sfxID");
			$addInfo->execute([':usage' => $usage, ':sfxID' => $sfx]);
		}
		$gs->logAction($accountID, 44, count($songsUsage), count($sfxsUsage));
		return true;
	}
	public static function doEverything($accountID, $checkForTime) {
		if(
			!self::autoban($accountID, $checkForTime) ||
			!self::updateCreatorPoints($accountID, $checkForTime) ||
			!self::fixUsernames($accountID, $checkForTime) ||
			!self::updateFriendsCount($accountID, $checkForTime) ||
			!self::miscFixes($accountID, $checkForTime) ||
			!self::updateSongsUsage($accountID, $checkForTime)
		) return false;
		return true;
	}
}
?>