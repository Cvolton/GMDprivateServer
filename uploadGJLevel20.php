<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$gjp = explode(":", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0];
$gameVersion = explode(":", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0];
if($_POST["binaryVersion"]){
	$binaryVersion = explode(":", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0];	
}else{
	$binaryVersion = 0;
}
$userName = explode(":", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0];
$levelID = explode(":", htmlspecialchars($_POST["levelID"],ENT_QUOTES))[0];
$levelName = explode(":", htmlspecialchars($_POST["levelName"],ENT_QUOTES))[0];
$levelName = preg_replace("/[^A-Za-z0-9 ]/", '', $levelName);
$levelDesc = explode(":", htmlspecialchars($_POST["levelDesc"],ENT_QUOTES))[0];
if($gameVersion < 20){
	$levelDesc = base64_encode($levelDesc);
}
$levelVersion = explode(":", htmlspecialchars($_POST["levelVersion"],ENT_QUOTES))[0];
$levelLength = explode(":", htmlspecialchars($_POST["levelLength"],ENT_QUOTES))[0];
$audioTrack = explode(":", htmlspecialchars($_POST["audioTrack"],ENT_QUOTES))[0];
if($_POST["auto"]){
	$auto = explode(":", htmlspecialchars($_POST["auto"],ENT_QUOTES))[0];
}else{
	$auto = 0;
}
if($_POST["password"]){
	$password = explode(":", htmlspecialchars($_POST["password"],ENT_QUOTES))[0];
}else{
	$password = 1;
}
if($_POST["original"]){
	$original = explode(":", htmlspecialchars($_POST["original"],ENT_QUOTES))[0];
}else{
	$original = 0;
}
if($_POST["twoPlayer"]){
	$twoPlayer = explode(":", htmlspecialchars($_POST["twoPlayer"],ENT_QUOTES))[0];
}else{
	$twoPlayer = 0;
}
if($_POST["songID"]){
	$songID = explode(":", htmlspecialchars($_POST["songID"],ENT_QUOTES))[0];
}else{
	$songID = 0;
}
if($_POST["objects"]){
	$objects = explode(":", htmlspecialchars($_POST["objects"],ENT_QUOTES))[0];
}else{
	$objects = 0;
}
if($_POST["coins"]){
	$coins = explode(":", htmlspecialchars($_POST["coins"],ENT_QUOTES))[0];
}else{
	$coins = 0;
}
if($_POST["requestedStars"]){
	$requestedStars = explode(":", htmlspecialchars($_POST["requestedStars"],ENT_QUOTES))[0];
}else{
	$requestedStars = 0;
}
if($_POST["extraString"]){
	$extraString = explode(":", htmlspecialchars($_POST["extraString"],ENT_QUOTES))[0];
}else{
	$extraString = "29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29";
}
$levelString = explode(":", htmlspecialchars($_POST["levelString"],ENT_QUOTES))[0];
if($_POST["levelInfo"]){
	$levelInfo = explode(":", htmlspecialchars($_POST["levelInfo"],ENT_QUOTES))[0];
}else{
	$levelInfo = 0;
}
$secret = explode(":", htmlspecialchars($_POST["secret"],ENT_QUOTES))[0];
if($_POST["unlisted"]){
	$unlisted = explode(":", htmlspecialchars($_POST["unlisted"],ENT_QUOTES))[0];
}else{
	$unlisted = 0;
}
$accountID = "";
$id = explode(":", htmlspecialchars($_POST["udid"],ENT_QUOTES))[0];
if($_POST["accountID"]!="" AND $_POST["accountID"]!="0"){
	$id = explode(":", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0];
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
VALUES ('$register','$id', '$userName')");

$query->execute();
$userID = $db->lastInsertId();
}
$uploadDate = time();
//thanks jman for posting this in moonlit gdps chat tbh
if (preg_match('/^[a-zA-Z0-9]+$/', $levelName) == false){
	exit(-1);
}
$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID, extID, updateDate, unlisted)
VALUES (:levelName, :gameVersion, :binaryVersion, :userName, :levelDesc, :levelVersion, :levelLength, :audioTrack, :auto, :password, :original, :twoPlayer, :songID, :objects, :coins, :requestedStars, :extraString, :levelString, :levelInfo, :secret, :uploadDate, :userID, :id, :uploadDate, :unlisted)");


if($levelString != "" AND $levelName != ""){
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
			$query = $db->prepare("UPDATE levels SET levelName=:levelName, gameVersion=:gameVersion,  binaryVersion=:binaryVersion, userName=:userName, levelDesc=:levelDesc, levelVersion=:levelVersion, levelLength=:levelLength, audioTrack=:audioTrack, auto=:auto, password=:password, original=:original, twoPlayer=:twoPlayer, songID=:songID, objects=:objects, coins=:coins, requestedStars=:requestedStars, extraString=:extraString, levelString=:levelString, levelInfo=:levelInfo, secret=:secret, updateDate=:uploadDate, unlisted=:unlisted WHERE levelName=:levelName AND extID=:id");	
			$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':secret' => $secret, ':levelName' => $levelName, ':id' => $id, ':uploadDate' => $uploadDate, ':unlisted' => $unlisted]);
			echo $levelID;
		}else{
			$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':secret' => $secret, ':uploadDate' => $uploadDate, ':userID' => $userID, ':id' => $id, ':unlisted' => $unlisted]);
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
