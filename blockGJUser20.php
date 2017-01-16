<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
if($accountID != "" AND $targetAccountID != ""){
	//GJPCheck
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$query = $db->prepare("INSERT INTO blocks (person1, person2) VALUES (:accountID, :targetAccountID)");
		$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
		echo 1;
	}else{
		echo -1;
	}
}else{
	echo -1;
}
?>