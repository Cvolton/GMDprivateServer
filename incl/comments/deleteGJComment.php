<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php"; //this is connection.php too
$gs = new mainLib();
$commentID = ExploitPatch::remove($_POST["commentID"]);
$accountID = GJPCheck::getAccountIDOrDie();

$userID = $gs->getUserID($accountID);
$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
$query->execute([':commentID' => $commentID, ':userID' => $userID]);
if($query->rowCount() == 0){
	$query = $db->prepare("SELECT users.extID FROM comments INNER JOIN levels ON levels.levelID = comments.levelID INNER JOIN users ON levels.userID = users.userID WHERE commentID = :commentID");
	$query->execute([':commentID' => $commentID]);
	$creatorAccID = $query->fetchColumn();
	if($creatorAccID == $accountID || $gs->checkPermission($accountID, "actionDeleteComment") == 1){
		$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID LIMIT 1");
		$query->execute([':commentID' => $commentID]);
	}
}
echo "1";
