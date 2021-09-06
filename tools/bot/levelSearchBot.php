<?php
//error_reporting(0);
include_once "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
$str = ExploitPatch::remove($_GET["str"]);
$difficulty = "";
$original = "";
//getting level data
echo "***SHOWING RESULT FOR $str***\r\n";
include "../../incl/lib/connection.php";
$query = $db->prepare("(SELECT * FROM levels WHERE levelID = :str) UNION (SELECT * FROM levels WHERE levelName LIKE CONCAT('%', :str, '%') ORDER BY likes DESC LIMIT 1)"); //getting level info
$query->execute([':str' => $str]);
//checking if exists
if($query->rowCount() == 0){
	exit("The level you are searching for doesn't exist");
}
$levelInfo = $query->fetchAll()[0];
//getting creator name
$query = $db->prepare("SELECT userName FROM users WHERE userID = :userID");
$query->execute([':userID' => $levelInfo["userID"]]);
$creator = $query->fetchColumn();
//getting song name
if($levelInfo["songID"] != 0){
	$query = $db->prepare("SELECT name, authorName, ID FROM songs WHERE ID = :songID");
	$query->execute([':songID' => $levelInfo["songID"]]);
	$songInfo = $query->fetchAll()[0];
	$song = $songInfo["name"] . " by " . $songInfo["authorName"] . " (" . $songInfo["ID"] . ")";
}else{
	$song = $gs->getAudioTrack($levelInfo["audioTrack"]);
}
//getting difficulty
if($levelInfo["starDemon"] == 1){
	$difficulty .= $gs->getDemonDiff($levelInfo["starDemonDiff"]) . " ";
}
$difficulty .= $gs->getDifficulty($levelInfo["starDifficulty"],$levelInfo["starAuto"],$levelInfo["starDemon"]);
$difficulty .= " " . $levelInfo["starStars"] ."* ";
if($levelInfo["starEpic"] != 0){
	$difficulty .= "Epic ";
}else if($levelInfo["starFeatured"] != 0){
	$difficulty .= "Featured ";
}
//getting length
$length = $gs->getLength($levelInfo["levelLength"]);
//times
$uploadDate = date("d-m-Y G-i", $levelInfo["uploadDate"]);
$updateDate = date("d-m-Y G-i", $levelInfo["updateDate"]);
//getting original level
if($levelInfo["original"] != 0){
	$original .= "\r\n**Original:** " . $levelInfo["original"] ."";
}
if($levelInfo["originalReup"] != 0){
	$original .= "\r\n**Reupload Original:** ".$levelInfo["originalReup"] . "";
}
//whorated
$query = $db->prepare("SELECT * FROM modactions WHERE value3 = :lvid AND type = '1'");
$query->execute([':lvid' => $levelInfo["levelID"]]);
$actionlist = $query->fetchAll();
if($query->rowCount() == 0){
	$whorated = "";
}
$x = 0;
foreach($actionlist as &$action){
	$query = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
	$query->execute([':id' => $action["account"]]);
	$result2 = $query->fetchAll();
	$result2 = $result2[0];
	if($x != 0){
		$whorated .= " and ";
	}else{
		$whorated = "\r\n**Rated by: **";
	}
	$whorated .= $result2["userName"]."";
	$x++;
}
//coins
$coins = $levelInfo["coins"];
if($levelInfo["starCoins"] != 0){
	$coins .= " Verified";
}else{
	$coins .= " Unverified";
}
//gameVersion
$gameVersion = $gs->getGameVersion($levelInfo["gameVersion"]);
//outputting everything
echo "**NAME:** ".$levelInfo["levelName"]."
**ID:** ".$levelInfo["levelID"]."
**Author:** ".$creator."
**Song:** ".$song."
**Difficulty:** ".$difficulty."
**Coins:** ".$coins."
**Length:** ".$length."
**Upload Time:** ".$uploadDate."
**Update Time:** ".$updateDate." $original $whorated
**Objects:** ".$levelInfo["objects"]."
**Level Version:** ".$levelInfo["levelVersion"]."
**Game Version:** ".$gameVersion."
**Downloads:** ".$levelInfo["downloads"]."
**Likes:** ".$levelInfo["likes"];
?>