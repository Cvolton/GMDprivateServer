<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

if(!isset($_POST["userName"]) OR !isset($_POST["secret"]) OR !isset($_POST["stars"])
	OR !isset($_POST["demons"]) OR !isset($_POST["icon"]) OR !isset($_POST["color1"])
	OR !isset($_POST["color2"]))
{
	exit("-1");
}

$userName = ExploitPatch::charclean($_POST["userName"]);
$secret = ExploitPatch::remove($_POST["secret"]);
$stars = ExploitPatch::remove($_POST["stars"]);
$demons = ExploitPatch::remove($_POST["demons"]);
$icon = ExploitPatch::remove($_POST["icon"]);
$color1 = ExploitPatch::remove($_POST["color1"]);
$color2 = ExploitPatch::remove($_POST["color2"]);

$gameVersion = !empty($_POST["gameVersion"]) ? ExploitPatch::remove($_POST["gameVersion"]) : 1;
$binaryVersion = !empty($_POST["binaryVersion"]) ? ExploitPatch::remove($_POST["binaryVersion"]) : 1;
$coins = !empty($_POST["coins"]) ? ExploitPatch::remove($_POST["coins"]) : 0;
$iconType = !empty($_POST["iconType"]) ? ExploitPatch::remove($_POST["iconType"]) : 0;
$userCoins = !empty($_POST["userCoins"]) ? ExploitPatch::remove($_POST["userCoins"]) : 0;
$special = !empty($_POST["special"]) ? ExploitPatch::remove($_POST["special"]) : 0;
$accIcon = !empty($_POST["accIcon"]) ? ExploitPatch::remove($_POST["accIcon"]) : 0;
$accShip = !empty($_POST["accShip"]) ? ExploitPatch::remove($_POST["accShip"]) : 0;
$accBall = !empty($_POST["accBall"]) ? ExploitPatch::remove($_POST["accBall"]) : 0;
$accBird = !empty($_POST["accBird"]) ? ExploitPatch::remove($_POST["accBird"]) : 0;
$accDart = !empty($_POST["accDart"]) ? ExploitPatch::remove($_POST["accDart"]) : 0;
$accRobot = !empty($_POST["accRobot"]) ? ExploitPatch::remove($_POST["accRobot"]) : 0;
$accGlow = !empty($_POST["accGlow"]) ? ExploitPatch::remove($_POST["accGlow"]) : 0;
$accSpider = !empty($_POST["accSpider"]) ? ExploitPatch::remove($_POST["accSpider"]) : 0;
$accExplosion = !empty($_POST["accExplosion"]) ? ExploitPatch::remove($_POST["accExplosion"]) : 0;
$diamonds = !empty($_POST["diamonds"]) ? ExploitPatch::remove($_POST["diamonds"]) : 0;
$moons = !empty($_POST["moons"]) ? ExploitPatch::remove($_POST["moons"]) : 0;
$color3 = !empty($_POST["color3"]) ? ExploitPatch::remove($_POST["color3"]) : 0;
$accSwing = !empty($_POST["accSwing"]) ? ExploitPatch::remove($_POST["accSwing"]) : 0;
$accJetpack = !empty($_POST["accJetpack"]) ? ExploitPatch::remove($_POST["accJetpack"]) : 0;
$dinfo = !empty($_POST["dinfo"]) ? ExploitPatch::numbercolon($_POST["dinfo"]) : '';
$dinfow = !empty($_POST["dinfow"]) ? ExploitPatch::number($_POST["dinfow"]) : 0;
$dinfog = !empty($_POST["dinfog"]) ? ExploitPatch::number($_POST["dinfog"]) : 0;
$sinfo = !empty($_POST["sinfo"]) ? ExploitPatch::numbercolon($_POST["sinfo"]) : '';
$sinfod = !empty($_POST["sinfod"]) ? ExploitPatch::number($_POST["sinfod"]) : 0;
$sinfog = !empty($_POST["sinfog"]) ? ExploitPatch::number($_POST["sinfog"]) : 0;

if(empty($_POST["udid"]) AND empty($_POST["accountID"]))
	exit("-1");

$id = $gs->getIDFromPost();
$userID = $gs->getUserID($id, $userName);
$uploadDate = time();
$hostname = $gs->getIP();

$query = $db->prepare("SELECT stars,coins,demons,userCoins,diamonds,moons FROM users WHERE userID=:userID LIMIT 1"); //getting differences
$query->execute([':userID' => $userID]);
$old = $query->fetch();

if(!empty($dinfo)) {
	$demonsCount = $db->prepare("SELECT IFNULL(easyNormal, 0) as easyNormal,
	IFNULL(mediumNormal, 0) as mediumNormal,
	IFNULL(hardNormal, 0) as hardNormal,
	IFNULL(insaneNormal, 0) as insaneNormal,
	IFNULL(extremeNormal, 0) as extremeNormal,
	IFNULL(easyPlatformer, 0) as easyPlatformer,
	IFNULL(mediumPlatformer, 0) as mediumPlatformer,
	IFNULL(hardPlatformer, 0) as hardPlatformer,
	IFNULL(insanePlatformer, 0) as insanePlatformer,
	IFNULL(extremePlatformer, 0) as extremePlatformer
	FROM (
		(SELECT count(*) AS easyNormal FROM levels WHERE starDemonDiff = 3 AND levelLength != 5 AND levelID IN (".$dinfo.") AND starDemon != 0) easyNormal
		JOIN (SELECT count(*) AS mediumNormal FROM levels WHERE starDemonDiff = 4 AND levelLength != 5 AND levelID IN (".$dinfo.") AND starDemon != 0) mediumNormal
		JOIN (SELECT count(*) AS hardNormal FROM levels WHERE starDemonDiff = 0 AND levelLength != 5 AND levelID IN (".$dinfo.") AND starDemon != 0) hardNormal
		JOIN (SELECT count(*) AS insaneNormal FROM levels WHERE starDemonDiff = 5 AND levelLength != 5 AND levelID IN (".$dinfo.") AND starDemon != 0) insaneNormal
		JOIN (SELECT count(*) AS extremeNormal FROM  levels WHERE starDemonDiff = 6 AND levelLength != 5 AND levelID IN (".$dinfo.") AND starDemon != 0) extremeNormal
		
		JOIN (SELECT count(*) AS easyPlatformer FROM levels WHERE starDemonDiff = 3 AND levelLength = 5 AND levelID IN (".$dinfo.") AND starDemon != 0) easyPlatformer
		JOIN (SELECT count(*) AS mediumPlatformer FROM levels WHERE starDemonDiff = 4 AND levelLength = 5 AND levelID IN (".$dinfo.") AND starDemon != 0) mediumPlatformer
		JOIN (SELECT count(*) AS hardPlatformer FROM levels WHERE starDemonDiff = 0 AND levelLength = 5 AND levelID IN (".$dinfo.") AND starDemon != 0) hardPlatformer
		JOIN (SELECT count(*) AS insanePlatformer FROM levels WHERE starDemonDiff = 5 AND levelLength = 5 AND levelID IN (".$dinfo.") AND starDemon != 0) insanePlatformer
		JOIN (SELECT count(*) AS extremePlatformer FROM levels WHERE starDemonDiff = 6 AND levelLength = 5 AND levelID IN (".$dinfo.") AND starDemon != 0) extremePlatformer
	)");
	$demonsCount->execute(); // Doesn't work with [':levels' => $dinfo] way
	$demonsCount = $demonsCount->fetch();
	$allDemons = $demonsCount["easyNormal"]+$demonsCount["mediumNormal"]+$demonsCount["hardNormal"]+$demonsCount["insaneNormal"]+$demonsCount["extremeNormal"]+$demonsCount["easyPlatformer"]+$demonsCount["mediumPlatformer"]+$demonsCount["hardPlatformer"]+$demonsCount["insanePlatformer"]+$demonsCount["extremePlatformer"]+$dinfow+$dinfog;
	$demonsCountDiff = min($demons - $allDemons, 3);
	$dinfo = ($demonsCount["easyNormal"]+$demonsCountDiff).','.$demonsCount["mediumNormal"].','.$demonsCount["hardNormal"].','.$demonsCount["insaneNormal"].','.$demonsCount["extremeNormal"].','.$demonsCount["easyPlatformer"].','.$demonsCount["mediumPlatformer"].','.$demonsCount["hardPlatformer"].','.$demonsCount["insanePlatformer"].','.$demonsCount["extremePlatformer"].','.$dinfow.','.$dinfog;
}
if(!empty($sinfo)) {
	$sinfo = explode(",", $sinfo);
	$starsCount = $sinfo[0].",".$sinfo[1].",".$sinfo[2].",".$sinfo[3].",".$sinfo[4].",".$sinfo[5].",".$sinfod.",".$sinfog;
	$platformerCount = $sinfo[6].",".$sinfo[7].",".$sinfo[8].",".$sinfo[9].",".$sinfo[10].",".$sinfo[11].",0"; // Last is for Map levels, unused until 2.21
}
$query = $db->prepare("UPDATE users SET gameVersion=:gameVersion, userName=:userName, coins=:coins,  secret=:secret, stars=:stars, demons=:demons, icon=:icon, color1=:color1, color2=:color2, iconType=:iconType, userCoins=:userCoins, special=:special, accIcon=:accIcon, accShip=:accShip, accBall=:accBall, accBird=:accBird, accDart=:accDart, accRobot=:accRobot, accGlow=:accGlow, IP=:hostname, lastPlayed=:uploadDate, accSpider=:accSpider, accExplosion=:accExplosion, diamonds=:diamonds, moons=:moons, color3=:color3, accSwing=:accSwing, accJetpack=:accJetpack, dinfo=:dinfo, sinfo=:sinfo, pinfo=:pinfo WHERE userID=:userID");
$query->execute([':gameVersion' => $gameVersion, ':userName' => $userName, ':coins' => $coins, ':secret' => $secret, ':stars' => $stars, ':demons' => $demons, ':icon' => $icon, ':color1' => $color1, ':color2' => $color2, ':iconType' => $iconType, ':userCoins' => $userCoins, ':special' => $special, ':accIcon' => $accIcon, ':accShip' => $accShip, ':accBall' => $accBall, ':accBird' => $accBird, ':accDart' => $accDart, ':accRobot' => $accRobot, ':accGlow' => $accGlow, ':hostname' => $hostname, ':uploadDate' => $uploadDate, ':userID' => $userID, ':accSpider'=>$accSpider, ':accExplosion'=>$accExplosion, ':diamonds'=>$diamonds, ':moons' => $moons, ':color3' => $color3, ':accSwing' => $accSwing, ':accJetpack' => $accJetpack, ':dinfo' => $dinfo, ':sinfo' => $starsCount, ':pinfo' => $platformerCount]);
$starsdiff = $stars - $old["stars"];
$coindiff = $coins - $old["coins"];
$demondiff = $demons - $old["demons"];
$ucdiff = $userCoins - $old["userCoins"];
$diadiff = $diamonds - $old["diamonds"];
$moondiff = $moons - $old["moons"];
$query2 = $db->prepare("INSERT INTO actions (type, value, timestamp, account, value2, value3, value4, value5, value6) 
									 VALUES ('9',:stars,:timestamp,:account,:coinsd, :demon, :usrco, :diamond, :moons)"); //creating the action
$query2->execute([':timestamp' => time(), ':stars' => $starsdiff, ':account' => $userID, ':coinsd' => $coindiff, ':demon' => $demondiff, ':usrco' => $ucdiff, ':diamond' => $diadiff, ':moons' => $moondiff]);
echo $userID;
?>