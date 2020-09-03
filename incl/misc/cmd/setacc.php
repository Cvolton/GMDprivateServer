<?php
function setacc($commentarray, $uploadDate, $accountID, $levelID) {
    include dirname(__FILE__)."/../../lib/connection.php";
    $query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName OR accountID = :userName LIMIT 1");
	$query->execute([':userName' => $commentarray[1]]);
	if($query->rowCount() == 0){
		return false;
	}
	$targetAcc = $query->fetchColumn();
	//var_dump($result);
	$query = $db->prepare("SELECT userID FROM users WHERE extID = :extID LIMIT 1");
	$query->execute([':extID' => $targetAcc]);
	$userID = $query->fetchColumn();
	$query = $db->prepare("UPDATE levels SET extID=:extID, userID=:userID, userName=:userName WHERE levelID=:levelID");
	$query->execute([':extID' => $targetAcc, ':userID' => $userID, ':userName' => $commentarray[1], ':levelID' => $levelID]);
	$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('7', :value, :levelID, :timestamp, :id)");
	$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
	return true;
}
?>