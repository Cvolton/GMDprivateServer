<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$accountID = GJPCheck::getAccountIDOrDie();
$threadsArray = [];
$search = ExploitPatch::charclean(ExploitPatch::url_base64_decode($_POST["search"]));
$page = ExploitPatch::number($_POST["page"]) ?: 0;
$offset = $page * 20;

$query = $db->prepare("SELECT * FROM messages, (SELECT max(messageID) messageIDs, (CASE WHEN accID = :accountID THEN toAccountID ELSE accID END) receiverID, (SELECT count(*) FROM messages WHERE accID = receiverID AND toAccountID = :accountID AND isNew = 0) newMessagesCount FROM messages WHERE accID = :accountID OR toAccountID = :accountID GROUP BY receiverID ORDER BY timestamp DESC) messageIDs INNER JOIN users ON users.extID = receiverID WHERE messageID = messageIDs ".(!empty($search) ? "AND users.userName LIKE '%".$search."%'" : "")." ORDER BY timestamp DESC LIMIT 20 OFFSET ".$offset);
$query->execute([':accountID' => $accountID]);
$result = $query->fetchAll();

foreach($result AS &$thread) {
	$threadArray = [];
	
	$modBadgeLevel = $gs->getMaxValuePermission($thread["receiverID"], "modBadgeLevel");

	$threadArray[0] = $thread["receiverID"];
	$threadArray[1] = $thread["receiverID"];
	$threadArray[2] = ExploitPatch::url_base64_encode($thread["userName"]);
	$threadArray[3] = "";
	$threadArray[4] = $thread["newMessagesCount"];
	$threadArray[5] = $accountID;
	$threadArray[6] = $gs->makeTime($thread["timestamp"]);
	$threadArray[7] = "2";
	$threadArray[8] = "";
	$threadArray[9] = $accountID;
	$threadArray[10] = "0";
	$threadArray[11] = "";
	$threadArray[12] = "1";
	$threadArray[13] = "";
	$threadArray[14] = "0";
	$threadArray[15] = $thread["icon"];
	$threadArray[16] = $thread["color1"];
	$threadArray[17] = $thread["color2"];
	$threadArray[18] = $thread["color3"];
	$threadArray[19] = $thread["iconType"];
	$threadArray[20] = $thread["special"];
	$threadArray[21] = "";
	$threadArray[22] = "";
	$threadArray[23] = $thread["timestamp"];
	$threadArray[24] = $modBadgeLevel;
	$threadArray[25] = "0";
	
	$threadsArray[] = implode(":", $threadArray);
}

$threadsString = implode("|", $threadsArray);

$threadsCount = $db->prepare("SELECT count(*) FROM messages, (SELECT max(messageID) messageIDs, (CASE WHEN accID = :accountID THEN toAccountID ELSE accID END) receiverID FROM messages WHERE accID = :accountID OR toAccountID = :accountID GROUP BY receiverID ORDER BY timestamp DESC) messageIDs WHERE messageID = messageIDs");
$threadsCount->execute([':accountID' => $accountID]);
$threadsCount = $threadsCount->fetchColumn();

$newInvitesCount = 0;
$refreshThreadsInterval = 10;
exit($threadsString."#".$threadsCount.":".$offset.":20:".$newInvitesCount.":".$refreshThreadsInterval);
?>