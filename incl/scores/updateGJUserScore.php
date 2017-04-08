<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
//here im getting all the data
$gjp = $ep->remove($_POST["gjp"]);
if($_POST["gameVersion"]){
	$gameVersion = $ep->remove($_POST["gameVersion"]);
}else{
	$gameVersion = 1;
}
$binaryVersion = $ep->remove($_POST["binaryVersion"]);
$userName = $ep->remove($_POST["userName"]);
$userName = preg_replace("/[^A-Za-z0-9 ]/", '', $userName);
$secret = $ep->remove($_POST["secret"]);
if($_POST["coins"] != ""){
	$coins = $ep->remove($_POST["coins"]);
}else{
	$coins = -1;
}
$stars = $ep->remove($_POST["stars"]);
$demons = $ep->remove($_POST["demons"]);
$icon = $ep->remove($_POST["icon"]);
$color1 = $ep->remove($_POST["color1"]);
$color2 = $ep->remove($_POST["color2"]);
if($_POST["iconType"]){
	$iconType = $ep->remove($_POST["iconType"]);
}else{
	$iconType = 0;
}
$userCoins = $ep->remove($_POST["userCoins"]);
if($userCoins == ""){
	$userCoins = -1;
}
$special = $ep->remove($_POST["special"]);
if($special == ""){
	$special = 0;
}
$accIcon = $ep->remove($_POST["accIcon"]);
if($accIcon == ""){
	$accIcon = 0;
}
$accShip = $ep->remove($_POST["accShip"]);
if($accShip == ""){
	$accShip = 0;
}
$accBall = $ep->remove($_POST["accBall"]);
if($accBall == ""){
	$accBall = 0;
}
$accBird = $ep->remove($_POST["accBird"]);
if($accBird == ""){
	$accBird = 0;
}
$accDart = $ep->remove($_POST["accDart"]);
if($accDart == ""){
	$accDart = 0;
}
$accRobot = $ep->remove($_POST["accRobot"]);
if($accRobot == ""){
	$accRobot = 0;
}
$accGlow = $ep->remove($_POST["accGlow"]);
if($accGlow == ""){
	$accGlow = 0;
}
$accSpider = $ep->remove($_POST["accSpider"]);
if($accSpider == ""){
	$accSpider = 0;
}
$accExplosion = $ep->remove($_POST["accExplosion"]);
if($accExplosion == ""){
	$accExplosion = 0;
}
$diamonds = $ep->remove($_POST["diamonds"]);
if($diamonds == ""){
	$diamonds = -1;
}
//continuing the accounts system
$accountID = "";
$id = $ep->remove($_POST["udid"]);
if($_POST["accountID"]!="" AND $_POST["accountID"]!="0"){
	$id = $ep->remove($_POST["accountID"]);
	$register = 1;
}else{
	$register = 0;
}
$userID = $gs->getUserID($id, $userName);
$uploadDate = time();
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$hostname = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$hostname = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$hostname = $_SERVER['REMOTE_ADDR'];
	}
$query = $db->prepare("SELECT stars,coins,demons,userCoins,diamonds FROM users WHERE userID=:userID LIMIT 1"); //getting differences
$query->execute([':userID' => $userID]);
$old = $query->fetch();
$starsdiff = $stars - $old["stars"];
$coindiff = $coins - $old["coins"];
$demondiff = $demons - $old["demons"];
$ucdiff = $userCoins - $old["userCoins"];
$diadiff = $diamonds - $old["diamonds"];
$query2 = $db->prepare("INSERT INTO actions (type, value, timestamp, account, value2, value3, value4, value5) 
									 VALUES ('9',:stars,:timestamp,:account,:coinsd, :demon, :usrco, :diamond)"); //creating the action
$query = $db->prepare("UPDATE users SET gameVersion=:gameVersion, userName=:userName, coins=:coins,  secret=:secret, stars=:stars, demons=:demons, icon=:icon, color1=:color1, color2=:color2, iconType=:iconType, userCoins=:userCoins, special=:special, accIcon=:accIcon, accShip=:accShip, accBall=:accBall, accBird=:accBird, accDart=:accDart, accRobot=:accRobot, accGlow=:accGlow, IP=:hostname, lastPlayed=:uploadDate, accSpider=:accSpider, accExplosion=:accExplosion, diamonds=:diamonds WHERE userID=:userID");
$GJPCheck = new GJPCheck(); //gjp check
$gjpresult = $GJPCheck->check($gjp,$id);
if($register ==1){
	if($gjpresult == 1){
		$query->execute([':gameVersion' => $gameVersion, ':userName' => $userName, ':coins' => $coins, ':secret' => $secret, ':stars' => $stars, ':demons' => $demons, ':icon' => $icon, ':color1' => $color1, ':color2' => $color2, ':iconType' => $iconType, ':userCoins' => $userCoins, ':special' => $special, ':accIcon' => $accIcon, ':accShip' => $accShip, ':accBall' => $accBall, ':accBird' => $accBird, ':accDart' => $accDart, ':accRobot' => $accRobot, ':accGlow' => $accGlow, ':hostname' => $hostname, ':uploadDate' => $uploadDate, ':userID' => $userID, ':accSpider'=>$accSpider, ':accExplosion'=>$accExplosion, ':diamonds'=>$diamonds]);
		$query2->execute([':timestamp' => time(), ':stars' => $starsdiff, ':account' => $userID, ':coinsd' => $coindiff, ':demon' => $demondiff, ':usrco' => $ucdiff, ':diamond' => $diadiff]);
		echo $userID;
	}else{
		echo -1;
	}
}else{
	$query->execute([':gameVersion' => $gameVersion, ':userName' => $userName, ':coins' => $coins, ':secret' => $secret, ':stars' => $stars, ':demons' => $demons, ':icon' => $icon, ':color1' => $color1, ':color2' => $color2, ':iconType' => $iconType, ':userCoins' => $userCoins, ':special' => $special, ':accIcon' => $accIcon, ':accShip' => $accShip, ':accBall' => $accBall, ':accBird' => $accBird, ':accDart' => $accDart, ':accRobot' => $accRobot, ':accGlow' => $accGlow, ':hostname' => $hostname, ':uploadDate' => $uploadDate, ':userID' => $userID, ':accSpider'=>$accSpider, ':accExplosion'=>$accExplosion, ':diamonds'=>$diamonds]);
	$query2->execute([':timestamp' => time(), ':stars' => $starsdiff, ':account' => $userID, ':coinsd' => $coindiff, ':demon' => $demondiff, ':usrco' => $ucdiff, ':diamond' => $diadiff]);
	echo $userID;
}
?>