<?php
error_reporting(0);
include "connection.php";
//here im getting all the data
//NOTE: Finish updating levels l8r
$gameVersion = htmlspecialchars($_POST["gameVersion"],ENT_QUOTES);
$binaryVersion = htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES);
$udid = htmlspecialchars($_POST["udid"],ENT_QUOTES);
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$levelID = htmlspecialchars($_POST["levelID"];
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
if($_POST["accountID"]!=""){
	$accountID = htmlspecialchars($_POST["accountID"];
}
$uploadDate = time();

$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, udid, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, accountID)
VALUES ('$levelName','$gameVersion', '$binaryVersion', '$udid', '$userName', '$levelDesc', '$levelVersion', '$levelLength', '$audioTrack', '$auto', '$password', '$original', '$twoPlayer', '$songID', '$objects', '$coins', '$requestedStars', '$extraString', '$levelString', '$levelInfo', '$secret', '$uploadDate','$accountID')");

$query->execute();
echo $db->lastInsertId();
?>