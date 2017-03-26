<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$accountID = $ep->remove($_POST["accountID"]); //249 - maincra
$gjp = $ep->remove($_POST["gjp"]);
$targetAccountID = $ep->remove($_POST["targetAccountID"]); //250 - tomasek
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