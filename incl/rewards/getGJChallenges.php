<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require "../lib/XORCipher.php";
require "../lib/generateHash.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$usedids = array();
$accountID = ExploitPatch::remove($_POST["accountID"]);
$udid = ExploitPatch::remove($_POST["udid"]);
if(is_numeric($udid)){
	exit("-1");
}
$chk = ExploitPatch::remove($_POST["chk"]);
if($accountID != 0){
	$userID = $gs->getUserID($accountID);
}else{
	$userID = $gs->getUserID($udid);
}
$chk = XORCipher::cipher(base64_decode(substr($chk, 5)),19847);
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
$query=$db->prepare("SELECT type,amount,reward,name FROM quests");
$query->execute();
$result = $query->fetchAll();
//var_dump($result);
shuffle($result);
//var_dump($result);
//quests
if (empty($result[0]) || empty($result[1]) || empty($result[2])) {
	exit("-1");
}
$quest1 = $quest1ID.",".$result[0]["type"].",".$result[0]["amount"].",".$result[0]["reward"].",".$result[0]["name"]."";
$quest2 = $quest2ID.",".$result[1]["type"].",".$result[1]["amount"].",".$result[1]["reward"].",".$result[1]["name"]."";
$quest3 = $quest3ID.",".$result[2]["type"].",".$result[2]["amount"].",".$result[2]["reward"].",".$result[2]["name"]."";
$string = base64_encode(XORCipher::cipher("SaKuJ:".$userID.":".$chk.":".$udid.":".$accountID.":".$timeleft.":".$quest1.":".$quest2.":".$quest3."",19847));
$hash = GenerateHash::genSolo3($string);
echo "SaKuJ".$string . "|".$hash;
?>
