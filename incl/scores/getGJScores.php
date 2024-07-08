<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
include "../../config/misc.php";
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
if(!empty($_POST["accountID"])) {
	$accountID = GJPCheck::getAccountIDOrDie();
} else {
	$accountID = ExploitPatch::remove($_POST["udid"]);
	if(is_numeric($accountID)) exit("-1");
}

$type = ExploitPatch::remove($_POST["type"]);
if($type == "top" OR $type == "creators" OR $type == "relative"){
	if($type == "top") {
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
		$extIDsString = "'".implode("','", $extIDs)."'";
		$userIDsString = "'".implode("','", $userIDs)."'";
		$bannedIPsString = implode("|", $bannedIPs);
		$queryArray = [];
		if($extIDsString != '') $queryArray[] = "extID NOT IN (".$extIDsString.")";
		if($userIDsString != '') $queryArray[] = "userID NOT IN (".$userIDsString.")";
		if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
		$queryText = !empty($queryArray) ? '('.implode(' AND ', $queryArray).') AND' : '';
		$query = $db->prepare("SELECT * FROM users WHERE ".$queryText." stars > :stars ORDER BY stars DESC LIMIT 100");
		$query->execute([':stars' => $leaderboardMinStars]);
	}
	if($type == "creators") {
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
		$extIDsString = "'".implode("','", $extIDs)."'";
		$userIDsString = "'".implode("','", $userIDs)."'";
		$bannedIPsString = implode("|", $bannedIPs);
		$queryArray = [];
		if($extIDsString != '') $queryArray[] = "extID NOT IN (".$extIDsString.")";
		if($userIDsString != '') $queryArray[] = "userID NOT IN (".$userIDsString.")";
		if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
		$queryText = !empty($queryArray) ? '('.implode(' AND ', $queryArray).') AND' : '';
		$query = $db->prepare("SELECT * FROM users WHERE ".$queryText." creatorPoints > 0 ORDER BY creatorPoints DESC LIMIT 100");
		$query->execute();
	}
	if($type == "relative") {
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
		$extIDsString = "'".implode("','", $extIDs)."'";
		$userIDsString = "'".implode("','", $userIDs)."'";
		$bannedIPsString = implode("|", $bannedIPs);
		$queryArray = [];
		if($extIDsString != '') $queryArray[] = "extID NOT IN (".$extIDsString.")";
		if($userIDsString != '') $queryArray[] = "userID NOT IN (".$userIDsString.")";
		if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
		$queryText = !empty($queryArray) ? 'AND ('.implode(' AND ', $queryArray).')' : '';
		$query = "SELECT * FROM users WHERE extID = :accountID";
		$query = $db->prepare($query);
		$query->execute([':accountID' => $accountID]);
		$result = $query->fetchAll();
		$user = $result[0];
		$stars = $user["stars"];
		if($_POST["count"]) $count = ExploitPatch::remove($_POST["count"]);
		else $count = 50;
		$count = floor($count / 2);
		$query = $db->prepare("SELECT	A.* FROM	(
			(
				SELECT	*	FROM users
				WHERE stars <= :stars
				".$queryText."
				ORDER BY stars DESC
				LIMIT $count
			)
			UNION
			(
				SELECT * FROM users
				WHERE stars >= :stars
				".$queryText."
				ORDER BY stars ASC
				LIMIT $count
			)
		) as A
		ORDER BY A.stars DESC");
		$query->execute([':stars' => $stars]);
	}
	$result = $query->fetchAll();
	if($type == "relative") {
		$user = $result[0];
		$extid = $user["extID"];
		$e = "SET @rownum := 0;";
		$query = $db->prepare($e);
		$query->execute();
		$queryText = trim($queryText) != 'AND' ? 'WHERE '.substr($queryText, 4) : '';
		$f = "SELECT rank, stars FROM (
							SELECT @rownum := @rownum + 1 AS rank, stars, extID
							FROM users ".$queryText." ORDER BY stars DESC
							) as result WHERE extID=:extid";
		$query = $db->prepare($f);
		$query->execute([':extid' => $extid]);
		$leaderboard = $query->fetchAll();
		$leaderboard = $leaderboard[0];
		$xi = $leaderboard["rank"] - 1;
	}
	foreach($result as &$user) {
		$xi++;
		$user["userName"] = $gs->makeClanUsername($user);
		$extid = is_numeric($user['extID']) ? $user['extID'] : 0;
		if($date == "01-04" && $sakujes) $lbstring .= "1:sakujes:2:".$user["userID"].":13:999:17:999:6:".$xi.":9:9:10:9:11:8:14:1:15:3:16:".$extid.":3:999:8:99999:4:999:7:".$extid.":46:99999|";
		else $lbstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":51:".$user["color3"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"].":52:".$user["moons"]."|";
	}
}
if($type == "friends"){
	$query = "SELECT * FROM friendships WHERE person1 = :accountID OR person2 = :accountID";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	$people = "";
	foreach ($result as &$friendship) {
		$person = $friendship["person1"];
		if($friendship["person1"] == $accountID){
			$person = $friendship["person2"];
		}
		$people .= ",".$person;
	}
	$query = "SELECT * FROM users WHERE extID IN (:accountID $people ) ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	foreach($result as &$user) {
		$xi++;
		$user["userName"] = $gs->makeClanUsername($user);
		$extid = is_numeric($user['extID']) ? $user['extID'] : 0;
		if($date == "01-04" && $sakujes) $lbstring .= "1:sakujes:2:".$user["userID"].":13:999:17:999:6:".$xi.":9:9:10:9:11:8:14:1:15:3:16:".$extid.":3:999:8:99999:4:999:7:".$extid.":46:99999|";
		else $lbstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":51:".$user["color3"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"].":52:".$user["moons"]."|";
	}
}
if($lbstring == ""){
	exit("-1");
}
$lbstring = substr($lbstring, 0, -1);
echo $lbstring;
?>