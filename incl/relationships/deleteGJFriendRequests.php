<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
if(empty($_POST["targetAccountID"])) exit("-1");
$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::number($_POST["targetAccountID"]);
$isSender = ExploitPatch::number($_POST["isSender"]);

if($isSender) {
	$query = $db->prepare("DELETE FROM friendreqs WHERE accountID = :accountID AND toAccountID = :targetAccountID LIMIT 1");
	if($query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID])) $gs->logAction($accountID, 81, $targetAccountID);
} else {
	$query = $db->prepare("UPDATE friendreqs SET isNew = 2 WHERE toAccountID = :accountID AND accountID = :targetAccountID LIMIT 1");
	if($query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID])) $gs->logAction($accountID, 30, $targetAccountID);
}

exit("1");