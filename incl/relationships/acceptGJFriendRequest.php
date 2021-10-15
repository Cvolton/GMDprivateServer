<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
if(empty($_POST["requestID"])){
	exit("-1");
}
$accountID = GJPCheck::getAccountIDOrDie();
$requestID = ExploitPatch::remove($_POST["requestID"]);

//TODO: what happens if request does not exist?
$query = $db->prepare("SELECT accountID, toAccountID FROM friendreqs WHERE ID = :requestID");
$query->execute([':requestID' => $requestID]);
$request = $query->fetch();
$reqAccountID = $request["accountID"];
$toAccountID = $request["toAccountID"];
if($toAccountID != $accountID OR $reqAccountID == $accountID){
	exit("-1");
}
$query = $db->prepare("INSERT INTO friendships (person1, person2, isNew1, isNew2)
VALUES (:accountID, :targetAccountID, 1, 1)");

$query->execute([':accountID' => $reqAccountID, ':targetAccountID' => $toAccountID]);
//REMOVING THE REQUEST
$query = $db->prepare("DELETE from friendreqs WHERE ID=:requestID LIMIT 1");
$query->execute([':requestID' => $requestID]);
//RESPONSE SO IT DOESNT SAY "FAILED"
echo "1";
?>