<?php
//TODO: see how much of this can be replaced by mainlib functions
chdir(dirname(__FILE__));
include "../lib/connection.php";
include "../../config/dailyChests.php";
require "../lib/XORCipher.php";
require "../lib/GJPCheck.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
require "../lib/generateHash.php";
require_once "../lib/exploitPatch.php";

$extID = $gs->getIDFromPost();
$chk = ExploitPatch::remove($_POST["chk"]);
$rewardType = ExploitPatch::remove($_POST["rewardType"]);
$userid = $gs->getUserID($extID);
$udid = ExploitPatch::remove($_POST["udid"]);
$accountID = ExploitPatch::remove($_POST["accountID"]);
$chk = XORCipher::cipher(base64_decode(substr($chk, 5)),59182);

$query=$db->prepare("SELECT chest1time, chest1count, chest2time, chest2count FROM users WHERE extID = :extID");
$query->execute([':extID' => $extID]);
$user = $query->fetch();

//rewards
//Time left
$currenttime = time();
$currenttime = $currenttime + 100;
$chest1time = $user["chest1time"];
$chest1count = $user["chest1count"];
$chest2time = $user["chest2time"];
$chest2count = $user["chest2count"];
$chest1diff = $currenttime - $chest1time;
$chest2diff = $currenttime - $chest2time;

$chest1items = isset($chest1items) ? $chest1items : [1, 2, 3, 4, 5, 6];
$chest2items = isset($chest2items) ? $chest2items : [1, 2, 3, 4, 5, 6];
//stuff
$chest1stuff = rand($chest1minOrbs, $chest1maxOrbs).",".rand($chest1minDiamonds, $chest1maxDiamonds).",".$chest1items[array_rand($chest1items)].",".rand($chest1minKeys, $chest1maxKeys)."";
$chest2stuff = rand($chest2minOrbs, $chest2maxOrbs).",".rand($chest2minDiamonds, $chest2maxDiamonds).",".$chest2items[array_rand($chest2items)].",".rand($chest2minKeys, $chest2maxKeys)."";
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
$string = base64_encode(XORCipher::cipher("1:".$userid.":".$chk.":".$udid.":".$accountID.":".$chest1left.":".$chest1stuff.":".$chest1count.":".$chest2left.":".$chest2stuff.":".$chest2count.":".$rewardType."",59182));
$string = str_replace("/","_",$string);
$string = str_replace("+","-",$string);
$hash = GenerateHash::genSolo4($string);
echo "SaKuJ".$string . "|".$hash;
