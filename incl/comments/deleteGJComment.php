<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php"; //this is connection.php too
$gs = new mainLib();
$commentID = $ep->remove($_POST["commentID"]);
$accountID = GJPCheck::getAccountIDOrDie();

//TODO: optimize these queries, there's surely a way
$query = $db->prepare("SELECT userID FROM users WHERE extID = :accountID");
$query->execute([':accountID' => $accountID]);
$userID = $query->fetchColumn();
$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
$query->execute([':commentID' => $commentID, ':userID' => $userID]);
if($query->rowCount() == 0){
	$query = $db->prepare("SELECT levelID FROM comments WHERE commentID = :commentID");
	$query->execute([':commentID' => $commentID]);
	$levelID = $query->fetchColumn();
	$query = $db->prepare("SELECT userID FROM levels WHERE levelID = :levelID");
	$query->execute([':levelID' => $levelID]);
	$creatorID = $query->fetchColumn();
	$query = $db->prepare("SELECT extID FROM users WHERE userID = :userID");
	$query->execute([':userID' => $creatorID]);
	$creatorAccID = $query->fetchColumn();
	if($creatorAccID == $accountID || $gs->checkPermission($accountID, "actionDeleteComment") == 1){
		$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID AND levelID=:levelID LIMIT 1");
		$query->execute([':commentID' => $commentID, ':levelID' => $levelID]);
	}
}
echo "1";