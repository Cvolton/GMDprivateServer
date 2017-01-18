<?php
error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$levelsstring = "";
$songsstring  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$colonmarker = 1337;
$songcolonmarker = 1337;
$userid = 1337;
//code begins
$toAccountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$toAccountID);
if($gjpresult == 1){
	$query = "SELECT * FROM messages WHERE toAccountID = :toAccountID ORDER BY messageID DESC";
}else{
	$query = "SELECT * FROM messages WHERE toAccountID = '-1' ORDER BY messageID DESC";
}
$query = $db->prepare($query);
$query->execute([':toAccountID' => $toAccountID]);
$result = $query->fetchAll();

$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
for ($x = 0; $x < 9; $x++) {
	$messagepage = $page*10;
	$message1 = $result[$messagepage+$x];
	if($message1["messageID"]!=""){
		if($x != 0){
		echo "|";
	}
	$uploadDate = date("d/m/Y G.i", $message1["timestamp"]);
	echo "6:".$message1["userName"].":3:".$message1["userID"].":2:".$message1["accID"].":1:".$message1["messageID"].":4:".$message1["subject"].":8:".$message1["isNew"].":9:0:7:".$uploadDate."";
	$query12 = $db->prepare("SELECT * FROM users WHERE userID = '".$message1["userID"]."'");
	$query12->execute();
	$result12 = $query12->fetchAll();
if ($query12->rowCount() > 0) {
	$userIDalmost = $result12[0];
	$userID = $userIDalmost["extID"];
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
 echo "#9999:0:50";
?>