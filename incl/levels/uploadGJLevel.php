<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$mainLib = new mainLib();
require_once "../lib/mainLib.php";
$gs = new mainLib();
//here im getting all the data
$gjp = ExploitPatch::remove($_POST["gjp"]);
$gameVersion = ExploitPatch::remove($_POST["gameVersion"]);
if(!empty($_POST["binaryVersion"])){
	$binaryVersion = ExploitPatch::remove($_POST["binaryVersion"]);	
}else{
	$binaryVersion = 0;
}
$userName = ExploitPatch::charclean($_POST["userName"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$levelName = ExploitPatch::charclean($_POST["levelName"]);
$levelDesc = ExploitPatch::remove($_POST["levelDesc"]);
$levelDesc = str_replace('-', '+', $levelDesc);
$levelDesc = str_replace('_', '/', $levelDesc);
$rawDesc = base64_decode($levelDesc);
if (strpos($rawDesc, '<c') !== false) {
	$tags = substr_count($rawDesc, '<c');
	if ($tags > substr_count($rawDesc, '</c>')) {
		$tags = $tags - substr_count($rawDesc, '</c>');
		for ($i = 0; $i < $tags; $i++) {
			$rawDesc .= '</c>';
		}
		$levelDesc = str_replace('+', '-', base64_encode($rawDesc));
		$levelDesc = str_replace('/', '_', $levelDesc);
	}
}
if($gameVersion < 20){
	$levelDesc = base64_encode($levelDesc);
}
$levelVersion = ExploitPatch::remove($_POST["levelVersion"]);
$levelLength = ExploitPatch::remove($_POST["levelLength"]);
$audioTrack = ExploitPatch::remove($_POST["audioTrack"]);
if(!empty($_POST["auto"])){
	$auto = ExploitPatch::remove($_POST["auto"]);
}else{
	$auto = 0;
}
if(isset($_POST["password"])){
	$password = ExploitPatch::remove($_POST["password"]);
}else{
	$password = 1;
	if($gameVersion > 17){
		$password = 0;
	}
}
if(!empty($_POST["original"])){
	$original = ExploitPatch::remove($_POST["original"]);
}else{
	$original = 0;
}
if(!empty($_POST["twoPlayer"])){
	$twoPlayer = ExploitPatch::remove($_POST["twoPlayer"]);
}else{
	$twoPlayer = 0;
}
if(!empty($_POST["songID"])){
	$songID = ExploitPatch::remove($_POST["songID"]);
}else{
	$songID = 0;
}
if(!empty($_POST["objects"])){
	$objects = ExploitPatch::remove($_POST["objects"]);
}else{
	$objects = 0;
}
if(!empty($_POST["coins"])){
	$coins = ExploitPatch::remove($_POST["coins"]);
}else{
	$coins = 0;
}
if(!empty($_POST["requestedStars"])){
	$requestedStars = ExploitPatch::remove($_POST["requestedStars"]);
}else{
	$requestedStars = 0;
}
if(!empty($_POST["extraString"])){
	$extraString = ExploitPatch::remove($_POST["extraString"]);
}else{
	$extraString = "29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29";
}
$levelString = ExploitPatch::remove($_POST["levelString"]);
if(!empty($_POST["levelInfo"])){
	$levelInfo = ExploitPatch::remove($_POST["levelInfo"]);
}else{
	$levelInfo = 0;
}
$secret = ExploitPatch::remove($_POST["secret"]);
if(!empty($_POST["unlisted"])){
	$unlisted = ExploitPatch::remove($_POST["unlisted"]);
}else{
	$unlisted = 0;
}
if(!empty($_POST["ldm"])){
	$ldm = ExploitPatch::remove($_POST["ldm"]);
}else{
	$ldm = 0;
}
$accountID = "";
if(!empty($_POST["udid"])){
	$id = ExploitPatch::remove($_POST["udid"]);
	if(is_numeric($id)){
		exit("-1");
	}
}
if(!empty($_POST["accountID"]) AND $_POST["accountID"]!="0"){
	$id = GJPCheck::getAccountIDOrDie();
}
$hostname = $gs->getIP();
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
