<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$gjp = explode(":", explode("|", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$gameVersion = explode(":", explode("|", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0])[0];
$binaryVersion = explode(":", explode("|", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0])[0];
$userName = explode(":", explode("|", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0];
$secret = explode(":", explode("|", htmlspecialchars($_POST["secret"],ENT_QUOTES))[0])[0];
$coins = explode(":", explode("|", htmlspecialchars($_POST["coins"],ENT_QUOTES))[0])[0];
$stars = explode(":", explode("|", htmlspecialchars($_POST["stars"],ENT_QUOTES))[0])[0];
$demons = explode(":", explode("|", htmlspecialchars($_POST["demons"],ENT_QUOTES))[0])[0];
$icon = explode(":", explode("|", htmlspecialchars($_POST["icon"],ENT_QUOTES))[0])[0];
$color1 = explode(":", explode("|", htmlspecialchars($_POST["color1"],ENT_QUOTES))[0])[0];
$color2 = explode(":", explode("|", htmlspecialchars($_POST["color2"],ENT_QUOTES))[0])[0];
$iconType = explode(":", explode("|", htmlspecialchars($_POST["iconType"],ENT_QUOTES))[0])[0];
$userCoins = explode(":", explode("|", htmlspecialchars($_POST["userCoins"],ENT_QUOTES))[0])[0];
if($userCoins == ""){
	$userCoins = 0;
}
$special = explode(":", explode("|", htmlspecialchars($_POST["special"],ENT_QUOTES))[0])[0];
if($special == ""){
	$special = 0;
}
$accIcon = explode(":", explode("|", htmlspecialchars($_POST["accIcon"],ENT_QUOTES))[0])[0];
if($accIcon == ""){
	$accIcon = 0;
}
$accShip = explode(":", explode("|", htmlspecialchars($_POST["accShip"],ENT_QUOTES))[0])[0];
if($accShip == ""){
	$accShip = 0;
}
$accBall = explode(":", explode("|", htmlspecialchars($_POST["accBall"],ENT_QUOTES))[0])[0];
if($accBall == ""){
	$accBall = 0;
}
$accBird = explode(":", explode("|", htmlspecialchars($_POST["accBird"],ENT_QUOTES))[0])[0];
if($accBird == ""){
	$accBird = 0;
}
$accDart = explode(":", explode("|", htmlspecialchars($_POST["accDart"],ENT_QUOTES))[0])[0];
if($accDart == ""){
	$accDart = 0;
}
$accRobot = explode(":", explode("|", htmlspecialchars($_POST["accRobot"],ENT_QUOTES))[0])[0];
if($accRobot == ""){
	$accRobot = 0;
}
$accGlow = explode(":", explode("|", htmlspecialchars($_POST["accGlow"],ENT_QUOTES))[0])[0];
if($accGlow == ""){
	$accGlow = 0;
}
$accSpider = explode(":", explode("|", htmlspecialchars($_POST["accSpider"],ENT_QUOTES))[0])[0];
if($accSpider == ""){
	$accSpider = 0;
}
$accExplosion = explode(":", explode("|", htmlspecialchars($_POST["accExplosion"],ENT_QUOTES))[0])[0];
if($accExplosion == ""){
	$accExplosion = 0;
}
$diamonds = explode(":", explode("|", htmlspecialchars($_POST["diamonds"],ENT_QUOTES))[0])[0];
if($diamonds == ""){
	$diamonds = 0;
}
//continuing the accounts system
$accountID = "";
$id = explode(":", explode("|", htmlspecialchars($_POST["udid"],ENT_QUOTES))[0])[0];
if($_POST["accountID"]!="" AND $_POST["accountID"]!="0"){
	$id = explode(":", explode("|", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
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
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$hostname = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$hostname = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$hostname = $_SERVER['REMOTE_ADDR'];
	}

$query = $db->prepare("UPDATE users SET userName=:userName, coins=:coins,  secret=:secret, stars=:stars, demons=:demons, icon=:icon, color1=:color1, color2=:color2, iconType=:iconType, userCoins=:userCoins, special=:special, accIcon=:accIcon, accShip=:accShip, accBall=:accBall, accBird=:accBird, accDart=:accDart, accRobot=:accRobot, accGlow=:accGlow, IP=:hostname, lastPlayed=:uploadDate, accSpider=:accSpider, accExplosion=:accExplosion, diamonds=:diamonds WHERE userID=:userID");
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$id);
if($register ==1){
if($gjpresult == 1){
	$query->execute([':userName' => $userName, ':coins' => $coins, ':secret' => $secret, ':stars' => $stars, ':demons' => $demons, ':icon' => $icon, ':color1' => $color1, ':color2' => $color2, ':iconType' => $iconType, ':userCoins' => $userCoins, ':special' => $special, ':accIcon' => $accIcon, ':accShip' => $accShip, ':accBall' => $accBall, ':accBird' => $accBird, ':accDart' => $accDart, ':accRobot' => $accRobot, ':accGlow' => $accGlow, ':hostname' => $hostname, ':uploadDate' => $uploadDate, ':userID' => $userID, ':accSpider'=>$accSpider, ':accExplosion'=>$accExplosion, ':diamonds'=>$diamonds]);
	echo $userID;
}else{echo -1;}
}else{
	$query->execute([':userName' => $userName, ':coins' => $coins, ':secret' => $secret, ':stars' => $stars, ':demons' => $demons, ':icon' => $icon, ':color1' => $color1, ':color2' => $color2, ':iconType' => $iconType, ':userCoins' => $userCoins, ':special' => $special, ':accIcon' => $accIcon, ':accShip' => $accShip, ':accBall' => $accBall, ':accBird' => $accBird, ':accDart' => $accDart, ':accRobot' => $accRobot, ':accGlow' => $accGlow, ':hostname' => $hostname, ':uploadDate' => $uploadDate, ':userID' => $userID, ':accSpider'=>$accSpider, ':accExplosion'=>$accExplosion, ':diamonds'=>$diamonds]);
	echo $userID;
}
?>