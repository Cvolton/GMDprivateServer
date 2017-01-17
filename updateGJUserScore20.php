<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$gameVersion = htmlspecialchars($_POST["gameVersion"],ENT_QUOTES);
$binaryVersion = htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES);
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$secret = htmlspecialchars($_POST["secret"],ENT_QUOTES);
$coins = htmlspecialchars($_POST["coins"],ENT_QUOTES);
$stars = htmlspecialchars($_POST["stars"],ENT_QUOTES);
$demons = htmlspecialchars($_POST["demons"],ENT_QUOTES);
$icon = htmlspecialchars($_POST["icon"],ENT_QUOTES);
$color1 = htmlspecialchars($_POST["color1"],ENT_QUOTES);
$color2 = htmlspecialchars($_POST["color2"],ENT_QUOTES);
$iconType = htmlspecialchars($_POST["iconType"],ENT_QUOTES);
$userCoins = htmlspecialchars($_POST["userCoins"],ENT_QUOTES);
$special = htmlspecialchars($_POST["special"],ENT_QUOTES);
$accIcon = htmlspecialchars($_POST["accIcon"],ENT_QUOTES);
$accShip = htmlspecialchars($_POST["accShip"],ENT_QUOTES);
$accBall = htmlspecialchars($_POST["accBall"],ENT_QUOTES);
$accBird = htmlspecialchars($_POST["accBird"],ENT_QUOTES);
$accDart = htmlspecialchars($_POST["accDart"],ENT_QUOTES);
$accRobot = htmlspecialchars($_POST["accRobot"],ENT_QUOTES);
$accGlow = htmlspecialchars($_POST["accGlow"],ENT_QUOTES);
$accSpider = htmlspecialchars($_POST["accSpider"],ENT_QUOTES);
$accExplosion = htmlspecialchars($_POST["accExplosion"],ENT_QUOTES);
$diamonds = htmlspecialchars($_POST["diamonds"],ENT_QUOTES);
//continuing the accounts system
$accountID = "";
$id = htmlspecialchars($_POST["udid"],ENT_QUOTES);
if($_POST["accountID"]!=""){
	$id = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
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