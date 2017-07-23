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
	$query = $db->prepare("SELECT userID FROM users WHERE extID = :accountID");
	$query->execute([':accountID' => $accountID]);
	$userID = $query->fetchColumn();
	$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID AND userID=:userID LIMIT 1");
	$query->execute([':commentID' => $commentID, ':userID' => $userID]);
	if($query->rowCount() == 0){
		$query = $db->prepare("SELECT levelID FROM comments WHERE commentID = :commentID");
		$query->execute([':commentID' => $commentID]);
		$levelID = $query->fetchColumn();
		$query = $db->prepare("SELECT userID FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $levelID]);
		$creatorID = $query->fetchColumn();
		$query = $db->prepare("SELECT extID FROM users WHERE userID = :userID");
		$query->execute([':userID' => $creatorID]);
		$creatorAccID = $query->fetchColumn();
		if($creatorAccID == $accountID){
			$query = $db->prepare("DELETE FROM comments WHERE commentID=:commentID AND levelID=:levelID LIMIT 1");
			$query->execute([':commentID' => $commentID, ':levelID' => $levelID]);
		}
	}
	echo "1";
}else{
	echo "-1";
}
?>