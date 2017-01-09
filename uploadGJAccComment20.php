<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0])[0])[0];
$gameVersion = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0])[0])[0])[0];
$binaryVersion = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0])[0])[0])[0];
$userName = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0])[0])[0];
$comment = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["comment"],ENT_QUOTES))[0])[0])[0])[0];
$id = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0])[0])[0];
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