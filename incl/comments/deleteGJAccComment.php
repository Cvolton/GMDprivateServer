<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php"; //this is connection.php too
$gs = new mainLib();
$commentID = ExploitPatch::remove($_POST["commentID"]);
$accountID = GJPCheck::getAccountIDOrDie();

//TODO: replace this with the respective MainLib function
$query2 = $db->prepare("SELECT userID FROM users WHERE extID = :accountID");
$query2->execute([':accountID' => $accountID]);
if ($query2->rowCount() > 0) {
	$userID = $query2->fetchColumn();
}
if($gs->checkPermission($accountID, "actionDeleteComment") == 1) {
	$query = $db->prepare("DELETE FROM acccomments WHERE commentID = :commentID LIMIT 1");
	$query->execute([':commentID' => $commentID]);
}else{
	$query = $db->prepare("DELETE FROM acccomments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
	$query->execute([':userID' => $userID, ':commentID' => $commentID]);
}
echo "1";