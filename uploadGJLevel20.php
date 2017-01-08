<?php
error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$gjp = explode(";", explode(":", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$gameVersion = explode(";", explode(":", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0])[0];
$binaryVersion = explode(";", explode(":", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0])[0];
$userName = explode(";", explode(":", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0];
$levelID = explode(";", explode(":", htmlspecialchars($_POST["levelID"],ENT_QUOTES))[0])[0];
$levelName = explode(";", explode(":", htmlspecialchars($_POST["levelName"],ENT_QUOTES))[0])[0];
$levelDesc = explode(";", explode(":", htmlspecialchars($_POST["levelDesc"],ENT_QUOTES))[0])[0];
$levelVersion = explode(";", explode(":", htmlspecialchars($_POST["levelVersion"],ENT_QUOTES))[0])[0];
$levelLength = explode(";", explode(":", htmlspecialchars($_POST["levelLength"],ENT_QUOTES))[0])[0];
$audioTrack = explode(";", explode(":", htmlspecialchars($_POST["audioTrack"],ENT_QUOTES))[0])[0];
$auto = explode(";", explode(":", htmlspecialchars($_POST["auto"],ENT_QUOTES))[0])[0];
$password = explode(";", explode(":", htmlspecialchars($_POST["password"],ENT_QUOTES))[0])[0];
$original = explode(";", explode(":", htmlspecialchars($_POST["original"],ENT_QUOTES))[0])[0];
$twoPlayer = explode(";", explode(":", htmlspecialchars($_POST["twoPlayer"],ENT_QUOTES))[0])[0];
$songID = explode(";", explode(":", htmlspecialchars($_POST["songID"],ENT_QUOTES))[0])[0];
$objects = explode(";", explode(":", htmlspecialchars($_POST["objects"],ENT_QUOTES))[0])[0];
$coins = explode(";", explode(":", htmlspecialchars($_POST["coins"],ENT_QUOTES))[0])[0];
$requestedStars = explode(";", explode(":", htmlspecialchars($_POST["requestedStars"],ENT_QUOTES))[0])[0];
$extraString = explode(";", explode(":", htmlspecialchars($_POST["extraString"],ENT_QUOTES))[0])[0];
$levelString = explode(";", explode(":", htmlspecialchars($_POST["levelString"],ENT_QUOTES))[0])[0];
$levelInfo = explode(";", explode(":", htmlspecialchars($_POST["levelInfo"],ENT_QUOTES))[0])[0];
$secret = explode(";", explode(":", htmlspecialchars($_POST["secret"],ENT_QUOTES))[0])[0];
$accountID = "";
$id = explode(";", explode(":", htmlspecialchars($_POST["udid"],ENT_QUOTES))[0])[0];
if($_POST["accountID"]!=""){
	$id = explode(";", explode(":", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
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
$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName)
VALUES ('$register','$id', '$userName')");

$query->execute();
$userID = $db->lastInsertId();
}
$uploadDate = time();

$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID, extID)
VALUES ('$levelName','$gameVersion', '$binaryVersion', '$userName', '$levelDesc', '$levelVersion', '$levelLength', '$audioTrack', '$auto', '$password', '$original', '$twoPlayer', '$songID', '$objects', '$coins', '$requestedStars', '$extraString', '$levelString', '$levelInfo', '$secret', '$uploadDate','$userID', '$id')");


if($levelString != "" AND $levelName != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($register ==1){
	if($gjpresult == 1){
		$querye=$db->prepare("select * from levels where levelName = '".$levelName."' AND userID = ".$userID."");
		$querye->execute();
		$resulte = $querye->fetchAll();
		$levele = $resulte[0];
		$levelID = $levele["levelID"];
		$lvls = $querye->rowCount();
		if($lvls==1){
			$query = $db->prepare("UPDATE levels SET levelName='$levelName', gameVersion='$gameVersion',  binaryVersion='$binaryVersion', userName='$userName', levelDesc='$levelDesc', levelVersion='$levelVersion', levelLength='$levelLength', audioTrack='$audioTrack', auto='$auto', password='$password', original='$original', twoPlayer='$twoPlayer', songID='$songID', objects='$objects', coins='$coins', requestedStars='$requestedStars', extraString='$extraString', levelString='$levelString', levelInfo='$levelInfo', secret='$secret' WHERE levelName='$levelName' AND extID='$id'");	
			$query->execute();
			echo $levelID;
		}else{
			$query->execute();
			echo $db->lastInsertId();	
		}
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