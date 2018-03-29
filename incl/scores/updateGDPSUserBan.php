<?php
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$ep = new exploitPatch();
$GJPCheck = new GJPCheck();
if(!empty($_POST["userID"]) AND !empty($_POST["accountID"]) AND !empty($_POST["gjp"])){
	$userID = $ep->remove($_POST["userID"]);
	$accountID = $ep->remove($_POST["accountID"]);
	$gjp = $ep->remove($_POST["gjp"]);
	if($gjp != $GJPCheck->check($gjp,$id)){
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
		if($gs->checkPermission($accountID, "toolLeaderboardsban")){
			exit("1");
			/*if(!is_numeric($userID)){
				exit("Invalid userID");
			}
			$query = $db->prepare("UPDATE users SET isBanned = 1 WHERE userID = :id");
			$query->execute([':id' => $userID]);
			if($query->rowCount() != 0){
				echo "Banned succesfully.";
			}else{
				echo "Ban failed.";
			}
			$query = $db->prepare("INSERT INTO modactions  (type, value, value2, timestamp, account) 
													VALUES ('15',:userID, '1',  :timestamp,:account)");
			$query->execute([':userID' => $userID, ':timestamp' => time(), ':account' => $accountID]);*/
		}else{
			exit("-1");
		}
	}else{
		echo "-1";
	}
}else{
	echo '-1';
}
?>