<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$accountID = $ep->remove($_POST["accountID"]);
$gjp = $ep->remove($_POST["gjp"]);
$toAccountID = $ep->remove($_POST["toAccountID"]);
$comment = $ep->remove($_POST["comment"]);
$uploadDate = time();
$query = $db->prepare("SELECT * FROM friendreqs WHERE (accountID=:accountID AND toAccountID=:toAccountID) OR (toAccountID=:accountID AND accountID=:toAccountID)");
$query->execute([':accountID' => $accountID, ':toAccountID' => $toAccountID]);
if($query->rowCount() == 0){
	$query = $db->prepare("INSERT INTO friendreqs (accountID, toAccountID, comment, uploadDate)
	VALUES (:accountID, :toAccountID, :comment, :uploadDate)");
	if($accountID != "" AND $toAccountID != ""){
		//GJPCheck
		$GJPCheck = new GJPCheck();
		$gjpresult = $GJPCheck->check($gjp,$accountID);
		if($gjpresult == 1){
			$query->execute([':accountID' => $accountID, ':toAccountID' => $toAccountID, ':comment' => $comment, ':uploadDate' => $uploadDate]);
			echo 1;
		}else{
			echo -1;
		}
	}else{
		echo -1;
	}	
}else{
	echo -1;
}
?>