<?php
error_reporting(0);
include "connection.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$levelsstring = "";
$songsstring  = "";
$type = $ep->remove($_POST["type"]);
$colonmarker = 1337;
$songcolonmarker = 1337;
$userid = 1337;
//here da code begins
$accountid = $ep->remove($_POST["accountID"]);
$query2 = $db->prepare("SELECT * FROM users WHERE extID = :accountid");
$query2->execute([':accountid' => $accountid]);
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$userIDalmost = $result[0];
$userID = $userIDalmost[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES (:register,:id)");

$query->execute([':register' => $register, ':id' => $id]);
$userID = $db->lastInsertId();
}
$query = "SELECT * FROM acccomments WHERE userID = :userID ORDER BY timeStamp DESC";
$query = $db->prepare($query);
$query->execute([':userID' => $userID]);
$result = $query->fetchAll();
$page = $ep->remove($_POST["page"]);
for ($x = 0; $x < 9; $x++) {
	$commentpage = $page*10;
	$comment1 = $result[$commentpage+$x];
	if($comment1["commentID"]!=""){
		if($x != 0){
		echo "|";
	}
	$uploadDate = date("d/m/Y G:i", $comment1["timestamp"]);
	echo "2~".$comment1["comment"]."~3~".$comment1["userID"]."~4~".$comment1["likes"]."~5~0~7~0~9~".$uploadDate."~6~".$comment1["commentID"];
	$query12 = $db->prepare("SELECT * FROM users WHERE userID = '".$comment1["userID"]."'");
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
	$levelsstring = $levelsstring . $comment1["userID"] . ":" . $comment1["userName"] . ":" . $userIDnumba;
	}else{
	$levelsstring = $levelsstring ."|" . $comment1["userID"] . ":" . $comment1["userName"] . ":" . $userIDnumba;
	}
	$userid = $userid + 1;
	}
}
	echo "#".$levelsstring;
	echo "#9999:".$commentpage.":10";
?>