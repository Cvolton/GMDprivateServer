<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$accountID = GJPCheck::getAccountIDOrDie();
$listID = ExploitPatch::number($_POST["listID"]);
if(is_numeric($listID) AND $accountID == $gs->getListOwner($listID)) {
	$list = $db->prepare('DELETE FROM lists WHERE listID = :listID');
	$list->execute([':listID' => $listID]);
	exit("1");
} else exit("-1");
?>