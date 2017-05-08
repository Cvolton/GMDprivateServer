<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
if(empty($_POST["accountID"]) OR empty($_POST["toAccountID"])){
	exit("-1");
}
$accountID = $ep->remove($_POST["accountID"]);
$gjp = $ep->remove($_POST["gjp"]);
$toAccountID = $ep->remove($_POST["toAccountID"]);
$comment = $ep->remove($_POST["comment"]);
$uploadDate = time();
$query = $db->prepare("SELECT count(*) FROM friendreqs WHERE (accountID=:accountID AND toAccountID=:toAccountID) OR (toAccountID=:accountID AND accountID=:toAccountID)");
$query->execute([':accountID' => $accountID, ':toAccountID' => $toAccountID]);
if($query->fetchColumn() == 0){
	//GJPCheck
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$query = $db->prepare("INSERT INTO friendreqs (accountID, toAccountID, comment, uploadDate)
		VALUES (:accountID, :toAccountID, :comment, :uploadDate)");
		$query->execute([':accountID' => $accountID, ':toAccountID' => $toAccountID, ':comment' => $comment, ':uploadDate' => $uploadDate]);
		echo 1;
	}else{
		echo -1;
	}
}else{
	echo -1;
}
?>