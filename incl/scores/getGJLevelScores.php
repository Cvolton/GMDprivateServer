<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/mainLib.php";
require_once "../lib/automod.php";
$gs = new mainLib();

$accountID = GJPCheck::getAccountIDOrDie();
$levelID = ExploitPatch::number($_POST["levelID"]);
$percent = ExploitPatch::number($_POST["percent"]);
$uploadDate = time();

$attempts = !empty($_POST["s1"]) ? $_POST["s1"] - 8354 : 0;
$clicks = !empty($_POST["s2"]) ? $_POST["s2"] - 3991 : 0;
$time = !empty($_POST["s3"]) ? $_POST["s3"] - 4085 : 0;

$progresses = !empty($_POST["s6"]) ? XORCipher::cipher(ExploitPatch::url_base64_decode($_POST["s6"]), 41274) : 0;
$coins = !empty($_POST["s9"]) ? $_POST["s9"] - 5819 : 0;
$dailyID = !empty($_POST["s10"]) ? $_POST["s10"] : 0;
if(!Automod::isLevelsDisabled(2)) {
	$condition = ($dailyID > 0) ? ">" : "=";
	$query2 = $db->prepare("SELECT percent FROM levelscores WHERE accountID = :accountID AND levelID = :levelID AND dailyID $condition 0");
	$query2->execute([':accountID' => $accountID, ':levelID' => $levelID]);
	$oldPercent = $query2->fetchColumn();
	if($query2->rowCount() == 0) {
		$gs->logAction($accountID, 34, $levelID, $percent, $coins, $attempts, $clicks, $time);
		$query = $db->prepare("INSERT INTO levelscores (accountID, levelID, percent, uploadDate, coins, attempts, clicks, time, progresses, dailyID)
		VALUES (:accountID, :levelID, :percent, :uploadDate, :coins, :attempts, :clicks, :time, :progresses, :dailyID)");
	} else {
		if($oldPercent < $percent) {
			$gs->logAction($accountID, 35, $levelID, $percent, $coins, $attempts, $clicks, $time);
			$query = $db->prepare("UPDATE levelscores SET percent=:percent, uploadDate=:uploadDate, coins=:coins, attempts=:attempts, clicks=:clicks, time=:time, progresses=:progresses, dailyID=:dailyID WHERE accountID=:accountID AND levelID=:levelID AND dailyID $condition 0");
		} else {
			$query = $db->prepare("SELECT count(*) FROM levelscores WHERE percent=:percent AND uploadDate=:uploadDate AND accountID=:accountID AND levelID=:levelID AND coins = :coins AND attempts = :attempts AND clicks = :clicks AND time = :time AND progresses = :progresses AND dailyID = :dailyID");
		}
	}

	$query->execute([':accountID' => $accountID, ':levelID' => $levelID, ':percent' => $percent, ':uploadDate' => $uploadDate, ':coins' => $coins, ':attempts' => $attempts, ':clicks' => $clicks, ':time' => $time, ':progresses' => $progresses, ':dailyID' => $dailyID]);
}
if($percent > 100 || $percent < 0) $gs->banPerson(0, $accountID, 'Bro tried to post invalid percent value to level leaderboards. ('.$percent.')', 0, 0, 2147483647);

//GETTING SCORES
$type = $_POST['type'] ?? 1;
switch($type) {
	case 0:
		$friends = $gs->getFriends($accountID);
		$friends[] = $accountID;
		$friends = implode(",", $friends);
		$query2 = $db->prepare("SELECT accountID, uploadDate, percent, coins FROM levelscores WHERE dailyID $condition 0 AND levelID = :levelID AND accountID IN ($friends) ORDER BY percent DESC");
		$query2args = [':levelID' => $levelID];
		break;
	case 1:
		$query2 = $db->prepare("SELECT accountID, uploadDate, percent, coins FROM levelscores WHERE dailyID $condition 0 AND levelID = :levelID ORDER BY percent DESC");
		$query2args = [':levelID' => $levelID];
		break;
	case 2:
		$query2 = $db->prepare("SELECT accountID, uploadDate, percent, coins FROM levelscores WHERE dailyID $condition 0 AND levelID = :levelID AND uploadDate > :time ORDER BY percent DESC");
		$query2args = [':levelID' => $levelID, ':time' => time() - 604800];
		break;
	default:
		exit('-1');
		break;
}
$query2->execute($query2args);
$result = $query2->fetchAll();
foreach($result as &$score) {
	$extID = $score["accountID"];
	$query2 = $db->prepare("SELECT userName, extID, userID, icon, color1, color2, color3, iconType, special, clan, IP FROM users WHERE extID = :extID");
	$query2->execute([':extID' => $extID]);
	$user = $query2->fetch();
	$time = $gs->makeTime($score["uploadDate"]);
	$isBanned = $gs->getPersonBan($user['extID'], $user['userID'], 0, $user['IP']);
	if(!$isBanned) {
		if($score["percent"] == 100) $place = 1;
		else if($score["percent"] > 75) $place = 2;
		else $place = 3;
		$user["userName"] = $gs->makeClanUsername($user);
		echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":51:".$user["color3"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["extID"].":3:".$score["percent"].":6:".$place.":13:".$score["coins"].":42:".$time."|";
	}
}
?>