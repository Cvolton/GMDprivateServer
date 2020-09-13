<?php
function daily($uploadDate, $accountID, $levelID) {
    include dirname(__FILE__)."/../../lib/connection.php";
    $query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE levelID = :level AND type = 0");
	$query->execute([':level' => $levelID]);
	if($query->fetchColumn() != 0){
		return false;
	}
	$query = $db->prepare("SELECT timestamp FROM dailyfeatures WHERE timestamp >= :tomorrow AND type = 0 ORDER BY timestamp DESC LIMIT 1");
	$query->execute([':tomorrow' => strtotime("tomorrow 00:00:00")]);
	if($query->rowCount() == 0){
		$timestamp = strtotime("tomorrow 00:00:00");
	}else{
		$timestamp = $query->fetchColumn() + 86400;
	}
	$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type) VALUES (:levelID, :uploadDate, 0)");
	$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
    $query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account, value2, value4) VALUES ('5', :value, :levelID, :timestamp, :id, :dailytime, 0)");
	$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID, ':dailytime' => $timestamp]);
	return true;
}
?>