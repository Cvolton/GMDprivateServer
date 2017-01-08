<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$accountID = explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0];
$gjp = explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0];
$toAccountID = explode(";", htmlspecialchars($_POST["toAccountID"],ENT_QUOTES))[0];
$comment = explode(";", htmlspecialchars($_POST["comment"],ENT_QUOTES))[0];
$uploadDate = time();
$query = $db->prepare("INSERT INTO friendreqs (accountID, toAccountID, comment, uploadDate)
VALUES ('$accountID', '$toAccountID', '$comment', '$uploadDate')");
if($accountID != "" AND $toAccountID != ""){
	//GJPCheck
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$query->execute();
		echo 1;
	}else{
		echo -1;
	}
}else{
	echo -1;
}
?>