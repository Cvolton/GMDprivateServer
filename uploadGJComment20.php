<?php
//error_reporting(0);
include "connection.php";
//here im getting all the data
//NOTE: Finish updating levels l8r
$gameVersion = htmlspecialchars($_POST["gameVersion"],ENT_QUOTES);
$binaryVersion = htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES);
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
//some gj user score crap
$comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
//continuing the accounts system
$accountID = "";
$id = htmlspecialchars($_POST["udid"],ENT_QUOTES);
if($_POST["accountID"]!=""){
	$id = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
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
$query2 = $db->prepare("SELECT * FROM modIPs WHERE IP = '".$hostname."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$test = base64_encode("RATING TEST");
$commentarray = explode(' ', $decodecomment);
$starStars = $commentarray[2];
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
     $query = $db->prepare("UPDATE levels SET starStars='$starStars', starDifficulty='$starDifficulty' WHERE levelID='$levelID'");
if($commentarray[1] == "demon"){
$query = $db->prepare("UPDATE levels SET starStars='$starStars', starDifficulty='50', starDemon='1' WHERE levelID='$levelID'");
}
if($commentarray[1] == "auto"){
$query = $db->prepare("UPDATE levels SET starStars='$starStars', starDifficulty='50', starAuto='1' WHERE levelID='$levelID'");
}
$query->execute();
}
}
if(substr($decodecomment,0,8) == '!feature'){
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$query2 = $db->prepare("SELECT * FROM modIPs WHERE IP = '".$hostname."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID='$levelID'");
$query->execute();
}
}
if(substr($decodecomment,0,7) == '!delete'){
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$query2 = $db->prepare("SELECT * FROM modIPs WHERE IP = '".$hostname."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$query = $db->prepare("DELETE from levels WHERE levelID='$levelID' LIMIT 1");
$query->execute();
}
}
$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, userID, timeStamp)
VALUES ('$userName', '$comment', '$levelID', '$userID', '$uploadDate')");

$query->execute();
echo 1;
?>