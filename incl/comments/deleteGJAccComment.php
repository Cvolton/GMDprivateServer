<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$commentID = ExploitPatch::remove($_POST["commentID"]);
$accountID = GJPCheck::getAccountIDOrDie();

$userID = $gs->getUserID($accountID);
$getCommentData = $db->prepare('SELECT * FROM acccomments WHERE commentID = :commentID');
$getCommentData->execute([':commentID' => $commentID]);
$getCommentData = $getCommentData->fetch();
if(!$getCommentData) exit("-1");
if($gs->checkPermission($accountID, "actionDeleteComment") == 1) {
	$query = $db->prepare("DELETE FROM acccomments WHERE commentID = :commentID LIMIT 1");
	if($query->execute([':commentID' => $commentID])) $gs->logAction($accountID, 12, $getCommentData['userName'], $getCommentData['comment'], $accountID, $commentID, ($getCommentData['likes'] - $getCommentData['dislikes']));
} else {
	$query = $db->prepare("DELETE FROM acccomments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
	if($query->execute([':userID' => $userID, ':commentID' => $commentID])) $gs->logAction($accountID, 12, $getCommentData['userName'], $getCommentData['comment'], $gs->getExtID($userID), $commentID, ($getCommentData['likes'] - $getCommentData['dislikes']));
}
echo "1";