<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/commands.php";
require_once "../lib/automod.php";
require_once "../../config/misc.php";
$gs = new mainLib();
if(Automod::isAccountsDisabled(1)) exit(($_POST['gameVersion'] > 20 ? 'temp_0_Account posting is currently disabled!' : '-1'));
$userName = ExploitPatch::remove($_POST["userName"]);
$comment = ExploitPatch::remove($_POST["comment"]);
$commentLength = ($gameVersion >= 20) ? mb_strlen(ExploitPatch::url_base64_decode($comment)) : mb_strlen($comment);
if($enableCommentLengthLimiter && $commentLength > $maxAccountCommentLength) exit("temp_0_You cannot post account comments above $maxAccountCommentLength characters! (Your's ".$commentLength.")");
$accountID = GJPCheck::getAccountIDOrDie();
$userID = $gs->getUserID($accountID, $userName);
$uploadDate = time();
//usercheck
if($accountID != "" AND $comment != "") {
	$decodecomment = ExploitPatch::url_base64_decode($comment);
	if(Commands::doProfileCommands($accountID, $decodecomment)) exit("-1");
	$checkCommentBan = $gs->getPersonBan($accountID, $userID, 3);
	if($checkCommentBan) ($_POST['gameVersion'] > 20 ? exit("temp_".($checkCommentBan['expires'] - time())."_".ExploitPatch::translit(ExploitPatch::url_base64_decode($checkCommentBan['reason']))) : exit('-10'));
	$query = $db->prepare("INSERT INTO acccomments (userName, comment, userID, timeStamp) VALUES (:userName, :comment, :userID, :uploadDate)");
	$query->execute([':userName' => $userName, ':comment' => $comment, ':userID' => $userID, ':uploadDate' => $uploadDate]);
	Automod::checkAccountPostsSpamming($userID);
	$gs->logAction($accountID, 14, $userName, $comment, $db->lastInsertId());
	echo 1;
} else echo -1;
?>