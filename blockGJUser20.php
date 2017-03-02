<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$accountID = $ep->remove($_POST["accountID"]);
$gjp = $ep->remove($_POST["gjp"]);
$targetAccountID = $ep->remove($_POST["targetAccountID"]);
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