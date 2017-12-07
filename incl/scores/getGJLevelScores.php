<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
//here im getting all the data
$gjp = $ep->remove($_POST["gjp"]);
$accountID = $ep->remove($_POST["accountID"]);
$levelID = $ep->remove($_POST["levelID"]);
$percent = $ep->remove($_POST["percent"]);
$uploadDate = time();
if(isset($_POST["s1"])){
	$attempts = $_POST["s1"] - 8354;
}else{
	$attempts = 0;
}
if(isset($_POST["s9"])){
	$coins = $_POST["s9"] - 5819;
}else{
	$coins = 0;
}





//UPDATING SCORE
$userID = $gs->getUserID($accountID);
$query2 = $db->prepare("SELECT percent FROM levelscores WHERE accountID = :accountID AND levelID = :levelID");
$query2->execute([':accountID' => $accountID, ':levelID' => $levelID]);
$oldPercent = $query2->fetchColumn();
if($query2->rowCount() == 0) {
	$query = $db->prepare("INSERT INTO levelscores (accountID, levelID, percent, uploadDate, coins, attempts)
	VALUES (:accountID, :levelID, :percent, :uploadDate, :coins, :attempts)");
} else {
	if($oldPercent <= $percent){
		$query = $db->prepare("UPDATE levelscores SET percent=:percent, uploadDate=:uploadDate, coins=:coins, attempts=:attempts WHERE accountID=:accountID AND levelID=:levelID");
	}else{
		$query = $db->prepare("SELECT count(*) FROM levelscores WHERE percent=:percent AND uploadDate=:uploadDate AND accountID=:accountID AND levelID=:levelID AND coins = :coins AND attempts = :attempts");
	}
}
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query->execute([':accountID' => $accountID, ':levelID' => $levelID, ':percent' => $percent, ':uploadDate' => $uploadDate, ':coins' => $coins, ':attempts' => $attempts]);
	if($percent > 100){
		$query = $db->prepare("UPDATE users SET isBanned=1 WHERE extID = :accountID");
		$query->execute([':accountID' => $accountID]);
	}
}



//GETTING SCORES
if(!isset($_POST["type"])){
	$type = 1;
}else{
	$type = $_POST["type"];
}
switch($type){
	case 0:
		$friends = $gs->getFriends($accountID);
		$friends[] = $accountID;
		$friends = implode(",",$friends);
		$query2 = $db->prepare("SELECT accountID, uploadDate, percent, coins FROM levelscores WHERE levelID = :levelID AND accountID IN ($friends) ORDER BY percent DESC");
		$query2args = [':levelID' => $levelID];
		break;
	case 1:
		$query2 = $db->prepare("SELECT accountID, uploadDate, percent, coins FROM levelscores WHERE levelID = :levelID ORDER BY percent DESC");
		$query2args = [':levelID' => $levelID];
		break;
	case 2:
		$query2 = $db->prepare("SELECT accountID, uploadDate, percent, coins FROM levelscores WHERE levelID = :levelID AND uploadDate > :time ORDER BY percent DESC");
		$query2args = [':levelID' => $levelID, ':time' => time() - 604800];
		break;
	default:
		return -1;
		break;
}



$query2->execute($query2args);
$result = $query2->fetchAll();
foreach ($result as &$score) {
	$extID = $score["accountID"];
	$query2 = $db->prepare("SELECT userName, userID, icon, color1, color2, iconType, special, extID, isBanned FROM users WHERE extID = :extID");
	$query2->execute([':extID' => $extID]);
	$user = $query2->fetchAll();
	$user = $user[0];
	$time = date("d/m/Y G.i", $score["uploadDate"]);
	if($user["isBanned"]==0){
		if($score["percent"] == 100){
			$place = 1;
		}else if($score["percent"] > 75){
			$place = 2;
		}else{
			$place = 3;
		}
		echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["extID"].":3:".$score["percent"].":6:".$place.":13:".$score["coins"].":42:".$time."|";
	}
}
?>