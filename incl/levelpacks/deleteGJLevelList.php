<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$accountID = GJPCheck::getAccountIDOrDie();
$listID = ExploitPatch::number($_POST["listID"]);
if(is_numeric($listID) AND $accountID == $gs->getListOwner($listID)) {
	$listData = $db->prepare('SELECT * FROM lists WHERE listID = :listID AND accountID = :accountID');
	$listData->execute([':listID' => $listID, ':accountID' => $accountID]);
	$listData = $listData->fetch();
	$list = $db->prepare('DELETE FROM lists WHERE listID = :listID');
	$list->execute([':listID' => $listID]);
	$gs->logAction($accountID, 19, $listData['listName'], $listData['listlevels'], $listID, $listData['difficulty'], $listData['unlisted']);
	$gs->sendLogsListChangeWebhook($listID, $accountID, $listData);
	exit("1");
} else exit("-1");
?>