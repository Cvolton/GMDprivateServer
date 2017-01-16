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
// ACCEPTING FOR USER 2
$query = $db->prepare("INSERT INTO friendships (person1, person2, isNew1, isNew2)
VALUES (:accountID, :targetAccountID, 1, 1)");

$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
//REMOVING THE REQUEST
$query = $db->prepare("DELETE from friendreqs WHERE ID=:requestID LIMIT 1");
$query->execute([':requestID' => $requestID]);
//RESPONSE SO IT DOESNT SAY "FAILED"
echo "1";
}
else
{echo "-1";}
?>