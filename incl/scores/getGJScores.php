<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/mainLib.php";
if(!isset($sakujes)) global $sakujes;
if(!isset($leaderboardMinStars)) global $leaderboardMinStars;
if($leaderboardMinStars == 0) $leaderboardMinStars = 1;
$gs = new mainLib();
$stars = 0;
$count = 0;
$xi = 0;
$lbstring = "";
$accountID = $gs->getIDFromPost();
$type = ExploitPatch::charclean($_POST["type"]);
switch($type) {
	case 'top':
		$bans = $gs->getAllBansOfBanType(0);
		$extIDs = $userIDs = $bannedIPs = [];
		foreach($bans AS &$ban) {
			switch($ban['personType']) {
				case 0:
					$extIDs[] = $ban['person'];
					break;
				case 1:
					$userIDs[] = $ban['person'];
					break;
				case 2:
					$bannedIPs[] = $gs->IPForBan($ban['person'], true);
					break;
			}
		}
		$extIDsString = implode("','", $extIDs);
		$userIDsString = implode("','", $userIDs);
		$bannedIPsString = implode("|", $bannedIPs);
		$queryArray = [];
		if(!empty($extIDsString)) $queryArray[] = "extID NOT IN ('".$extIDsString."')";
		if(!empty($userIDsString)) $queryArray[] = "userID NOT IN ('".$userIDsString."')";
		if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
		$queryText = !empty($queryArray) ? '('.implode(' AND ', $queryArray).') AND' : '';
		$query = $db->prepare("SELECT * FROM users WHERE ".$queryText." stars >= :stars ORDER BY stars + moons DESC LIMIT 100");
		$query->execute([':stars' => $leaderboardMinStars]);
		break;
	case 'creators':
		$bans = $gs->getAllBansOfBanType(1);
		$extIDs = $userIDs = $bannedIPs = [];
		foreach($bans AS &$ban) {
			switch($ban['personType']) {
				case 0:
					$extIDs[] = $ban['person'];
					break;
				case 1:
					$userIDs[] = $ban['person'];
					break;
				case 2:
					$bannedIPs[] = $gs->IPForBan($ban['person'], true);
					break;
			}
		}
		$extIDsString = implode("','", $extIDs);
		$userIDsString = implode("','", $userIDs);
		$bannedIPsString = implode("|", $bannedIPs);
		$queryArray = [];
		if(!empty($extIDsString)) $queryArray[] = "extID NOT IN ('".$extIDsString."')";
		if(!empty($userIDsString)) $queryArray[] = "userID NOT IN ('".$userIDsString."')";
		if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
		$queryText = !empty($queryArray) ? '('.implode(' AND ', $queryArray).') AND' : '';
		$query = $db->prepare("SELECT * FROM users WHERE ".$queryText." creatorPoints > 0 ORDER BY creatorPoints DESC LIMIT 100");
		$query->execute();
		break;
	case 'relative':
		if(!$moderatorsListInGlobal) {
			$bans = $gs->getAllBansOfBanType(0);
			$extIDs = $userIDs = $bannedIPs = [];
			foreach($bans AS &$ban) {
				switch($ban['personType']) {
					case 0:
						$extIDs[] = $ban['person'];
						break;
					case 1:
						$userIDs[] = $ban['person'];
						break;
					case 2:
						$bannedIPs[] = $gs->IPForBan($ban['person'], true);
						break;
				}
			}
			$extIDsString = implode("','", $extIDs);
			$userIDsString = implode("','", $userIDs);
			$bannedIPsString = implode("|", $bannedIPs);
			$queryArray = [];
			if(!empty($extIDsString)) $queryArray[] = "extID NOT IN ('".$extIDsString."')";
			if(!empty($userIDsString)) $queryArray[] = "userID NOT IN ('".$userIDsString."')";
			if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
			$queryText = !empty($queryArray) ? 'AND ('.implode(' AND ', $queryArray).')' : '';
			$query = "SELECT * FROM users WHERE extID = :accountID";
			$query = $db->prepare($query);
			$query->execute([':accountID' => $accountID]);
			$user = $query->fetch();
			$stars = $user["stars"];
			$count = $_POST["count"] ? ExploitPatch::number($_POST["count"]) : 50;
			$count = floor($count / 2);
			$query = $db->prepare("SELECT A.* FROM (
				(
					SELECT * FROM users
					WHERE stars <= :stars
					".$queryText."
					ORDER BY stars + moons DESC
					LIMIT $count
				)
				UNION
				(
					SELECT * FROM users
					WHERE stars >= :stars
					".$queryText."
					ORDER BY stars + moons ASC
					LIMIT $count
				)
			) as A
			ORDER BY A.stars DESC");
		$query->execute([':stars' => $stars]);
		} else {
			$query = $db->prepare("SELECT * FROM users INNER JOIN roleassign ON users.extID = roleassign.accountID ORDER BY users.userName ASC");
			$query ->execute();
		}
		break;
	case 'friends':
		$query = "SELECT * FROM friendships WHERE person1 = :accountID OR person2 = :accountID";
		$query = $db->prepare($query);
		$query->execute([':accountID' => $accountID]);
		$result = $query->fetchAll();
		$people = "";
		foreach($result as &$friendship) {
			$person = $friendship["person2"] == $accountID ? $friendship["person1"] : $friendship["person2"];
			$people .= ",".$person;
		}
		$query = "SELECT * FROM users WHERE extID IN (:accountID $people ) ORDER BY stars DESC";
		$query = $db->prepare($query);
		$query->execute([':accountID' => $accountID]);
		break;
	case 'week':
		$bans = $gs->getAllBansOfBanType(0);
		$extIDs = $userIDs = $bannedIPs = [];
		foreach($bans AS &$ban) {
			switch($ban['personType']) {
				case 0:
					$extIDs[] = $ban['person'];
					break;
				case 1:
					$userIDs[] = $ban['person'];
					break;
				case 2:
					$bannedIPs[] = $gs->IPForBan($ban['person'], true);
					break;
			}
		}
		$extIDsString = implode("','", $extIDs);
		$userIDsString = implode("','", $userIDs);
		$bannedIPsString = implode("|", $bannedIPs);
		$queryArray = [];
		if(!empty($extIDsString)) $queryArray[] = "extID NOT IN ('".$extIDsString."')";
		if(!empty($userIDsString)) $queryArray[] = "userID NOT IN ('".$userIDsString."')";
		if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
		$queryText = !empty($queryArray) ? 'AND ('.implode(' AND ', $queryArray).')' : '';
		$query = $db->prepare("SELECT users.*, SUM(actions.value) AS stars, SUM(actions.value2) AS coins, SUM(actions.value3) AS demons FROM actions INNER JOIN users ON actions.account = users.extID WHERE type = '9' AND timestamp > :time ".$queryText." AND actions.value > 0 GROUP BY (stars) DESC ORDER BY stars + moons DESC LIMIT 100");
		$query->execute([':time' => time() - 604800]);
		break;
}
$result = $query->fetchAll();
if($type == "relative") {
	if(!$moderatorsListInGlobal) {
		$user = $result[0];
		$extid = $user["extID"];
		$e = "SET @rownum := 0;";
		$query = $db->prepare($e);
		$query->execute();
		$queryText = !empty($queryText) && trim($queryText) != 'AND' ? 'WHERE '.substr($queryText, 4) : '';
		$f = "SELECT rank, stars FROM (
							SELECT @rownum := @rownum + 1 AS rank, stars, extID
							FROM users ".$queryText." ORDER BY stars + moons DESC
							) as result WHERE extID = :extid";
		$query = $db->prepare($f);
		$query->execute([':extid' => $extid]);
		$leaderboard = $query->fetchAll();
		$leaderboard = $leaderboard[0];
		$xi = $leaderboard["rank"] - 1;
	} else $lbstring = '1:---Moderators---:2:0:13:0:17:0:6:0:9:0:10:0:11:0:51:0:14:0:15:0:16:0:3:0:8:0:4:0:7:0:46:0:52:0|';
}
foreach($result as &$user) {
	$xi++;
	$user["userName"] = $gs->makeClanUsername($user);
	$extid = is_numeric($user['extID']) ? $user['extID'] : 0;
	if($date == "01-04" && $sakujes) $lbstring .= "1:sakujes:2:".$user["userID"].":13:999:17:999:6:".$xi.":9:9:10:9:11:8:14:1:15:3:16:".$extid.":3:999:8:99999:4:999:7:".$extid.":46:99999|";
	else $lbstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":51:".$user["color3"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"].":52:".$user["moons"]."|";
}
if($lbstring == "") exit("-1");
echo substr($lbstring, 0, -1);
?>