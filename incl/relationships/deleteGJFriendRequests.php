<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
if(empty($_POST["targetAccountID"])){
	exit("-1");
}
$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::remove($_POST["targetAccountID"]);
//REMOVING THE REQUEST
if(!empty($_POST["isSender"]) AND $_POST["isSender"] == 1){
		$query = $db->prepare("DELETE from friendreqs WHERE accountID=:accountID AND toAccountID=:targetAccountID LIMIT 1");
}else{
		$query = $db->prepare("DELETE from friendreqs WHERE toAccountID=:accountID AND accountID=:targetAccountID LIMIT 1");
}
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
echo "1";