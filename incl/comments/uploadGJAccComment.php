<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../misc/commands.php";
$cmds = new Commands();
$mainLib = new mainLib();
$ep = new exploitPatch();
$userName = $ep->remove($_POST["userName"]);
$comment = $ep->remove($_POST["comment"]);
$accountID = GJPCheck::getAccountIDOrDie();
$userID = $mainLib->getUserID($accountID, $userName);
$uploadDate = time();
//usercheck
if($accountID != "" AND $comment != ""){
	$decodecomment = base64_decode($comment);
	if($cmds->doProfileCommands($accountID, $decodecomment)){
		exit("-1");
	}
	$query = $db->prepare("INSERT INTO acccomments (userName, comment, userID, timeStamp)
										VALUES (:userName, :comment, :userID, :uploadDate)");
	$query->execute([':userName' => $userName, ':comment' => $comment, ':userID' => $userID, ':uploadDate' => $uploadDate]);
	echo 1;
}else{
	echo -1;
}
?>