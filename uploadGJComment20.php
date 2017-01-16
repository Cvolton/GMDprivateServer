<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = explode("|", explode("~", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$userName = explode("|", explode("~", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0];
$comment = explode("|", explode("~", htmlspecialchars($_POST["comment"],ENT_QUOTES))[0])[0];
$levelID = explode("|", explode("~", htmlspecialchars($_POST["levelID"],ENT_QUOTES))[0])[0];
$percent = explode("|", explode("~", htmlspecialchars($_POST["percent"],ENT_QUOTES))[0])[0];
$accountID = "";
$id = htmlspecialchars($_POST["udid"],ENT_QUOTES);
if($_POST["accountID"]!=""){
	$id = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
	$register = 1;
}else{
	$register = 0;
}
$query2 = $db->prepare("SELECT * FROM users WHERE extID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$userIDalmost = $result[0];
$userID = $userIDalmost[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES (:register, :id)");

$query->execute([':id' => $id, ':register' => $register]);
$userID = $db->lastInsertId();
}
$uploadDate = time();
$decodecomment = base64_decode($comment);
if(substr($decodecomment,0,5) == '!rate'){
$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
$result = $result[0];
if ($result["isAdmin"] == 1) {
$commentarray = explode(' ', $decodecomment);
$starStars = $commentarray[2];
$starCoins = $commentarray[3];
$starFeatured = $commentarray[4];
	$starDemon = 0;
	$starAuto = 0;
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
	case "auto":
		$starDifficulty = 50;
		$starAuto = 1;
		break;
	case "demon":
		$starDifficulty = 50;
		$starDemon = 1;
		break;
	
}
     $query = $db->prepare("UPDATE levels SET starStars=:starStars, starDifficulty=:starDifficulty, starDemon=:starDemon, starAuto=:starAuto, starFeatured=:starFeatured, starCoins=:starCoins WHERE levelID=:levelID");
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute([':starStars' => $starStars, ':starDifficulty' => $starDifficulty, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':starFeatured' => $starFeatured, ':starCoins' => $starCoins, ':levelID' => $levelID]);
	}
	 }
}
if(substr($decodecomment,0,8) == '!feature'){
$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
$result = $result[0];
if ($result["isAdmin"] == 1) {
$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID=:levelID");
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute([':levelID' => $levelID]);
	}
}
}
if(substr($decodecomment,0,5) == '!hall'){
$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
$result = $result[0];
if ($result["isAdmin"] == 1) {
$query = $db->prepare("UPDATE levels SET starHall='1' WHERE levelID=:levelID");
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute([':levelID' => $levelID]);
	}
}
}
if(substr($decodecomment,0,12) == '!verifycoins'){
$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
$result = $result[0];
if ($result["isAdmin"] == 1) {
		$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
$query = $db->prepare("UPDATE levels SET starCoins='1' WHERE levelID='$levelID'");
$query->execute();
	}
}
}
if(substr($decodecomment,0,7) == '!delete'){
$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
$result = $result[0];
if ($result["isAdmin"] == 1) {
		$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
$query = $db->prepare("DELETE from levels WHERE levelID='$levelID' LIMIT 1");
$query->execute();
	}
}
}
if(substr($decodecomment,0,1) != '!'){
$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, userID, timeStamp, percent)
VALUES (:userName, :comment, :levelID, :userID, :uploadDate, :percent)");
}else{
$query = $db->prepare("SELECT * FROM modips WHERE IP = 'nope'");
}

if($id != "" AND $comment != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($register == 1){
	if($gjpresult == 1){
		$query->execute([':userName' => $userName, ':comment' => $comment, ':levelID' => $levelID, ':userID' => $userID, ':uploadDate' => $uploadDate, ':percent' => $percent]);
		echo 1;
	}
	else
	{
		echo -1;
	}
	}else{
		$query->execute([':userName' => $userName, ':comment' => $comment, ':levelID' => $levelID, ':userID' => $userID, ':uploadDate' => $uploadDate, ':percent' => $percent]);
		echo 1;
	}
}else{echo -1;}
//file_put_contents("ba7d7fab732396305ddd19a2763adff4/post".time().".log",print_r($_POST,true));
?>
