<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
if(isset($_POST['messageID'])){$messageID = $ep->remove($_POST["messageID"]);} //check if deletes single message
$accountID = $ep->remove($_POST["accountID"]);
if(isset($_POST['messages'])){ // if more than 1 message to be deleted
	$messageID = "0"; // value 0 because isn't single
	$messages = $ep->remove($_POST["messages"]);
	$messages = preg_replace('/[^0-9,]/', '', $messages); // remplace any malicious value
	$gjp = $ep->remove($_POST["gjp"]);
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$query = $db->prepare("DELETE FROM messages WHERE messageID IN (".$messages.") AND accID=:accountID LIMIT 10");
		$query->execute([':accountID' => $accountID]); // delete multiple messages max 10 per request
		$query = $db->prepare("DELETE FROM messages WHERE messageID IN (".$messages.") AND toAccountID=:accountID LIMIT 10");
		$query->execute([':accountID' => $accountID]);
		echo "1";
	}else{
		echo "-1";
	}
} else { // this else starts the deletion of a single message
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
