<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$gjp = explode(":", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0];
$gameVersion = explode(":", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0];
$binaryVersion = explode(":", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0];
$userName = explode(":", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0];
$levelID = explode(":", htmlspecialchars($_POST["levelID"],ENT_QUOTES))[0];
$levelName = explode(":", htmlspecialchars($_POST["levelName"],ENT_QUOTES))[0];
$levelDesc = explode(":", htmlspecialchars($_POST["levelDesc"],ENT_QUOTES))[0];
$levelVersion = explode(":", htmlspecialchars($_POST["levelVersion"],ENT_QUOTES))[0];
$levelLength = explode(":", htmlspecialchars($_POST["levelLength"],ENT_QUOTES))[0];
$audioTrack = explode(":", htmlspecialchars($_POST["audioTrack"],ENT_QUOTES))[0];
$auto = explode(":", htmlspecialchars($_POST["auto"],ENT_QUOTES))[0];
$password = explode(":", htmlspecialchars($_POST["password"],ENT_QUOTES))[0];
$original = explode(":", htmlspecialchars($_POST["original"],ENT_QUOTES))[0];
$twoPlayer = explode(":", htmlspecialchars($_POST["twoPlayer"],ENT_QUOTES))[0];
$songID = explode(":", htmlspecialchars($_POST["songID"],ENT_QUOTES))[0];
$objects = explode(":", htmlspecialchars($_POST["objects"],ENT_QUOTES))[0];
$coins = explode(":", htmlspecialchars($_POST["coins"],ENT_QUOTES))[0];
$requestedStars = explode(":", htmlspecialchars($_POST["requestedStars"],ENT_QUOTES))[0];
$extraString = explode(":", htmlspecialchars($_POST["extraString"],ENT_QUOTES))[0];
$levelString = explode(":", htmlspecialchars($_POST["levelString"],ENT_QUOTES))[0];
$levelInfo = explode(":", htmlspecialchars($_POST["levelInfo"],ENT_QUOTES))[0];
$secret = explode(":", htmlspecialchars($_POST["secret"],ENT_QUOTES))[0];
$accountID = "";
$id = explode(":", htmlspecialchars($_POST["udid"],ENT_QUOTES))[0];
if($_POST["accountID"]!=""){
	$id = explode(":", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0];
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
VALUES (:levelName, :gameVersion, :binaryVersion, :userName, :levelDesc, :levelVersion, :levelLength, :audioTrack, :auto, :password, :original, :twoPlayer, :songID, :objects, :coins, :requestedStars, :extraString, :levelString, :levelInfo, :secret, :uploadDate, :userID, :id)");


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
			$query = $db->prepare("UPDATE levels SET levelName=:levelName, gameVersion=:gameVersion,  binaryVersion=:binaryVersion, userName=:userName, levelDesc=:levelDesc, levelVersion=:levelVersion, levelLength=:levelLength, audioTrack=:audioTrack, auto=:auto, password=:password, original=:original, twoPlayer=:twoPlayer, songID=:songID, objects=:objects, coins=:coins, requestedStars=:requestedStars, extraString=:extraString, levelString=:levelString, levelInfo=:levelInfo, secret=:secret WHERE levelName=:levelName AND extID=:id");	
			$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':secret' => $secret, ':levelName' => $levelName, ':id' => $id]);
			echo $levelID;
		}else{
			$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => $levelString, ':levelInfo' => $levelInfo, ':secret' => $secret, ':uploadDate' => $uploadDate, ':userID' => $userID, ':id' => $id]);
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