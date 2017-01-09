<?php
include "connection.php";
require "incl/GJPCheck.php";
$gjp = explode("(", explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$requestID = explode("(", explode(";", htmlspecialchars($_POST["requestID"],ENT_QUOTES))[0])[0];
$accountID = explode("(", explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
$targetAccountID = explode("(", explode(";", htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES))[0])[0];
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
// ACCEPTING FOR USER 1
$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
$query = $db->prepare($query);
$query->execute();
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friends = $accinfo["friends"];
if($friends!=""){
	$friends = $friends.",";
}
$friends = $friends . $targetAccountID;
$query = $db->prepare("UPDATE accounts SET friends='$friends' WHERE accountID='$accountID'");
$query->execute();
// ACCEPTING FOR USER 2
$query = "SELECT * FROM accounts WHERE accountID = '$targetAccountID'";
$query = $db->prepare($query);
$query->execute();
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friends = $accinfo["friends"];
if($friends!=""){
	$friends = $friends.",";
}
$friends = $friends . $accountID;
$query = $db->prepare("UPDATE accounts SET friends='$friends' WHERE accountID='$targetAccountID'");
$query->execute();
//REMOVING THE REQUEST
$query = $db->prepare("DELETE from friendreqs WHERE ID='$requestID' LIMIT 1");
$query->execute();
//RESPONSE SO IT DOESNT SAY "FAILED"
echo "1";
}
else
{echo "-1";}
?>