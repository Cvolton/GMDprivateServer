<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$accountID = GJPCheck::getAccountIDOrDie();
$threadID = ExploitPatch::number($_POST["threadID"]) ?: 0;
$beforeID = ExploitPatch::number($_POST["beforeID"]) ?: 0;
$afterID = ExploitPatch::number($_POST["afterID"]) ?: 0;

$messagesArray = [];

$messages = $db->prepare("SELECT * FROM messages WHERE (accID = :accountID AND toAccountID = :receiver) OR (accID = :receiver AND toAccountID = :accountID) ".($beforeID > 0 ? "AND messageID < ".$beforeID : "")." ".($afterID > 0 ? "AND messageID > ".$afterID : "")." ORDER BY timestamp ASC");
$messages->execute([':accountID' => $accountID, ':receiver' => $threadID]);
$messages = $messages->fetchAll();

foreach($messages AS &$message) {
	$messageArray = [];
	
	$messageArray[0] = $message["messageID"];
	$messageArray[1] = $message["accID"];
	$messageArray[2] = ExploitPatch::url_base64_encode(XORCipher::cipher(ExploitPatch::url_base64_decode($message["body"]), 14251));
	$messageArray[3] = $message["timestamp"];
	$messageArray[4] = "0"; // 1 = message is deleted
	
	$messagesArray[] = implode(":", $messageArray);
}

$messagesString = implode("|", $messagesArray);

exit($messagesString."######");
?>