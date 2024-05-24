<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/commands.php";
require_once "../../config/misc.php";
$mainLib = new mainLib();
$userName = ExploitPatch::remove($_POST["userName"]);
$comment = ExploitPatch::remove($_POST["comment"]);
if($enableCommentLengthLimiter && strlen($comment) > $maxAccountCommentLength) exit("temp_0_You cannot post account comments above $maxAccountCommentLength characters!");
$accountID = GJPCheck::getAccountIDOrDie();
$userID = $mainLib->getUserID($accountID, $userName);
$uploadDate = time();
//usercheck
if($accountID != "" AND $comment != ""){
	$decodecomment = base64_decode($comment);
	if(Commands::doProfileCommands($accountID, $decodecomment)) exit("-1");
	$checkCommentBan = $db->prepare("SELECT * FROM users WHERE extID = :accountID AND isCommentBanned = 1");
	$checkCommentBan->execute([':accountID' => $accountID]);
	if($checkCommentBan->rowCount() > 0) die("-10");
	$query = $db->prepare("INSERT INTO acccomments (userName, comment, userID, timeStamp) VALUES (:userName, :comment, :userID, :uploadDate)");
	$query->execute([':userName' => $userName, ':comment' => $comment, ':userID' => $userID, ':uploadDate' => $uploadDate]);
	echo 1;
}else{
	echo -1;
}
?>