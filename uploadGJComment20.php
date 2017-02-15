<?php
//error_reporting(0);
include "connection.php";
require_once "incl/XORCipher.php";
require_once "incl/GJPCheck.php";
$gjp = explode("|", explode("~", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$userName = explode("|", explode("~", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0];
$comment = explode("|", explode("~", htmlspecialchars($_POST["comment"],ENT_QUOTES))[0])[0];
$gameversion = $_POST["gameVersion"];
if($gameversion < 20){
	$comment = base64_encode($comment);
}
$levelID = explode("|", explode("~", htmlspecialchars($_POST["levelID"],ENT_QUOTES))[0])[0];
$percent = explode("|", explode("~", htmlspecialchars($_POST["percent"],ENT_QUOTES))[0])[0];
if($percent == ""){
	$percent = 0;
}
$accountID = "";
$id = htmlspecialchars($_POST["udid"],ENT_QUOTES);
if($_POST["accountID"]!="" AND $_POST["accountID"]!="0"){
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
$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName)
VALUES (:register, :id, :userName)");

$query->execute([':id' => $id, ':register' => $register, ':userName' => $userName]);
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
		if($starStars == ""){
			$starStars = 0;
		}
		$starCoins = $commentarray[3];
		$starFeatured = $commentarray[4];
		$starDemon = 0;
		$starAuto = 0;
		switch ($commentarray[1]) {
			case "na":
				$starDifficulty = 0;
				break;
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
		$query = $db->prepare("UPDATE levels SET starStars=:starStars, starDifficulty=:starDifficulty, starDemon=:starDemon, starAuto=:starAuto WHERE levelID=:levelID");
		$GJPCheck = new GJPCheck();
		$gjpresult = $GJPCheck->check($gjp,$id);
		if($gjpresult == 1){
			$query->execute([':starStars' => $starStars, ':starDifficulty' => $starDifficulty, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $id, ':value2' => $starStars, ':levelID' => $levelID]);
			if($starFeatured){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $starFeatured, ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);	
				$query = $db->prepare("UPDATE levels SET starFeatured=:starFeatured WHERE levelID=:levelID");
				$query->execute([':starFeatured' => $starFeatured, ':levelID' => $levelID]);
		
			}
			if($starCoins){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $starCoins, ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
				$query = $db->prepare("UPDATE levels SET starCoins=:starCoins WHERE levelID=:levelID");
				$query->execute([':starCoins' => $starCoins, ':levelID' => $levelID]);
			}
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
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
	}
}
}
if(substr($decodecomment,0,5) == '!epic'){
$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
$result = $result[0];
if ($result["isAdmin"] == 1) {
$query = $db->prepare("UPDATE levels SET starEpic='1' WHERE levelID=:levelID");
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute([':levelID' => $levelID]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
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
		$query = $db->prepare("UPDATE levels SET starCoins='1' WHERE levelID = :levelID");
		$query->execute([':levelID' => $levelID]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
	}
}
}
if(substr($decodecomment,0,6) == '!daily'){
	$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
	$query2->execute([':id' => $id]);
	$result = $query2->fetchAll();
	$result = $result[0];
	if ($result["isAdmin"] == 1) {
		$GJPCheck = new GJPCheck();
		$gjpresult = $GJPCheck->check($gjp,$id);
		if($gjpresult == 1){
			$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp) VALUES (:levelID, :uploadDate)");
			$query->execute([':levelID' => $levelID, ':uploadDate' => $uploadDate]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('5', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
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
			$query = $db->prepare("DELETE from levels WHERE levelID=:levelID LIMIT 1");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('6', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
		}
	}
}
if(substr($decodecomment,0,7) == '!setacc'){
	$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
	$query2->execute([':id' => $id]);
	$result = $query2->fetchAll();
	$result = $result[0];
	if ($result["isAdmin"] == 1) {
		$GJPCheck = new GJPCheck();
		$gjpresult = $GJPCheck->check($gjp,$id);
		if($gjpresult == 1){
			$commentarray = explode(' ', $decodecomment);
			$query = $db->prepare("SELECT * FROM accounts WHERE userName = :userName LIMIT 1");
			$query->execute([':userName' => $commentarray[1]]);
			$result = $query->fetchAll();
			$result = $result[0];
			var_dump($result);
			$query = $db->prepare("SELECT * FROM users WHERE extID = :extID LIMIT 1");
			$query->execute([':extID' => $result["accountID"]]);
			$result2 = $query->fetchAll();
			$result2 = $result2[0];
			var_dump($result2);
			$query = $db->prepare("UPDATE levels SET extID=:extID, userID=:userID, userName=:userName WHERE levelID=:levelID");
			$query->execute([':extID' => $result["accountID"], ':userID' => $result2["userID"], ':userName' => $commentarray[1], ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('7', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
		}
	}
}
if(substr($decodecomment,0,7) == '!rename'){
	$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
	$query2->execute([':id' => $id]);
	$result = $query2->fetchAll();
	$result = $result[0];
	$query2 = $db->prepare("SELECT * FROM levels WHERE levelID = :id");
	$query2->execute([':id' => $levelID]);
	$result2 = $query2->fetchAll();
	$result2 = $result2[0];
	if ($result["isAdmin"] == 1 OR $result2["extID"] == $id) {
		$GJPCheck = new GJPCheck();
		$gjpresult = $GJPCheck->check($gjp,$id);
		if($gjpresult == 1){
			$name = explode("|", explode("~", htmlspecialchars(str_replace("!rename ", "", $decodecomment),ENT_QUOTES))[0])[0];
			$query = $db->prepare("UPDATE levels SET levelName=:levelName WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':levelName' => $name]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account) VALUES ('8', :value, :timestamp, :id)");
			$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
		}
	}
}
if(substr($decodecomment,0,5) == '!pass'){
	$query2 = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
	$query2->execute([':id' => $id]);
	$result = $query2->fetchAll();
	$result = $result[0];
	$query2 = $db->prepare("SELECT * FROM levels WHERE levelID = :id");
	$query2->execute([':id' => $levelID]);
	$result2 = $query2->fetchAll();
	$result2 = $result2[0];
	if ($result["isAdmin"] == 1 OR $result2["extID"] == $id) {
		$GJPCheck = new GJPCheck();
		$gjpresult = $GJPCheck->check($gjp,$id);
		if($gjpresult == 1){
			$pass = explode("|", explode("~", htmlspecialchars(str_replace("!pass ", "", $decodecomment),ENT_QUOTES))[0])[0];
			if(is_numeric($pass)){
				$pass = sprintf("%06d", $pass);
				$query = $db->prepare("UPDATE levels SET password=:password WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':password' => "1".$pass]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account) VALUES ('8', :value, :timestamp, :id)");
				$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $id, ':levelID' => $levelID]);
			}
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
?>
