<?php
//error_reporting(0);
include "connection.php";
require "incl/GJPCheck.php";
//here im getting all the data
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$toAccountID = htmlspecialchars($_POST["toAccountID"],ENT_QUOTES);
$comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
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