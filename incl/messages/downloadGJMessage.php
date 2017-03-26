<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$accountID = $ep->remove($_POST["accountID"]);
$gjp = $ep->remove($_POST["gjp"]);
$messageID = $ep->remove($_POST["messageID"]);
$isSender = $ep->remove($_POST["isSender"]);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query=$db->prepare("select * from messages where messageID = :messageID");
	$query->execute([':messageID' => $messageID]);
	$result = $query->fetchAll()[0];
	if($accountID == $result["accID"] OR $accountID == $result["toAccountID"]){
		if($isSender != 1){
			$query=$db->prepare("UPDATE messages SET isNew=1 WHERE messageID = :messageID");
			$query->execute([':messageID' => $messageID]);
			$accountID = $result["accID"];
		}else{
			$accountID = $result["toAccountID"];
		}
		$query=$db->prepare("SELECT * FROM users WHERE extID = :accountID");
		$query->execute([':accountID' => $accountID]);
		$result12 = $query->fetchAll()[0];
		$uploadDate = date("d/m/Y G.i", $result["timestamp"]);
		echo "6:".$result12["userName"].":3:".$result12["userID"].":2:".$result12["extID"].":1:".$result["messageID"].":4:".$result["subject"].":8:".$result["isNew"].":9:".$isSender.":5:".$result["body"].":7:".$uploadDate."";
	}else{
		echo -1;
	}
}else{
	echo -1;
}
?>