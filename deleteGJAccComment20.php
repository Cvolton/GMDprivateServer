<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$commentID = htmlspecialchars($_POST["commentID"],ENT_QUOTES);
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query2 = $db->prepare("SELECT * FROM users WHERE extID = '$accountID'");
	$query2->execute();
	$result = $query2->fetchAll();
	if ($query2->rowCount() > 0) {
		$userIDalmost = $result[0];
		$userID = $userIDalmost[1];
	}
	$query = $db->prepare("DELETE from acccomments WHERE commentID='$commentID' AND userID='$userID' LIMIT 1");
	$query->execute();
	echo "1";
}else{
	echo "-1";
}
?>