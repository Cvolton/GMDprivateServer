<?php
include "connection.php";
include "questInfo.php";
require "incl/XORCipher.php";
require "incl/generateHash.php";
$XORCipher = new XORCipher();
$generateHash = new generateHash();
$accountID = htmlspecialchars($_POST["accountID"], ENT_QUOTES);
$udid = htmlspecialchars($_POST["udid"], ENT_QUOTES);
$chk = htmlspecialchars($_POST["chk"], ENT_QUOTES);
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
$quest1 = "0,".$quest1Type.",".$quest1Amount.",".$quest1Reward.",".$quest1Name."";
$quest2 = "0,".$quest2Type.",".$quest2Amount.",".$quest2Reward.",".$quest2Name."";
$quest3 = "0,".$quest3Type.",".$quest3Amount.",".$quest3Reward.",".$quest3Name."";
$string = base64_encode($XORCipher->cipher("SaKuJ:".$userid.":".$chk.":".$udid.":".$accountID.":133700:".$quest1.":".$quest2.":".$quest3."",19847));
$hash = $generateHash->genSolo3($string);
echo "SaKuJ".$string . "|".$hash;
?>
