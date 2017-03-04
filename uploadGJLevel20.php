<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$gjp = $ep->remove($_POST["gjp"]);
$gameVersion = $ep->remove($_POST["gameVersion"]);
if($_POST["binaryVersion"]){
	$binaryVersion = $ep->remove($_POST["binaryVersion"]);	
}else{
	$binaryVersion = 0;
}
$userName = $ep->remove($_POST["userName"]);
$userName = preg_replace("/[^A-Za-z0-9 ]/", '', $userName);
$levelID = $ep->remove($_POST["levelID"]);
$levelName = $ep->remove($_POST["levelName"]);
$levelName = preg_replace("/[^A-Za-z0-9 ]/", '', $levelName);
$levelDesc = $ep->remove($_POST["levelDesc"]);
if($gameVersion < 20){
	$levelDesc = base64_encode($levelDesc);
}
$levelVersion = $ep->remove($_POST["levelVersion"]);
$levelLength = $ep->remove($_POST["levelLength"]);
$audioTrack = $ep->remove($_POST["audioTrack"]);
if($_POST["auto"]){
	$auto = $ep->remove($_POST["auto"]);
}else{
	$auto = 0;
}
if($_POST["password"]){
	$password = $ep->remove($_POST["password"]);
}else{
	$password = 1;
}
if($_POST["original"]){
	$original = $ep->remove($_POST["original"]);
}else{
	$original = 0;
}
if($_POST["twoPlayer"]){
	$twoPlayer = $ep->remove($_POST["twoPlayer"]);
}else{
	$twoPlayer = 0;
}
if($_POST["songID"]){
	$songID = $ep->remove($_POST["songID"]);
}else{
	$songID = 0;
}
if($_POST["objects"]){
	$objects = $ep->remove($_POST["objects"]);
}else{
	$objects = 0;
}
if($_POST["coins"]){
	$coins = $ep->remove($_POST["coins"]);
}else{
	$coins = 0;
}
if($_POST["requestedStars"]){
	$requestedStars = $ep->remove($_POST["requestedStars"]);
}else{
	$requestedStars = 0;
}
if($_POST["extraString"]){
	$extraString = $ep->remove($_POST["extraString"]);
}else{
	$extraString = "29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29";
}
$levelString = $ep->remove($_POST["levelString"]);
if($_POST["levelInfo"]){
	$levelInfo = $ep->remove($_POST["levelInfo"]);
}else{
	$levelInfo = 0;
}
$secret = $ep->remove($_POST["secret"]);
if($_POST["unlisted"]){
	$unlisted = $ep->remove($_POST["unlisted"]);
}else{
	$unlisted = 0;
}
$accountID = "";
$id = $ep->remove($_POST["udid"]);
if($_POST["accountID"]!="" AND $_POST["accountID"]!="0"){
	$id = $ep->remove($_POST["accountID"]);
	$register = 1;
}else{
	$register = 0;
}
$query2 = $db->prepare("SELECT * FROM users WHERE extID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$userIDalmost = $result[0];
$userID = $userIDalmost[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName)
VALUES (:register, :id, :userName)");
$query->execute([':register' => $register, ':id' => $id, ':userName' => $userName]);
$userID = $db->lastInsertId();
}
$uploadDate = time();
$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID, extID, updateDate, unlisted, hostname)
VALUES (:levelName, :gameVersion, :binaryVersion, :userName, :levelDesc, :levelVersion, :levelLength, :audioTrack, :auto, :password, :original, :twoPlayer, :songID, :objects, :coins, :requestedStars, :extraString, :levelString, :levelInfo, :secret, :uploadDate, :userID, :id, :uploadDate, :unlisted, :hostname)");


if($levelString != "" AND $levelName != ""){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$hostname = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$hostname = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$hostname = $_SERVER['REMOTE_ADDR'];
	}
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($register ==1){
	if($gjpresult == 1){
		$querye=$db->prepare("select * from levels where levelName = :levelName AND userID = :userID");
		$querye->execute([':levelName' => $levelName, ':userID' => $userID]);
		$resulte = $querye->fetchAll();
		$levele = $resulte[0];
		$levelID = $levele["levelID"];
		$lvls = $querye->rowCount();
		if($lvls==1){
			$query = $db->prepare("UPDATE levels SET levelName=:levelName, gameVersion=:gameVersion,  binaryVersion=:binaryVersion, userName=:userName, levelDesc=:levelDesc, levelVersion=:levelVersion, levelLength=:levelLength, audioTrack=:audioTrack, auto=:auto, password=:password, original=:original, twoPlayer=:twoPlayer, songID=:songID, objects=:objects, coins=:coins, requestedStars=:requestedStars, extraString=:extraString, levelString=:levelString, levelInfo=:levelInfo, secret=:secret, updateDate=:uploadDate, unlisted=:unlisted, hostname=:hostname WHERE levelName=:levelName AND extID=:id");	
			$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':secret' => $secret, ':levelName' => $levelName, ':id' => $id, ':uploadDate' => $uploadDate, ':unlisted' => $unlisted, ':hostname' => $hostname]);
			echo $levelID;
		}else{
			$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':secret' => $secret, ':uploadDate' => $uploadDate, ':userID' => $userID, ':id' => $id, ':unlisted' => $unlisted, ':hostname' => $hostname]);
			echo $db->lastInsertId();	
		}
	}else{
		echo -1;
	}
	}else{
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':secret' => $secret, ':uploadDate' => $uploadDate, ':userID' => $userID, ':id' => $id, ':unlisted' => $unlisted]);
		echo $db->lastInsertId();
	}
}else{
	echo -1;
}
?>
