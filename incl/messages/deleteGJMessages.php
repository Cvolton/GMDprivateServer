<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
if(isset($_POST['messageID'])){$messageID = $ep->remove($_POST["messageID"]);}
$accountID = $ep->remove($_POST["accountID"]);
if(isset($_POST['messages'])){
	$messageID = "0";
	$messages = $ep->remove($_POST["messages"]);
	$messages = preg_replace('/[^0-9,]/', '', $messages);
	$gjp = $ep->remove($_POST["gjp"]);
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$query = $db->prepare("DELETE FROM messages WHERE messageID IN (".$messages.") AND accID=:accountID LIMIT 10");
		$query->execute([':accountID' => $accountID]);
		$query = $db->prepare("DELETE FROM messages WHERE messageID IN (".$messages.") AND toAccountID=:accountID LIMIT 10");
		$query->execute([':accountID' => $accountID]);
		echo "1";
	}else{
		echo "-1";
	}
} else {
	$gjp = $ep->remove($_POST["gjp"]);
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
}
?>
