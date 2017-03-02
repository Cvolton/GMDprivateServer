<?php
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$levelID = $ep->remove($_POST["levelID"]);
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
	$query = $db->prepare("DELETE from levels WHERE levelID=:levelID AND userID=:userID LIMIT 1");
	$query->execute([':levelID' => $levelID, ':userID' => $userID]);
	echo "1";
}else{
	echo "-1";
}
?>