<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$accountID = !empty($_POST["accountID"]) ? GJPCheck::getAccountIDOrDie() : 0;
$targetAccountID = ExploitPatch::number($_POST["targetAccountID"]) ?: 0;
$targetUserID = $gs->getUserID($targetAccountID); // Forcefully creates users row for an account // i hope i will get accused of using ai because of comments 😊😊😊
$isSelf = $accountID == $targetAccountID;

$isBlocked = $db->prepare("SELECT count(*) FROM blocks WHERE (person1 = :accountID AND person2 = :targetAccountID) OR (person1 = :targetAccountID AND person2 = :accountID)");
$isBlocked->execute([":accountID" => $accountID, ":targetAccountID" => $targetAccountID]);
$isBlocked = $isBlocked->fetchColumn();
if($isBlocked) exit("-1");

$person = $db->prepare("SELECT *, accounts.userName AS accountUsername FROM users INNER JOIN accounts ON accounts.accountID = users.extID WHERE users.extID = :targetAccountID");
$person->execute([":targetAccountID" => $targetAccountID]);
$person = $person->fetch();
if(!$person) exit("-1");

$rank = $friendState = 0;

$isBanned = $gs->getPersonBan($person['extID'], $person['userID'], 0, $person['IP']);
if(!$isBanned) {
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
	
	$query = $db->prepare("SELECT count(*) FROM users WHERE ".$queryText." stars > :stars");
	$query->execute([':stars' => $person["stars"]]);
	if($query->rowCount() > 0) $rank = $query->fetchColumn() + 1;
}

$person['youtubeurl'] = mb_ereg_replace("(?!^@)[^a-zA-Z0-9_]", "", $person['youtubeurl']);
$person['twitter'] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $person['twitter']);
$person['twitch'] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $person['twitch']);
$person['instagram'] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $person['instagram']);
$person['tiktok'] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $person['tiktok']);
$person['discord'] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $person['discord']);
$person['custom'] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $person['custom']);
$creatorPoints = round($person["creatorPoints"], PHP_ROUND_HALF_DOWN);
$modBadge = $gs->getMaxValuePermission($targetAccountID, "modBadgeLevel");

if($isSelf) {
	$newMessagesCount = 0; // Will make threads count later
	$newNotifications = 0;
	
	$newFriendRequestsCount = $db->prepare("SELECT count(*) FROM friendreqs WHERE toAccountID = :accountID AND isNew != 2 AND uploadDate >= :timestamp");
	$newFriendRequestsCount->execute([":accountID" => $accountID, ":timestamp" => time() - 10368000]); // Friend requests expire after 120 days
	$newFriendRequestsCount = $newFriendRequestsCount->fetchColumn();
	
	$newFriendsCount = $db->prepare("SELECT count(*) FROM friendships WHERE (person1 = :accountID AND isNew2 = 1) OR (person2 = :accountID AND isNew1 = 1)");
	$newFriendsCount->execute([":accountID" => $accountID]);
	$newFriendsCount = $newFriendsCount->fetchColumn();
	
	$friendState = "0:38:".$newMessagesCount.":39:".$newFriendRequestsCount.":40:".$newFriendsCount;

	$followingCount = $db->prepare("SELECT count(*) FROM follows WHERE person1 = :accountID");
	$followingCount->execute([":accountID" => $accountID]);
	$followingCount = $followingCount->fetchColumn();

	$isFollowing = 0;
} else {
	$isFriends = $gs->isFriends($accountID, $targetAccountID);
	if($isFriends) $friendState = 1;
	else {
		$friendRequest = $db->prepare("SELECT * FROM friendreqs WHERE ((accountID = :accountID AND toAccountID = :targetAccountID) OR (accountID = :targetAccountID AND toAccountID = :accountID)) AND uploadDate >= :timestamp LIMIT 1");
		$friendRequest->execute([":accountID" => $accountID, ":targetAccountID" => $targetAccountID, ":timestamp" => time() - 10368000]);
		$friendRequest = $friendRequest->fetch();
		
		if($friendRequest["person1"] == $accountID) $friendState = 4;
		else {
			$uploadDate = $gs->makeTime($friendRequest["uploadDate"]);
			$friendState = "3:32:".$friendRequest["ID"].":35:".$friendRequest["comment"].":37:".$uploadDate;
		}
	}
}

if (!$isSelf && $accountID) {
	$isFollowing = $db->prepare("SELECT 1 FROM follows WHERE person1 = :accountID AND person2 = :targetAccountID LIMIT 1");
	$isFollowing->execute([":accountID" => $accountID, ":targetAccountID" => $targetAccountID]);
	$isFollowing = (int)(bool)$isFollowing->fetchColumn();
}

$person["accountUsername"] = $gs->makeClanUsername($person);
echo "1:".$person["accountUsername"].":2:".$person["userID"].":13:".$person["coins"].":17:".$person["userCoins"].":10:".$person["color1"].":11:".$person["color2"].":51:".$person["color3"].":3:".$person["stars"].":46:".$person["diamonds"].":52:".$person["moons"].":4:".$person["demons"].":8:".$creatorPoints.":18:".$person["mS"].":19:".$person["frS"].":50:".$person["cS"].":62:".$person["gF"].":63:".$person["gO"].":67:".$person["followersCount"].":65:".$newNotifications.":66:0:68:".$followingCount.":69:".$isFollowing.":70:1:20:".$person["youtubeurl"].":21:".$person["accIcon"].":22:".$person["accShip"].":23:".$person["accBall"].":24:".$person["accBird"].":25:".$person["accDart"].":26:".$person["accRobot"].":28:".$person["accGlow"].":43:".$person["accSpider"].":48:".$person["accExplosion"].":53:".$person["accSwing"].":54:".$person["accJetpack"].":30:".$rank.":16:".$person["extID"].":31:".$friendState.":44:".$person["twitter"].":45:".$person["twitch"].":59:".$person["instagram"].":60:".$person["tiktok"].":58:".$person["discord"].":61:".$person["custom"].":49:".$modBadge.":55:".$person["dinfo"].":56:".$person["sinfo"].":57:".$person["pinfo"].":29:1";
?>