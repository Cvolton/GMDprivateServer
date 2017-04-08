<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$type = $ep->remove($_POST["type"]);
$getSent = $ep->remove($_POST["getSent"]);
$userid = 1337;
//code begins
$toAccountID = $ep->remove($_POST["accountID"]);
$gjp = $ep->remove($_POST["gjp"]);
$page = $ep->remove($_POST["page"]);
$offset = $page * 10;
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$toAccountID);
if($gjpresult != 1){
	exit("-1");
}
if($getSent != 1){
	$query = "SELECT * FROM messages WHERE toAccountID = :toAccountID ORDER BY messageID DESC LIMIT 10 OFFSET $offset";
	$countquery = "SELECT count(*) FROM messages WHERE toAccountID = :toAccountID";
}else{
	$query = "SELECT * FROM messages WHERE accID = :toAccountID ORDER BY messageID DESC LIMIT 10 OFFSET $offset";
	$countquery = "SELECT count(*) FROM messages WHERE accID = :toAccountID";
}
$query = $db->prepare($query);
$query->execute([':toAccountID' => $toAccountID]);
$result = $query->fetchAll();
$countquery = $db->prepare($countquery);
$countquery->execute([':toAccountID' => $toAccountID]);
$msgcount = $countquery->fetchColumn();
if($msgcount == 0){
	exit("-2");
}
foreach ($result as &$message1) {
	if($message1["messageID"]!=""){
		$uploadDate = date("d/m/Y G.i", $message1["timestamp"]);
		if($getSent == 1){
			$accountID = $message1["toAccountID"];
		}else{
			$accountID = $message1["accID"];
		}
		$query=$db->prepare("SELECT * FROM users WHERE extID = :accountID");
		$query->execute([':accountID' => $accountID]);
		$result12 = $query->fetchAll()[0];
		$msgstring .= "6:".$result12["userName"].":3:".$result12["userID"].":2:".$result12["extID"].":1:".$message1["messageID"].":4:".$message1["subject"].":8:".$message1["isNew"].":9:".$getSent.":7:".$uploadDate."|";
	}
}
$msgstring = substr($msgstring, 0, -1);
echo $msgstring ."#".$msgcount.":".$offset.":10";
?>