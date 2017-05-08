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
if(!empty($_POST["gameVersion"])){
	$gameVersion = $ep->remove($_POST["gameVersion"]);
}else{
	$gameVersion = 1;
}
if(!empty($_POST["binaryVersion"])){
	$binaryVersion = $ep->remove($_POST["binaryVersion"]);
}else{
	$binaryVersion = 1;
}
if(!empty($_POST["coins"])){
	$coins = $ep->remove($_POST["coins"]);
}else{
	$coins = 0;
}
if(!isset($_POST["userName"]) OR !isset($_POST["secret"]) OR !isset($_POST["stars"]) OR !isset($_POST["demons"]) OR !isset($_POST["icon"]) OR !isset($_POST["color1"]) OR !isset($_POST["color2"])){
	exit("-1");
}
$userName = $ep->remove($_POST["userName"]);
$userName = preg_replace("/[^A-Za-z0-9 ]/", '', $userName);
$secret = $ep->remove($_POST["secret"]);
$stars = $ep->remove($_POST["stars"]);
$demons = $ep->remove($_POST["demons"]);
$icon = $ep->remove($_POST["icon"]);
$color1 = $ep->remove($_POST["color1"]);
$color2 = $ep->remove($_POST["color2"]);
if(!empty($_POST["iconType"])){
	$iconType = $ep->remove($_POST["iconType"]);
}else{
	$iconType = 0;
}
if(!empty($_POST["userCoins"])){
	$userCoins = $ep->remove($_POST["userCoins"]);
}else{
	$userCoins = 0;
}
if(!empty($_POST["special"])){
	$special = $ep->remove($_POST["special"]);
}else{
	$special = 0;
}
if(!empty($_POST["accIcon"])){
	$accIcon = $ep->remove($_POST["accIcon"]);
}else{
	$accIcon = 0;
}
if(!empty($_POST["accShip"])){
	$accShip = $ep->remove($_POST["accShip"]);
}else{
	$accShip = 0;
}
if(!empty($_POST["accBall"])){
	$accBall = $ep->remove($_POST["accBall"]);
}else{
	$accBall = 0;
}
if(!empty($_POST["accBird"])){
	$accBird = $ep->remove($_POST["accBird"]);
}else{
	$accBird = 0;
}
if(!empty($_POST["accDart"])){
	$accDart = $ep->remove($_POST["accDart"]);
}else{
	$accDart = 0;
}
if(!empty($_POST["accRobot"])){
	$accRobot = $ep->remove($_POST["accRobot"]);
}else{
	$accRobot = 0;
}
if(!empty($_POST["accGlow"])){
	$accGlow = $ep->remove($_POST["accGlow"]);
}else{
	$accGlow = 0;
}
if(!empty($_POST["accSpider"])){
	$accSpider = $ep->remove($_POST["accSpider"]);
}else{
	$accSpider = 0;
}
if(!empty($_POST["accExplosion"])){
	$accExplosion = $ep->remove($_POST["accExplosion"]);
}else{
	$accExplosion = 0;
}
if(!empty($_POST["diamonds"])){
	$diamonds = $ep->remove($_POST["diamonds"]);
}else{
	$diamonds = 0;
}
//continuing the accounts system
$accountID = "";
if(empty($_POST["udid"]) AND empty($_POST["accountID"])){
	exit("-1");
}
if(!empty($_POST["udid"])){
	$id = $ep->remove($_POST["udid"]);
	if(is_numeric($id)){
		exit("-1");
	}
}
if(!empty($_POST["accountID"]) AND $_POST["accountID"]!="0"){
	$id = $ep->remove($_POST["accountID"]);
	$gjp = $ep->remove($_POST["gjp"]);
	$GJPCheck = new GJPCheck(); //gjp check
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult != 1){
		exit("-1");
	}
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
$query->execute([':gameVersion' => $gameVersion, ':userName' => $userName, ':coins' => $coins, ':secret' => $secret, ':stars' => $stars, ':demons' => $demons, ':icon' => $icon, ':color1' => $color1, ':color2' => $color2, ':iconType' => $iconType, ':userCoins' => $userCoins, ':special' => $special, ':accIcon' => $accIcon, ':accShip' => $accShip, ':accBall' => $accBall, ':accBird' => $accBird, ':accDart' => $accDart, ':accRobot' => $accRobot, ':accGlow' => $accGlow, ':hostname' => $hostname, ':uploadDate' => $uploadDate, ':userID' => $userID, ':accSpider'=>$accSpider, ':accExplosion'=>$accExplosion, ':diamonds'=>$diamonds]);
$query2->execute([':timestamp' => time(), ':stars' => $starsdiff, ':account' => $userID, ':coinsd' => $coindiff, ':demon' => $demondiff, ':usrco' => $ucdiff, ':diamond' => $diadiff]);
echo $userID;
?>