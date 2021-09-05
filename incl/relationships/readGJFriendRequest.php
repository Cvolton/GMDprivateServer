<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();

if(empty($_POST["requestID"])){
	exit("-1");
}

$accountID = GJPCheck::getAccountIDOrDie();
$requestID = $ep->remove($_POST["requestID"]);

$query=$db->prepare("UPDATE friendreqs SET isNew='0' WHERE ID = :requestID AND toAccountID = :targetAcc");
$query->execute([':requestID' => $requestID, ':targetAcc' => $accountID]);
echo "1";