<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp =  explode("(", explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$gameVersion =  explode("(", explode(";", htmlspecialchars($_POST["gameVersion"],ENT_QUOTES))[0])[0];
$binaryVersion =  explode("(", explode(";", htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES))[0])[0];
$secret =  explode("(", explode(";", htmlspecialchars($_POST["secret"],ENT_QUOTES))[0])[0];
$subject =  explode("(", explode(";", htmlspecialchars($_POST["subject"],ENT_QUOTES))[0])[0];
$toAccountID =  explode("(", explode(";", htmlspecialchars($_POST["toAccountID"],ENT_QUOTES))[0])[0];
$body =  explode("(", explode(";", htmlspecialchars($_POST["body"],ENT_QUOTES))[0])[0];
$accID =  explode("(", explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];

$query3 = "SELECT * FROM users WHERE extID = '".$accID."' ORDER BY userName DESC";
$query3 = $db->prepare($query3);
$query3->execute();
$result = $query3->fetchAll();
$result69 = $result[0];
$userName = $result69["userName"];

//continuing the accounts system
$accountID = "";
$id = $accID =  explode("(", explode(";", htmlspecialchars($_POST["udid"],ENT_QUOTES))[0])[0];
if($_POST["accountID"]!=""){
	$id = explode("(", explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
	$register = 1;
}else{
	$register = 0;
}
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

$query = $db->prepare("INSERT INTO messages (subject, body, accID, userID, userName, toAccountID, secret)
VALUES ('$subject', '$body', '$accID', '$userID', '$userName', '$toAccountID', '$secret')");

$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accID);
if($gjpresult == 1){
	$query->execute();
	echo 1;
}else{echo -1;}
?>