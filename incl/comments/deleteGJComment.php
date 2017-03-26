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
	$query2 = $db->prepare("SELECT * FROM users WHERE extID = :accountID");
	$query2->execute([':accountID' => $accountID]);
	$result = $query2->fetchAll();
	if ($query2->rowCount() > 0) {
		$userIDalmost = $result[0];
		$userID = $userIDalmost[1];
	}
	$query = $db->prepare("DELETE from comments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
	$query->execute([':commentID' => $commentID, ':userID' => $userID]);
	echo "1";
}else{
	echo "-1";
}
?>