<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
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
if($gjpresult == 1){
	if($getSent != 1){
		$query = "SELECT * FROM messages WHERE toAccountID = :toAccountID ORDER BY messageID DESC LIMIT 10 OFFSET $offset";
		$query2 = "SELECT * FROM messages WHERE toAccountID = :toAccountID";
	}else{
		$query = "SELECT * FROM messages WHERE accID = :toAccountID ORDER BY messageID DESC LIMIT 10 OFFSET $offset";
		$query2 = "SELECT * FROM messages WHERE accID = :toAccountID";
	}
}else{
	$query = "SELECT * FROM messages WHERE toAccountID = '-1' ORDER BY messageID DESC";
}
$query = $db->prepare($query);
$query->execute([':toAccountID' => $toAccountID]);
$result = $query->fetchAll();
if(!array_key_exists(8,$result)){
	$msgcount = $offset + $query->rowCount(); 
}else{
	$msgcount = 9999;
}
/*$query2 = $db->prepare($query2);
$query2->execute([':toAccountID' => $toAccountID]);
$msgcount = $query2->rowCount();*/

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
		echo "6:".$result12["userName"].":3:".$result12["userID"].":2:".$result12["extID"].":1:".$message1["messageID"].":4:".$message1["subject"].":8:".$message1["isNew"].":9:".$getSent.":7:".$uploadDate."|";
		if ($query->rowCount() > 0) {
			$userID = $result12["extID"];
			if(is_numeric($userID)){
				$userIDnumba = $userID;
			}else{
				$userIDnumba = 0;
			}
		}
	if($x == 0){
		$levelsstring = $levelsstring . $message1["userID"] . ":" . $message1["userName"] . ":" . $userIDnumba;
	}else{
		$levelsstring = $levelsstring ."|" . $message1["userID"] . ":" . $message1["userName"] . ":" . $userIDnumba;
	}
	$userid = $userid + 1;
}
}
 echo "#".$msgcount.":".$offset.":10";
?>