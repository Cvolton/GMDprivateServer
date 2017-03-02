<?php
include "connection.php";
require "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$gjp = $ep->remove($_POST["gjp"]);
$requestID = $ep->remove($_POST["requestID"]);
$accountID = $ep->remove($_POST["accountID"]);
$targetAccountID = $ep->remove($_POST["targetAccountID"]);
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