<?php
//error_reporting(0);
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/automod.php";
require_once "../lib/mainLib.php";
require_once "../lib/cron.php";
$gs = new mainLib();
if(Automod::isLevelsDisabled(0)) exit('-1');
//here im getting all the data
$gjp2check = isset($_POST['gjp2']) ? $_POST['gjp2'] : $_POST['gjp'];
$gjp = ExploitPatch::charclean($gjp2check);
$gameVersion = ExploitPatch::number($_POST["gameVersion"]);
$userName = ExploitPatch::charclean($_POST["userName"]);
$levelID = ExploitPatch::number($_POST["levelID"]);
$levelName = ExploitPatch::charclean($_POST["levelName"]);
//TODO: move description fixing code to a function
$levelDesc = ExploitPatch::remove($_POST["levelDesc"]);
$rawDesc = $gameVersion < 20 ? ExploitPatch::translit($levelDesc) : ExploitPatch::translit(ExploitPatch::url_base64_decode($levelDesc));
if(strpos($rawDesc, '<c') !== false) {
	$tags = substr_count($rawDesc, '<c');
	if($tags > substr_count($rawDesc, '</c>')) {
		$tags = $tags - substr_count($rawDesc, '</c>');
		for($i = 0; $i < $tags; $i++) {
			$rawDesc .= '</c>';
		}
	}
}
$levelDesc = ExploitPatch::url_base64_encode(ExploitPatch::rucharclean($rawDesc));
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
$settingsString = !empty($_POST["settingsString"]) ? ExploitPatch::remove($_POST["settingsString"]) : "";
$songIDs = !empty($_POST["songIDs"]) ? ExploitPatch::numbercolon($_POST["songIDs"]) : '';
$sfxIDs = !empty($_POST["sfxIDs"]) ? ExploitPatch::numbercolon($_POST["sfxIDs"]) : '';
$ts = !empty($_POST["ts"]) ? ExploitPatch::number($_POST["ts"]) : 0;

if(isset($_POST["password"])) $password = $_POST["password"] != 0 ? ExploitPatch::remove($_POST["password"]) : 1;
else $password = $gameVersion > 21 ? 1 : 0;
$id = $gs->getIDFromPost();
$hostname = $gs->getIP();
$userID = $gs->getUserID($id, $userName);
$checkBan = $gs->getPersonBan($id, $userID, 2);
if($checkBan) exit("-1");
$uploadDate = time();
$query = $db->prepare("SELECT count(*) FROM levels WHERE uploadDate > :time AND (userID = :userID OR hostname = :ip)");
$query->execute([':time' => $uploadDate - 15, ':userID' => $userID, ':ip' => $hostname]);
if($query->fetchColumn() > 0) exit("-1");
$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID, extID, updateDate, unlisted, hostname, isLDM, wt, wt2, unlisted2, settingsString, songIDs, sfxIDs, ts)
VALUES (:levelName, :gameVersion, :binaryVersion, :userName, :levelDesc, :levelVersion, :levelLength, :audioTrack, :auto, :password, :original, :twoPlayer, :songID, :objects, :coins, :requestedStars, :extraString, :levelString, :levelInfo, :secret, :uploadDate, :userID, :id, :uploadDate, :unlisted, :hostname, :ldm, :wt, :wt2, :unlisted2, :settingsString, :songIDs, :sfxIDs, :ts)");

if($levelString != "" AND $levelName != "") {
	$querye=$db->prepare("SELECT levelID, updateLocked FROM levels WHERE levelName = :levelName AND userID = :userID");
	$querye->execute([':levelName' => $levelName, ':userID' => $userID]);
	$level = $querye->fetch();
	$levelID = $level['levelID'];
	if($level['updateLocked']) exit("-1");
	$lvls = $querye->rowCount();
	if($lvls == 1) {
		$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
		$query->execute([":levelID"=> $levelID]);
		$getLevelData = $query->fetch();
		$stars = $getLevelData['starStars'];
		if(!$ratedLevelsUpdates && !in_array($levelID, $ratedLevelsUpdatesExceptions) && $stars > 0) exit("-1");
		$query = $db->prepare("UPDATE levels SET levelName=:levelName, gameVersion=:gameVersion,  binaryVersion=:binaryVersion, userName=:userName, levelDesc=:levelDesc, levelVersion=:levelVersion, levelLength=:levelLength, audioTrack=:audioTrack, auto=:auto, password=:password, original=:original, twoPlayer=:twoPlayer, songID=:songID, objects=:objects, coins=:coins, requestedStars=:requestedStars, extraString=:extraString, levelString=:levelString, levelInfo=:levelInfo, secret=:secret, updateDate=:uploadDate, unlisted=:unlisted, hostname=:hostname, isLDM=:ldm, wt=:wt, wt2=:wt2, unlisted2=:unlisted2, settingsString=:settingsString, songIDs=:songIDs, sfxIDs=:sfxIDs, ts=:ts WHERE levelName=:levelName AND extID=:id");	
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => "", ':levelInfo' => $levelInfo, ':secret' => $secret, ':levelName' => $levelName, ':id' => $id, ':uploadDate' => $uploadDate, ':unlisted' => $unlisted, ':hostname' => $hostname, ':ldm' => $ldm, ':wt' => $wt, ':wt2' => $wt2, ':unlisted2' => $unlisted2, ':settingsString' => $settingsString, ':songIDs' => $songIDs, ':sfxIDs' => $sfxIDs, ':ts' => $ts]);
		file_put_contents("../../data/levels/$levelID", $levelString);
		echo $levelID;
		$gs->logAction($id, 23, $levelName, $levelDesc, $levelID);
		$gs->sendLogsLevelChangeWebhook($levelID, $id, $getLevelData);
		Automod::checkLevelsCount();
		if($automaticCron) Cron::updateSongsUsage($id, false);
	} else {
		$query->execute([':levelName' => $levelName, ':gameVersion' => $gameVersion, ':binaryVersion' => $binaryVersion, ':userName' => $userName, ':levelDesc' => $levelDesc, ':levelVersion' => $levelVersion, ':levelLength' => $levelLength, ':audioTrack' => $audioTrack, ':auto' => $auto, ':password' => $password, ':original' => $original, ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':objects' => $objects, ':coins' => $coins, ':requestedStars' => $requestedStars, ':extraString' => $extraString, ':levelString' => "", ':levelInfo' => $levelInfo, ':secret' => $secret, ':uploadDate' => $uploadDate, ':userID' => $userID, ':id' => $id, ':unlisted' => $unlisted, ':hostname' => $hostname, ':ldm' => $ldm, ':wt' => $wt, ':wt2' => $wt2, ':unlisted2' => $unlisted2, ':settingsString' => $settingsString, ':songIDs' => $songIDs, ':sfxIDs' => $sfxIDs, ':ts' => $ts]);
		$levelID = $db->lastInsertId();
		file_put_contents("../../data/levels/$levelID", $levelString);
		echo $levelID;
		$gs->logAction($id, 22, $levelName, $levelDesc, $levelID);
		$gs->sendLogsLevelChangeWebhook($levelID, $id);
		Automod::checkLevelsCount();
		if($automaticCron) Cron::updateSongsUsage($id, false);
	}
} else {
	exit('-1');
}
?>
