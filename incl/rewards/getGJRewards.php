<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
include "../../config/dailyChests.php";
require "../lib/XORCipher.php";
require "../lib/GJPCheck.php";
require "../lib/generateHash.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$XORCipher = new XORCipher();
$generateHash = new generateHash();
$accountID = $ep->remove($_POST["accountID"]);
$udid = $ep->remove($_POST["udid"]);
if(is_numeric($udid)){
	exit("-1");
}
$chk = $ep->remove($_POST["chk"]);
$gjp = $ep->remove($_POST["gjp"]);
$rewardType = $ep->remove($_POST["rewardType"]);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult !== 1 AND $accountID !== 0){
	exit("-1");
}
$query=$db->prepare("select * from users where extID = ?");
if($accountID != 0){
	$query->execute(array($accountID));
	$register = 1;
}else{
	$query->execute(array($udid));
	$register = 0;
}
$result = $query->fetchAll();
if ($query->rowCount() == 0) {
	$query = $db->prepare("INSERT INTO users (isRegistered, extID)
	VALUES (:register,:id)");
	$query->execute([':register' => $register, ':id' => $id]);
	$query=$db->prepare("select * from users where extID = ?");
	if($accountID != 0){
		$query->execute(array($accountID));
		$register = 1;
	}else{
		$query->execute(array($udid));
		$register = 0;
	}
	$result = $query->fetchAll();
}
$user = $result[0];
$userid = $user["userID"];
$chk = $XORCipher->cipher(base64_decode(substr($chk, 5)),59182);
//rewards
	//Time left
	$currenttime = time();
	$currenttime = $currenttime + 100;
	$chest1time = $user["chest1time"];
	$chest1count = $user["chest1count"];
	$chest2count = $user["chest2count"];
	$chest2time = $user["chest2time"];
	$chest1diff = $currenttime - $chest1time;
	$chest2diff = $currenttime - $chest2time;
	//stuff
	$chest1stuff = rand($chest1minOrbs, $chest1maxOrbs).",".rand($chest1minDiamonds, $chest1maxDiamonds).",".rand($chest1minShards, $chest1maxShards).",".rand($chest1minKeys, $chest1maxKeys)."";
	$chest2stuff = rand($chest2minOrbs, $chest2maxOrbs).",".rand($chest2minDiamonds, $chest2maxDiamonds).",".rand($chest2minShards, $chest2maxShards).",".rand($chest2minKeys, $chest2maxKeys)."";
	//echo $chest1diff ."sakujesvole".$chest2diff;
	$chest1left = max(0,$chest1wait - $chest1diff);
	$chest2left = max(0,$chest2wait - $chest2diff);
	//reward claiming
	if($rewardType == 1){
		if($chest1left != 0){
			exit("-1");
		}
		$chest1count++;
		$query = $db->prepare("UPDATE users SET chest1count=:chest1count, chest1time=:currenttime WHERE userID=:userID");	
		$query->execute([':chest1count' => $chest1count, ':userID' => $userid, ':currenttime' => $currenttime]);
		$chest1left = $chest1wait;
	}
	if($rewardType == 2){
		if($chest2left != 0){
			exit("-1");
		}
		$chest2count++;
		$query = $db->prepare("UPDATE users SET chest2count=:chest2count, chest2time=:currenttime WHERE userID=:userID");	
		$query->execute([':chest2count' => $chest2count, ':userID' => $userid, ':currenttime' => $currenttime]);
		$chest2left = $chest2wait;
	}
	$string = base64_encode($XORCipher->cipher("1:".$userid.":".$chk.":".$udid.":".$accountID.":".$chest1left.":".$chest1stuff.":".$chest1count.":".$chest2left.":".$chest2stuff.":".$chest2count.":".$rewardType."",59182));
	$string = str_replace("/","_",$string);
	$string = str_replace("+","-",$string);
$hash = $generateHash->genSolo4($string);
echo "SaKuJ".$string . "|".$hash;
?>
