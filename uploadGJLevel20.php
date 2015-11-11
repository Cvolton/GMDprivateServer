<?php
error_reporting(0);
include "connection.php";
//here im getting all the data
//NOTE: Finish updating levels l8r
$gameVersion = htmlspecialchars($_POST["gameVersion"],ENT_QUOTES);
$binaryVersion = htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES);
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
$levelName = htmlspecialchars($_POST["levelName"],ENT_QUOTES);
$levelDesc = htmlspecialchars($_POST["levelDesc"],ENT_QUOTES);
$levelVersion = htmlspecialchars($_POST["levelVersion"],ENT_QUOTES);
$levelLength = htmlspecialchars($_POST["levelLength"],ENT_QUOTES);
$audioTrack = htmlspecialchars($_POST["audioTrack"],ENT_QUOTES);
$auto = htmlspecialchars($_POST["auto"],ENT_QUOTES);
$password = htmlspecialchars($_POST["password"],ENT_QUOTES);
$original = htmlspecialchars($_POST["original"],ENT_QUOTES);
$twoPlayer = htmlspecialchars($_POST["twoPlayer"],ENT_QUOTES);
$songID = htmlspecialchars($_POST["songID"],ENT_QUOTES);
$objects = htmlspecialchars($_POST["objects"],ENT_QUOTES);
$coins = htmlspecialchars($_POST["coins"],ENT_QUOTES);
$requestedStars = htmlspecialchars($_POST["requestedStars"],ENT_QUOTES);
$extraString = htmlspecialchars($_POST["extraString"],ENT_QUOTES);
$levelString = htmlspecialchars($_POST["levelString"],ENT_QUOTES);
$levelInfo = htmlspecialchars($_POST["levelInfo"],ENT_QUOTES);
$secret = htmlspecialchars($_POST["secret"],ENT_QUOTES);
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

$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, userID)
VALUES ('$levelName','$gameVersion', '$binaryVersion', '$userName', '$levelDesc', '$levelVersion', '$levelLength', '$audioTrack', '$auto', '$password', '$original', '$twoPlayer', '$songID', '$objects', '$coins', '$requestedStars', '$extraString', '$levelString', '$levelInfo', '$secret', '$uploadDate','$userID')");

$query->execute();
echo $db->lastInsertId();
?>