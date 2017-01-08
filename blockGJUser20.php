<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
$uploadDate = time();
/*
			PERSON 1 BLOCK
*/
$query = "SELECT * FROM accounts WHERE accountID = '$targetAccountID'";
$query = $db->prepare($query);
$query->execute();
$result = $query->fetchAll();
$accinfo = $result[0];
$blockedBy = $accinfo["blockedBy"];
if($blockedBy!=""){
	$blockedBy = $blockedBy.",";
}
$blockedBy = $blockedBy . $accountID;
$query3 = $db->prepare("UPDATE accounts SET blockedBy='$blockedBy' WHERE accountID='$targetAccountID'");
/*
			PERSON 2 BLOCK
*/
$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
$query = $db->prepare($query);
$query->execute();
$result = $query->fetchAll();
$accinfo = $result[0];
$blocked = $accinfo["blocked"];
if($blocked!=""){
	$blocked = $blocked.",";
}
$blocked = $blocked . $targetAccountID;
$query2 = $db->prepare("UPDATE accounts SET blocked='$blocked' WHERE accountID='$accountID'");

if($accountID != "" AND $targetAccountID != ""){
	//GJPCheck
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$query3->execute();
		$query2->execute();
		echo 1;
	}else{
		echo -1;
	}
}else{
	echo -1;
}
?>