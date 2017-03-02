<?php
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$gjp = $ep->remove($_POST["gjp"]);
$isSender = $ep->remove($_POST["isSender"]);
$accountID = $ep->remove($_POST["accountID"]);
$targetAccountID = $ep->remove($_POST["targetAccountID"]);
//REMOVING THE REQUEST
if($isSender == 1){
		$query = $db->prepare("DELETE from friendreqs WHERE accountID=:accountID AND toAccountID=:targetAccountID LIMIT 1");
}else{
		$query = $db->prepare("DELETE from friendreqs WHERE toAccountID=:accountID AND accountID=:targetAccountID LIMIT 1");
}
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
	//RESPONSE SO IT DOESNT SAY "FAILED"
	echo "1";
}else{
	//OR YOU KNOW WHAT LETS MAKE IT SAY "FAILED"
	echo "-1";
}
?>