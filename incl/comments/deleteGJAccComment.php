<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$commentID = $ep->remove($_POST["commentID"]);
$accountID = $ep->remove($_POST["accountID"]);
$gjp = $ep->remove($_POST["gjp"]);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query2 = $db->prepare("SELECT userID FROM users WHERE extID = :accountID");
	$query2->execute([':accountID' => $accountID]);
	if ($query2->rowCount() > 0) {
		$userID = $query2->fetchColumn();
	}
	$query = $db->prepare("DELETE FROM acccomments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
	$query->execute([':userID' => $userID, ':commentID' => $commentID]);
	echo "1";
}else{
	echo "-1";
}
?>