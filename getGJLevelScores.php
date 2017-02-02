<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
$percent = htmlspecialchars($_POST["percent"],ENT_QUOTES);
$uploadDate = time();
//UPDATING SCORE
$query2 = $db->prepare("SELECT * FROM users WHERE extID = :accountID");
$query2->execute([':accountID' => $accountID]);
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$userIDalmost = $result[0];
$userID = $userIDalmost[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES (1, :accountID)");

$query->execute([':accountID' => $accountID]);
$userID = $db->lastInsertId();
}

$query2 = $db->prepare("SELECT * FROM levelscores WHERE accountID = :accountID AND levelID = :levelID");
$query2->execute([':accountID' => $accountID, ':levelID' => $levelID]);
$result = $query2->fetchAll();
if ($query2->rowCount() == 0) {
$query = $db->prepare("INSERT INTO levelscores (accountID, levelID, percent, uploadDate)
VALUES (:accountID, :levelID, :percent, :uploadDate)");
} else {
	if($result[0]["percent"] < $percent){
		$query = $db->prepare("UPDATE levelscores SET percent=:percent, uploadDate=:uploadDate WHERE accountID=:accountID AND levelID=:levelID");
	}else{
		$query = $db->prepare("SELECT * FROM levelscores WHERE percent=:percent AND uploadDate=:uploadDate AND accountID=:accountID AND levelID=:levelID");
	}
}
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
$query->execute([':accountID' => $accountID, ':levelID' => $levelID, ':percent' => $percent, ':uploadDate' => $uploadDate]);
}



//GETTING SCORES


$query2 = $db->prepare("SELECT * FROM levelscores WHERE levelID = :levelID ORDER BY percent DESC");
$query2->execute([':levelID' => $levelID]);
$result = $query2->fetchAll();
$x = 1;
foreach ($result as &$score) {
	$extID = $score["accountID"];
	$query2 = $db->prepare("SELECT * FROM users WHERE extID = :extID");
	$query2->execute([':extID' => $extID]);
	$user = $query2->fetchAll();
	$user = $user[0];
	$time = date("d/m/Y G.i", $score["uploadDate"]);
	if($user["isBanned"]==0){
		echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["extID"].":3:".$score["percent"].":6:".$x.":42:".$time."|";
	}
}
?>