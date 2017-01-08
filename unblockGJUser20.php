<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$accountID = explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0]; //249 - maincra
$gjp = explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0];
$targetAccountID = explode(";", htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES))[0]; //250 - tomasek
// REMOVING FOR USER 1
$query = "SELECT * FROM accounts WHERE accountID = '$accountID'"; //selecting maincra
$query = $db->prepare($query);
$query->execute();
$result = $query->fetchAll();
$accinfo = $result[0];
$blockeds = $accinfo["blocked"]; //getting who was blocked by maincra
$blockedsarray = explode(',',$blockeds);
if(($key = array_search($targetAccountID, $blockedsarray)) !== false) {
    unset($blockedsarray[$key]); //removing the guy who was blocked by maincra
}
$newblockeds = implode(",",$blockedsarray);
$query3 = $db->prepare("UPDATE accounts SET blocked='$newblockeds' WHERE accountID='$accountID'"); //mysql query
// REMOVING FOR USER 2
$query = "SELECT * FROM accounts WHERE accountID = '$targetAccountID'"; //selecting tomasek
$query = $db->prepare($query);
$query->execute();
$result = $query->fetchAll();
$accinfo = $result[0];
$blockedlist = $accinfo["blockedBy"]; //getting who blocked tomasek
$blockedsarray = explode(',',$blockedlist);
if(($key = array_search($accountID, $blockedsarray)) !== false) {
    unset($blockedsarray[$key]); //removing the guy who blocked tomasek from the array
}
$newblockeds = implode(",",$blockedsarray); 
$query2 = $db->prepare("UPDATE accounts SET blockedBy='$newblockeds' WHERE accountID='$targetAccountID'"); //mysql query
//EXECUTING THE QUERIES
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query3->execute();
	$query2->execute();
	echo "1";
}else{
	echo "-1";
}
?>