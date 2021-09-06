<?php
//TODO: unify the queries
//TODO: does real geometry dash only delete messages for one person? if so, implement this
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
if(isset($_POST['messageID'])){$messageID = ExploitPatch::remove($_POST["messageID"]);}
$accountID = GJPCheck::getAccountIDOrDie();
if(isset($_POST['messages'])){
	$messages = ExploitPatch::numbercolon($_POST["messages"]);
	$query = $db->prepare("DELETE FROM messages WHERE messageID IN (".$messages.") AND accID=:accountID LIMIT 10");
	$query->execute([':accountID' => $accountID]);
	$query = $db->prepare("DELETE FROM messages WHERE messageID IN (".$messages.") AND toAccountID=:accountID LIMIT 10");
	$query->execute([':accountID' => $accountID]);
	echo "1";
} else {
	$query = $db->prepare("DELETE FROM messages WHERE messageID=:messageID AND accID=:accountID LIMIT 1");
	$query->execute([':messageID' => $messageID, ':accountID' => $accountID]);
	$query = $db->prepare("DELETE FROM messages WHERE messageID=:messageID AND toAccountID=:accountID LIMIT 1");
	$query->execute([':messageID' => $messageID, ':accountID' => $accountID]);
	echo "1";
}
?>
