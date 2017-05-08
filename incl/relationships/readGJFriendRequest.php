<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
if(empty($_POST["accountID"]) OR empty($_POST["gjp"]) OR empty($_POST["requestID"])){
	exit("-1");
}
$accountID = $ep->remove($_POST["accountID"]);
$gjp = $ep->remove($_POST["gjp"]);
$requestID = $ep->remove($_POST["requestID"]);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query=$db->prepare("UPDATE friendreqs SET isNew='0' WHERE ID = :requestID AND toAccountID = :targetAcc");
	$query->execute([':requestID' => $requestID, ':targetAcc' => $accountID]);
	echo "-1";
}else{
	echo "-1";
}
?>