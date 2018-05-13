<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$mainLib = new mainLib();
$ep = new exploitPatch();
//here im getting all the data
$gjp = $ep->remove($_POST["gjp"]);
$gameVersion = $ep->remove($_POST["gameVersion"]);
if(!empty($_POST["binaryVersion"])){
	$binaryVersion = $ep->remove($_POST["binaryVersion"]);	
}else{
	$binaryVersion = 0;
}
$userName = $ep->remove($_POST["userName"]);
$userName = $ep->charclean($userName);
$levelID = $ep->remove($_POST["levelID"]);
$levelName = $ep->remove($_POST["levelName"]);
$levelName = $ep->charclean($levelName);
$levelDesc = $ep->remove($_POST["levelDesc"]);
if($gameVersion < 20){
	$levelDesc = base64_encode($levelDesc);
}
$levelVersion = $ep->remove($_POST["levelVersion"]);
$levelLength = $ep->remove($_POST["levelLength"]);
$audioTrack = $ep->remove($_POST["audioTrack"]);
if(!empty($_POST["auto"])){
	$auto = $ep->remove($_POST["auto"]);
}else{
	$auto = 0;
}
if(isset($_POST["password"])){
	$password = $ep->remove($_POST["password"]);
}else{
	$password = 1;
	if($gameVersion > 17){
		$password = 0;
	}
}
if(!empty($_POST["original"])){
	$original = $ep->remove($_POST["original"]);
}else{
	$original = 0;
}
if(!empty($_POST["twoPlayer"])){
	$twoPlayer = $ep->remove($_POST["twoPlayer"]);
}else{
	$twoPlayer = 0;
}
if(!empty($_POST["songID"])){
	$songID = $ep->remove($_POST["songID"]);
}else{
	$songID = 0;
}
if(!empty($_POST["objects"])){
	$objects = $ep->remove($_POST["objects"]);
}else{
	$objects = 0;
}
if(!empty($_POST["coins"])){
	$coins = $ep->remove($_POST["coins"]);
}else{
	$coins = 0;
}
if(!empty($_POST["requestedStars"])){
	$requestedStars = $ep->remove($_POST["requestedStars"]);
}else{
	$requestedStars = 0;
}
if(!empty($_POST["extraString"])){
	$extraString = $ep->remove($_POST["extraString"]);
}else{
	$extraString = "29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29";
}
$levelString = $ep->remove($_POST["levelString"]);
if(!empty($_POST["levelInfo"])){
	$levelInfo = $ep->remove($_POST["levelInfo"]);
}else{
	$levelInfo = 0;
}
$secret = $ep->remove($_POST["secret"]);
if(!empty($_POST["unlisted"])){
	$unlisted = $ep->remove($_POST["unlisted"]);
}else{
	$unlisted = 0;
}
if(!empty($_POST["ldm"])){
	$ldm = $ep->remove($_POST["ldm"]);
}else{
	$ldm = 0;
}
$accountID = "";
if(!empty($_POST["udid"])){
	$id = $ep->remove($_POST["udid"]);
	if(is_numeric($id)){
		exit("-1");
	}
}
if(!empty($_POST["accountID"]) AND $_POST["accountID"]!="0"){
	$id = $ep->remove($_POST["accountID"]);
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult != 1){
		exit("-1");
	}
}
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$hostname = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$hostname = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$hostname = $_SERVER['REMOTE_ADDR'];
}
$userID = $mainLib->getUserID($id, $userName);
$uploadDate = time();
$query = $db->prepare("SELECT count(*) FROM levels WHERE uploadDate > :time AND (userID = :userID OR hostname = :ip)");
$query->execute([':time' => $uploadDate - 60, ':userID' => $userID, ':ip' => $hostname]);
if($query->fetchColumn() > 0){
	exit("-1");
}
$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID, extID, updateDate, unlisted, hostname, isLDM)
VALUES (:levelName, :gameVersion, :binaryVersion, :userName, :levelDesc, :levelVersion, :levelLength, :audioTrack, :auto, :password, :original, :twoPlayer, :songID, :objects, :coins, :requestedStars, :extraString, :levelString, :levelInfo, :secret, :uploadDate, :userID, :id, :uploadDate, :unlisted, :hostname, :ldm)");


if($levelString != "" AND $levelName != ""){
	$querye=$db->prepare("SELECT levelID FROM levels WHERE levelName = :levelName AND userID = :userID");
	$querye->execute([':levelName' => $levelName, ':userID' => $userID]);
	$levelID = $querye->fetchColumn();
	$lvls = $querye->rowCount();
	if($lvls==1){
		$query = $db->prepare("UPDATE levels SET levelName=:levelName, gameVersion=:gameVersion,  binaryVersion=:binaryVersion, userName=:userName, levelDesc=:levelDesc, levelVersion=:levelVersion, levelLength=:levelLength, audioTrack=:audioTrack, auto=:auto, password=:password, original=:original, twoPlayer=:twoPlayer, songID=:songID, objects=:objects, coins=:coins, requestedStars=:requestedStars, extraString=:extraString, levelString=:levelString, levelInfo=:levelInfo, secret=:secret, updateDate=:uploadDate, unlisted=:unlisted, hostname=:hostname, isLDM=:ldm WHERE levelName=:levelName AND extID=:id");	
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => "", ':levelInfo' => $levelInfo, ':secret' => $secret, ':levelName' => $levelName, ':id' => $id, ':uploadDate' => $uploadDate, ':unlisted' => $unlisted, ':hostname' => $hostname, ':ldm' => $ldm]);
		file_put_contents("../../data/levels/$levelID",$levelString);
		echo $levelID;
	}else{
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => "", ':levelInfo' => $levelInfo, ':secret' => $secret, ':uploadDate' => $uploadDate, ':userID' => $userID, ':id' => $id, ':unlisted' => $unlisted, ':hostname' => $hostname, ':ldm' => $ldm]);
		$levelID = $db->lastInsertId();
		file_put_contents("../../data/levels/$levelID",$levelString);
		echo $levelID;
	}
}else{
	echo -1;
}
?>
