<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES); //249 - maincra
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES); //250 - tomasek
// REMOVING FOR USER 1
$query = "DELETE FROM blocks WHERE person1 = :accountID AND person2 = :targetAccountID";
$query = $db->prepare($query);
//EXECUTING THE QUERIES
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
	echo "1";
}else{
	echo "-1";
}
?>