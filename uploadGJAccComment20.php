<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = mysql_real_escape_string($_POST["gjp"]);
$gameVersion = mysql_real_escape_string($_POST["gameVersion"]);
$binaryVersion = mysql_real_escape_string($_POST["binaryVersion"]);
$userName = mysql_real_escape_string($_POST["userName"]);
$comment = mysql_real_escape_string($_POST["comment"]);
$id = mysql_real_escape_string($_POST["accountID"]);
$query2 = $db->prepare("SELECT * FROM users WHERE extID = '".$id."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$userIDalmost = $result[0];
$userID = $userIDalmost[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES ('$register','$id')");

$query->execute();
$userID = $db->lastInsertId();
}
$uploadDate = time();

$query = $db->prepare("INSERT INTO acccomments (userName, comment, userID, timeStamp)
VALUES ('$userName', '$comment', '$userID', '$uploadDate')");
if($id != "" AND $comment != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute();
		echo 1;
	}else{echo -1;}
}else{echo -1;}
?>
