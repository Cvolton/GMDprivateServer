<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
// REMOVING FOR USER 1
$query = "DELETE FROM friendships WHERE person1 = :accountID AND person2 = :targetAccountID";
$query = $db->prepare($query);
$query2 = "DELETE FROM friendships WHERE person2 = :accountID AND person1 = :targetAccountID";
$query2 = $db->prepare($query2);
//EXECUTING THE QUERIES
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
	$query2->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
	echo "1";
}else{
	echo "-1";
}
?>