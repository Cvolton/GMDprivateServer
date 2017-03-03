<?php
include "connection.php";
include "questInfo.php";
require "incl/XORCipher.php";
require "incl/generateHash.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$usedids = array();
$XORCipher = new XORCipher();
$generateHash = new generateHash();
$accountID = $ep->remove($_POST["accountID"]);
$udid = $ep->remove($_POST["udid"]);
$chk = $ep->remove($_POST["chk"]);
$query=$db->prepare("select * from users where extID = ?");
if($accountID != 0){
	$query->execute(array($accountID));
}else{
	$query->execute(array($udid));
}
$result = $query->fetchAll();
$result = $result[0];
$userid = $result["userID"];
$chk = $XORCipher->cipher(base64_decode(substr($chk, 5)),19847);
//Generating quest IDs
$from = strtotime('2000-12-17');
$today = time();
$difference = $today - $from;
$questID = floor($difference / 86400);
$questID = $questID * 3;
$quest1ID = $questID;
$quest2ID = $questID+1;
$quest3ID = $questID+2;
//Time left
$midnight = strtotime("tomorrow 00:00:00");
$current = time();
$timeleft = $midnight - $current;
$query=$db->prepare("select * from quests");
$query->execute();
$result = $query->fetchAll();
shuffle($result);
//quests
$quest1 = $quest1ID.",".$result[0]["type"].",".$result[0]["amount"].",".$result[0]["reward"].",".$result[0]["name"]."";
$quest2 = $quest2ID.",".$result[1]["type"].",".$result[1]["amount"].",".$result[1]["reward"].",".$result[1]["name"]."";
$quest3 = $quest3ID.",".$result[2]["type"].",".$result[2]["amount"].",".$result[2]["reward"].",".$result[2]["name"]."";
$string = base64_encode($XORCipher->cipher("SaKuJ:".$userid.":".$chk.":".$udid.":".$accountID.":".$timeleft.":".$quest1.":".$quest2.":".$quest3."",19847));
$hash = $generateHash->genSolo3($string);
echo "SaKuJ".$string . "|".$hash;
?>
