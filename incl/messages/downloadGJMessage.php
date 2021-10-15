<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";

$accountID = GJPCheck::getAccountIDOrDie();
$messageID = ExploitPatch::remove($_POST["messageID"]);

$query=$db->prepare("SELECT accID, toAccountID, timestamp, userName, messageID, subject, isNew, body FROM messages WHERE messageID = :messageID AND (accID = :accID OR toAccountID = :accID) LIMIT 1");
$query->execute([':messageID' => $messageID, ':accID' => $accountID]);
$result = $query->fetch();
if($query->rowCount() == 0){
	exit("-1");
}
if(empty($_POST["isSender"])){
	$query=$db->prepare("UPDATE messages SET isNew=1 WHERE messageID = :messageID AND toAccountID = :accID");
	$query->execute([':messageID' => $messageID, ':accID' =>$accountID]);
	$accountID = $result["accID"];
	$isSender = 0;
}else{
	$isSender = 1;
	$accountID = $result["toAccountID"];
}
$query=$db->prepare("SELECT userName,userID,extID FROM users WHERE extID = :accountID");
$query->execute([':accountID' => $accountID]);
$result12 = $query->fetch();
$uploadDate = date("d/m/Y G.i", $result["timestamp"]);
echo "6:".$result12["userName"].":3:".$result12["userID"].":2:".$result12["extID"].":1:".$result["messageID"].":4:".$result["subject"].":8:".$result["isNew"].":9:".$isSender.":5:".$result["body"].":7:".$uploadDate."";
?>