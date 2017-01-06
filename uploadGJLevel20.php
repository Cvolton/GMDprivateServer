<?php
error_reporting(0);
include "connection.php";
require "incl/GJPCheck.php";
//here im getting all the data
//NOTE: Finish updating levels l8r
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$gameVersion = str_replace(":", "", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES));
$binaryVersion = str_replace(":", "", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES));
$userName = str_replace(":", "", htmlspecialchars($_POST["userName"],ENT_QUOTES));
$levelID = str_replace(":", "", htmlspecialchars($_POST["levelID"],ENT_QUOTES));
$levelName = str_replace(":", "", htmlspecialchars($_POST["levelName"],ENT_QUOTES));
$levelDesc = str_replace(":", "", htmlspecialchars($_POST["levelDesc"],ENT_QUOTES));
$levelVersion = str_replace(":", "", htmlspecialchars($_POST["levelVersion"],ENT_QUOTES));
$levelLength = str_replace(":", "", htmlspecialchars($_POST["levelLength"],ENT_QUOTES));
$audioTrack = str_replace(":", "", htmlspecialchars($_POST["audioTrack"],ENT_QUOTES));
$auto = str_replace(":", "", htmlspecialchars($_POST["auto"],ENT_QUOTES));
$password = str_replace(":", "", htmlspecialchars($_POST["password"],ENT_QUOTES));
$original = str_replace(":", "", htmlspecialchars($_POST["original"],ENT_QUOTES));
$twoPlayer = str_replace(":", "", htmlspecialchars($_POST["twoPlayer"],ENT_QUOTES));
$songID = str_replace(":", "", htmlspecialchars($_POST["songID"],ENT_QUOTES));
$objects = str_replace(":", "", htmlspecialchars($_POST["objects"],ENT_QUOTES));
$coins = str_replace(":", "", htmlspecialchars($_POST["coins"],ENT_QUOTES));
$requestedStars = str_replace(":", "", htmlspecialchars($_POST["requestedStars"],ENT_QUOTES));
$extraString = str_replace(":", "", htmlspecialchars($_POST["extraString"],ENT_QUOTES));
$levelString = str_replace(":", "", htmlspecialchars($_POST["levelString"],ENT_QUOTES));
$levelInfo = str_replace(":", "", htmlspecialchars($_POST["levelInfo"],ENT_QUOTES));
$secret = str_replace(":", "", htmlspecialchars($_POST["secret"],ENT_QUOTES));
$accountID = "";
$id = str_replace(":", "", htmlspecialchars($_POST["udid"],ENT_QUOTES));
if($_POST["accountID"]!=""){
	$id = str_replace(":", "", htmlspecialchars($_POST["accountID"],ENT_QUOTES));
	$register = 1;
}else{
	$register = 0;
}
$query2 = $db->prepare("SELECT * FROM users WHERE extID = '".$id."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$userIDalmost = $result[0];
$userID = $userIDalmost[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES ('$register','$id')");

$query->execute();
$userID = $db->lastInsertId();
}
$uploadDate = time();

$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID)
VALUES ('$levelName','$gameVersion', '$binaryVersion', '$userName', '$levelDesc', '$levelVersion', '$levelLength', '$audioTrack', '$auto', '$password', '$original', '$twoPlayer', '$songID', '$objects', '$coins', '$requestedStars', '$extraString', '$levelString', '$levelInfo', '$secret', '$uploadDate','$userID')");

if($levelString != "" AND $levelName != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($register ==1){
	if($gjpresult == 1){
		$query->execute();
		echo $db->lastInsertId();
	}else{
		echo -1;
	}
	}else{
		$query->execute();
		echo $db->lastInsertId();
	}
}else{
	echo -1;
}
?>