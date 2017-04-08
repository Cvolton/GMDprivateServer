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
		$userID = $query2->fetchAll()[0]["userID"];
	}
	$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
	$query->execute([':commentID' => $commentID, ':userID' => $userID]);
	echo "1";
}else{
	echo "-1";
}
?>