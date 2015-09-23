<?php
include "connection.php";
//here im getting all the data
//NOTE: Finish updating levels l8r
$gameVersion = $_POST["gameVersion"];
$binaryVersion = $_POST["binaryVersion"];
$udid = $_POST["udid"];
$userName = $_POST["userName"];
$levelID = $_POST["levelID"];
$levelName = $_POST["levelName"];
$levelDesc = $_POST["levelDesc"];
$levelVersion = $_POST["levelVersion"];
$levelLength = $_POST["levelLength"];
$audioTrack = $_POST["audioTrack"];
$auto = $_POST["auto"];
$password = $_POST["password"];
$original = $_POST["original"];
$twoPlayer = $_POST["twoPlayer"];
$songID = $_POST["songID"];
$objects = $_POST["objects"];
$coins = $_POST["coins"];
$requestedStars = $_POST["requestedStars"];
$extraString = $_POST["extraString"];
$levelString = $_POST["levelString"];
$levelInfo = $_POST["levelInfo"];
$secret = $_POST["secret"];
$uploadDate = time();

$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, udid, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate)
VALUES ('$levelName','$gameVersion', '$binaryVersion', '$udid', '$userName', '$levelDesc', '$levelVersion', '$levelLength', '$audioTrack', '$auto', '$password', '$original', '$twoPlayer', '$songID', '$objects', '$coins', '$requestedStars', '$extraString', '$levelString', '$levelInfo', '$secret', '$uploadDate')");

$query->execute();
echo $db->lastInsertId();
?>