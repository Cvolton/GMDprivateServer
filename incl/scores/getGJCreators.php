<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../lib/mainLib.php";
$gs = new mainLib();
require_once "../lib/exploitPatch.php";
$accountID = ExploitPatch::remove($_POST["accountID"]);
$type = ExploitPatch::remove($_POST["type"]);
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
$result = $query->fetchAll();
$xi = 0;
foreach($result as &$user) {
	$extid = is_numeric($user["extID"]) ? $user["extID"] : 0;
	$xi++;
	$user["userName"] = $gs->makeClanUsername($user);
	$pplstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"]."|";
}
$pplstring = substr($pplstring, 0, -1);
echo $pplstring;
?>