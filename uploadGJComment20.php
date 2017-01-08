<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = explode(";", explode("|", explode("~", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0])[0];
$gameVersion = explode(";", explode("|", explode("~", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0])[0])[0];
$binaryVersion = explode(";", explode("|", explode("~", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0])[0])[0];
$userName = explode(";", explode("|", explode("~", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0])[0];
$comment = explode(";", explode("|", explode("~", htmlspecialchars($_POST["comment"],ENT_QUOTES))[0])[0])[0];
$levelID = explode(";", explode("|", explode("~", htmlspecialchars($_POST["levelID"],ENT_QUOTES))[0])[0])[0];
$accountID = "";
$id = explode(";", htmlspecialchars($_POST["udid"],ENT_QUOTES))[0];
if($_POST["accountID"]!=""){
	$id = explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0];
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
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES ('$register','$id')");

$query->execute();
$userID = $db->lastInsertId();
}
$uploadDate = time();
$decodecomment = base64_decode($comment);
if(substr($decodecomment,0,5) == '!rate'){
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$query2 = $db->prepare("SELECT * FROM modips WHERE IP = '".$hostname."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$test = base64_encode("RATING TEST");
$commentarray = explode(' ', $decodecomment);
$starStars = $commentarray[2];
$starCoins = $commentarray[3];
$starFeatured = $commentarray[4];
switch ($commentarray[1]) {
    case "easy":
        $starDifficulty = 10;
        break;
    case "normal":
        $starDifficulty = 20;
        break;
    case "hard":
        $starDifficulty = 30;
        break;
    case "harder":
        $starDifficulty = 40;
        break;
    case "insane":
        $starDifficulty = 50;
        break;
}
     $query = $db->prepare("UPDATE levels SET starStars='$starStars', starDifficulty='$starDifficulty', starDemon='0', starAuto='0', starFeatured='$starFeatured', starCoins='$starCoins' WHERE levelID='$levelID'");
if($commentarray[1] == "demon"){
$query = $db->prepare("UPDATE levels SET starStars='$starStars', starDifficulty='50', starDemon='1', starAuto='0', starFeatured='$starFeatured', starCoins='$starCoins' WHERE levelID='$levelID'");
}
if($commentarray[1] == "auto"){
$query = $db->prepare("UPDATE levels SET starStars='$starStars', starDifficulty='50', starAuto='1', starDemon='0', starFeatured='$starFeatured', starCoins='$starCoins' WHERE levelID='$levelID'");
}
$query->execute();
}
}
if(substr($decodecomment,0,8) == '!feature'){
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$query2 = $db->prepare("SELECT * FROM modips WHERE IP = '".$hostname."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID='$levelID'");
$query->execute();
}
}
if(substr($decodecomment,0,12) == '!verifycoins'){
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$query2 = $db->prepare("SELECT * FROM modips WHERE IP = '".$hostname."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$query = $db->prepare("UPDATE levels SET starCoins='1' WHERE levelID='$levelID'");
$query->execute();
}
}
if(substr($decodecomment,0,7) == '!delete'){
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$query2 = $db->prepare("SELECT * FROM modips WHERE IP = '".$hostname."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$query = $db->prepare("DELETE from levels WHERE levelID='$levelID' LIMIT 1");
$query->execute();
}
}
if(substr($decodecomment,0,1) != '!'){
$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, userID, timeStamp)
VALUES ('$userName', '$comment', '$levelID', '$userID', '$uploadDate')");
}else{
$query = $db->prepare("SELECT * FROM modips WHERE IP = 'nope'");
}

if($id != "" AND $comment != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($register == 1){
	if($gjpresult == 1){
		$query->execute();
		echo 1;
	}
	else
	{
		echo -1;
	}
	}else{
		$query->execute();
		echo 1;
	}
}else{echo -1;}
?>
