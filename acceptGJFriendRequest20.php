<?php
include "connection.php";
require "incl/GJPCheck.php";
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$requestID = htmlspecialchars($_POST["requestID"],ENT_QUOTES);
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
// ACCEPTING FOR USER 1
$query = "SELECT * FROM accounts WHERE accountID = :accountID";
$query = $db->prepare($query);
$query->execute([':accountID' => $accountID]);
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friends = $accinfo["friends"];
if($friends!=""){
	$friends = $friends.",";
}
$friends = $friends . $targetAccountID;
$query = $db->prepare("UPDATE accounts SET friends=:friends WHERE accountID=:accountID");
$query->execute([':friends' => $friends, ':accountID' => $accountID]);
// ACCEPTING FOR USER 2
$query = "SELECT * FROM accounts WHERE accountID = ':targetAccountID'";
$query = $db->prepare($query);
$query->execute([':targetAccountID' => $targetAccountID]);
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friends = $accinfo["friends"];
if($friends!=""){
	$friends = $friends.",";
}
$friends = $friends . $accountID;
$query = $db->prepare("UPDATE accounts SET friends=:friends WHERE accountID=:targetAccountID");
$query->execute([':friends' => $friends, ':targetAccountID' => $targetAccountID]);
//REMOVING THE REQUEST
$query = $db->prepare("DELETE from friendreqs WHERE ID=:requestID LIMIT 1");
$query->execute([':requestID' => $requestID]);
//RESPONSE SO IT DOESNT SAY "FAILED"
echo "1";
}
else
{echo "-1";}
?>