<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$messageID = htmlspecialchars($_POST["messageID"],ENT_QUOTES);
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query = $db->prepare("DELETE FROM messages WHERE messageID=:messageID AND accID=:accountID LIMIT 1");
	$query->execute([':messageID' => $messageID, ':accountID' => $accountID]);
	$query = $db->prepare("DELETE FROM messages WHERE messageID=:messageID AND toAccountID=:accountID LIMIT 1");
	$query->execute([':messageID' => $messageID, ':accountID' => $accountID]);
	echo "1";
}else{
	echo "-1";
}
?>