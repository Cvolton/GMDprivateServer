<?php
include "connection.php";
include "questInfo.php";
require "incl/XORCipher.php";
require "incl/GJPCheck.php";
require "incl/generateHash.php";
$XORCipher = new XORCipher();
$generateHash = new generateHash();
$accountID = htmlspecialchars($_POST["accountID"], ENT_QUOTES);
$udid = htmlspecialchars($_POST["udid"], ENT_QUOTES);
$chk = htmlspecialchars($_POST["chk"], ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"], ENT_QUOTES);
$rewardType = htmlspecialchars($_POST["rewardType"], ENT_QUOTES);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult !== 1 AND $accountID !== 0){
	exit("-1");
}
$query=$db->prepare("select * from users where extID = ?");
if($accountID != 0){
	$query->execute(array($accountID));
}else{
	$query->execute(array($udid));
}
$result = $query->fetchAll();
$user = $result[0];
$userid = $user["userID"];
$chk = $XORCipher->cipher(base64_decode(substr($chk, 5)),59182);
//rewards
	//Time left
	$currenttime = time();
	$chest1time = $user["chest1time"];
	$chest1count = $user["chest1count"];
	$chest2count = $user["chest2count"];
	$chest1diff = $currenttime - $chest1time;
	$chest2time = $user["chest2time"];
	$chest2diff = $currenttime - $chest2time;
	//stuff
	$chest1stuff = rand($chest1minOrbs, $chest1maxOrbs).",".rand($chest1minDiamonds, $chest1maxDiamonds).",".rand($chest1minShards, $chest1maxShards).",".rand($chest1minKeys, $chest1maxKeys)."";
	$chest2stuff = rand($chest2minOrbs, $chest2maxOrbs).",".rand($chest2minDiamonds, $chest2maxDiamonds).",".rand($chest2minShards, $chest2maxShards).",".rand($chest2minKeys, $chest2maxKeys)."";
	//echo $chest1diff ."sakujesvole".$chest2diff;
	if($chest1diff > 14399){
		$chest1left = 0;
	}else{
		$chest1left = 14400 - $chest1diff;
	}
	if($chest2diff > 86399){
		$chest2left = 0;
	}else{
		$chest2left = 86400 - $chest1diff;
	}
	if($rewardType == 1){
		$chest1count++;
		$query = $db->prepare("UPDATE users SET chest1count=:chest1count, chest1time=:currenttime WHERE userID=:userID");	
		$query->execute([':chest1count' => $chest1count, ':userID' => $userid, ':currenttime' => $currenttime]);
	}
	if($rewardType == 2){
		$chest2count++;
		$query = $db->prepare("UPDATE users SET chest2count=:chest2count, chest2time=:currenttime WHERE userID=:userID");	
		$query->execute([':chest2count' => $chest2count, ':userID' => $userid, ':currenttime' => $currenttime]);
	}
	$string = base64_encode($XORCipher->cipher("SaKuJ:".$userid.":".$chk.":".$udid.":".$accountID.":".$chest1left.":".$chest1stuff.":".$chest1count.":".$chest2left.":".$chest2stuff.":".$chest2count.":".$rewardType."",59182));
$hash = $generateHash->genSolo4($string);
echo "SaKuJ".$string . "|".$hash;
?>
