<?php
error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$gjp = explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0];
$gameVersion = explode(";", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0];
$binaryVersion = explode(";", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0];
$userName = explode(";", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0];
$secret = explode(";", htmlspecialchars($_POST["secret"],ENT_QUOTES))[0];
$coins = explode(";", htmlspecialchars($_POST["coins"],ENT_QUOTES))[0];
$stars = explode(";", htmlspecialchars($_POST["stars"],ENT_QUOTES))[0];
$demons = explode(";", htmlspecialchars($_POST["demons"],ENT_QUOTES))[0];
$icon = explode(";", htmlspecialchars($_POST["icon"],ENT_QUOTES))[0];
$color1 = explode(";", htmlspecialchars($_POST["color1"],ENT_QUOTES))[0];
$color2 = explode(";", htmlspecialchars($_POST["color2"],ENT_QUOTES))[0];
$iconType = explode(";", htmlspecialchars($_POST["iconType"],ENT_QUOTES))[0];
$userCoins = explode(";", htmlspecialchars($_POST["userCoins"],ENT_QUOTES))[0];
$special = explode(";", htmlspecialchars($_POST["special"],ENT_QUOTES))[0];
$accIcon = explode(";", htmlspecialchars($_POST["accIcon"],ENT_QUOTES))[0];
$accShip = explode(";", htmlspecialchars($_POST["accShip"],ENT_QUOTES))[0];
$accBall = explode(";", htmlspecialchars($_POST["accBall"],ENT_QUOTES))[0];
$accBird = explode(";", htmlspecialchars($_POST["accBird"],ENT_QUOTES))[0];
$accDart = explode(";", htmlspecialchars($_POST["accDart"],ENT_QUOTES))[0];
$accRobot = explode(";", htmlspecialchars($_POST["accRobot"],ENT_QUOTES))[0];
$accGlow = explode(";", htmlspecialchars($_POST["accGlow"],ENT_QUOTES))[0];
//continuing the accounts system
$accountID = "";
$id = explode(";", htmlspecialchars($_POST["udid"],ENT_QUOTES))[0];
if($_POST["accountID"]!=""){
	$id = explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0];
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
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$query = $db->prepare("UPDATE users SET userName='$userName', coins='$coins',  secret='$secret', stars='$stars', demons='$demons', icon='$icon', color1='$color1', color2='$color2', iconType='$iconType', userCoins='$userCoins', special='$special',
accIcon='$accIcon', accShip='$accShip', accBall='$accBall', accBird='$accBird', accDart='$accDart', accRobot='$accRobot', accGlow='$accGlow', IP='$hostname', lastPlayed='$uploadDate' WHERE userID='$userID'");
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$id);
if($register ==1){
if($gjpresult == 1){
	$query->execute();
	echo $userID;
}else{echo -1;}
}else{
	$query->execute();
	echo $userID;
}
?>