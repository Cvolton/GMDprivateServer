<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
if(empty($_POST["gjp"]) OR empty($_POST["accountID"]) OR empty($_POST["targetAccountID"])){
	exit("-1");
}
$gjp = $ep->remove($_POST["gjp"]);
$accountID = $ep->remove($_POST["accountID"]);
$targetAccountID = $ep->remove($_POST["targetAccountID"]);
//REMOVING THE REQUEST
if(!empty($_POST["isSender"]) AND $_POST["isSender"] == 1){
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