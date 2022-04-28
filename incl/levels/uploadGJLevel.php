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
$userName = ExploitPatch::charclean($_POST["userName"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$levelName = ExploitPatch::charclean($_POST["levelName"]);
//TODO: move description fixing code to a function
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
$secret = ExploitPatch::remove($_POST["secret"]);

$binaryVersion = !empty($_POST["binaryVersion"]) ? ExploitPatch::remove($_POST["binaryVersion"]) : 0;
$auto = !empty($_POST["auto"]) ? ExploitPatch::remove($_POST["auto"]) : 0;

$original = !empty($_POST["original"]) ? ExploitPatch::remove($_POST["original"]) : 0;
$twoPlayer = !empty($_POST["twoPlayer"]) ? ExploitPatch::remove($_POST["twoPlayer"]) : 0;
$songID = !empty($_POST["songID"]) ? ExploitPatch::remove($_POST["songID"]) : 0;
$objects = !empty($_POST["objects"]) ? ExploitPatch::remove($_POST["objects"]) : 0;
$coins = !empty($_POST["coins"]) ? ExploitPatch::remove($_POST["coins"]) : 0;
$requestedStars = !empty($_POST["requestedStars"]) ? ExploitPatch::remove($_POST["requestedStars"]) : 0;
//TODO: verify if this is an optimal extraString for old levels
$extraString = !empty($_POST["extraString"]) ? ExploitPatch::remove($_POST["extraString"]) : "29_29_29_40_29_29_29_29_29_29_29_29_29_29_29_29";
$levelString = ExploitPatch::remove($_POST["levelString"]);
//TODO: optionally utilize the 1.9 parameter instead
$levelInfo = !empty($_POST["levelInfo"]) ? ExploitPatch::remove($_POST["levelInfo"]) : "";
//TODO: optionally utilize the 2.2 parameter instead
$unlisted = !empty($_POST["unlisted1"]) ? ExploitPatch::remove($_POST["unlisted1"]) : 
	(!empty($_POST["unlisted"]) ? ExploitPatch::remove($_POST["unlisted"]) : 0);
$unlisted2 = !empty($_POST["unlisted2"]) ? ExploitPatch::remove($_POST["unlisted2"]) : $unlisted;
$ldm = !empty($_POST["ldm"]) ? ExploitPatch::remove($_POST["ldm"]) : 0;
$wt = !empty($_POST["wt"]) ? ExploitPatch::remove($_POST["wt"]) : 0;
$wt2 = !empty($_POST["wt2"]) ? ExploitPatch::remove($_POST["wt2"]) : 0;

if(isset($_POST["password"])){
	$password = ExploitPatch::remove($_POST["password"]);
}else{
	$password = 1;
	if($gameVersion > 17){
		$password = 0;
	}
}
$id = $gs->getIDFromPost();
$hostname = $gs->getIP();
$userID = $mainLib->getUserID($id, $userName);
$uploadDate = time();
$query = $db->prepare("SELECT count(*) FROM levels WHERE uploadDate > :time AND (userID = :userID OR hostname = :ip)");
$query->execute([':time' => $uploadDate - 60, ':userID' => $userID, ':ip' => $hostname]);
if($query->fetchColumn() > 0){
	exit("-1");
}
$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID, extID, updateDate, unlisted, hostname, isLDM, wt, wt2, unlisted2)
VALUES (:levelName, :gameVersion, :binaryVersion, :userName, :levelDesc, :levelVersion, :levelLength, :audioTrack, :auto, :password, :original, :twoPlayer, :songID, :objects, :coins, :requestedStars, :extraString, :levelString, :levelInfo, :secret, :uploadDate, :userID, :id, :uploadDate, :unlisted, :hostname, :ldm, :wt, :wt2, :unlisted2)");


if($levelString != "" AND $levelName != ""){
	$querye=$db->prepare("SELECT levelID FROM levels WHERE levelName = :levelName AND userID = :userID");
	$querye->execute([':levelName' => $levelName, ':userID' => $userID]);
	$levelID = $querye->fetchColumn();
	$lvls = $querye->rowCount();
	if($lvls==1){
		$query = $db->prepare("UPDATE levels SET levelName=:levelName, gameVersion=:gameVersion,  binaryVersion=:binaryVersion, userName=:userName, levelDesc=:levelDesc, levelVersion=:levelVersion, levelLength=:levelLength, audioTrack=:audioTrack, auto=:auto, password=:password, original=:original, twoPlayer=:twoPlayer, songID=:songID, objects=:objects, coins=:coins, requestedStars=:requestedStars, extraString=:extraString, levelString=:levelString, levelInfo=:levelInfo, secret=:secret, updateDate=:uploadDate, unlisted=:unlisted, hostname=:hostname, isLDM=:ldm, wt=:wt, wt2=:wt2, unlisted2=:unlisted2 WHERE levelName=:levelName AND extID=:id");	
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => "", ':levelInfo' => $levelInfo, ':secret' => $secret, ':levelName' => $levelName, ':id' => $id, ':uploadDate' => $uploadDate, ':unlisted' => $unlisted, ':hostname' => $hostname, ':ldm' => $ldm, ':wt' => $wt, ':wt2' => $wt2, ':unlisted2' => $unlisted2]);
		file_put_contents("../../data/levels/$levelID",$levelString);
		echo $levelID;
	}else{
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => "", ':levelInfo' => $levelInfo, ':secret' => $secret, ':uploadDate' => $uploadDate, ':userID' => $userID, ':id' => $id, ':unlisted' => $unlisted, ':hostname' => $hostname, ':ldm' => $ldm, ':wt' => $wt, ':wt2' => $wt2, ':unlisted2' => $unlisted2]);
		$levelID = $db->lastInsertId();
		file_put_contents("../../data/levels/$levelID",$levelString);
		echo $levelID;
	}
}else{
	echo -1;
}
?>
