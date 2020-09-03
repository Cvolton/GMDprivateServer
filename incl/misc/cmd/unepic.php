<?php
function unepic($uploadDate, $accountID, $levelID) {
    include dirname(__FILE__)."/../../lib/connection.php";
    $query = $db->prepare("UPDATE levels SET starEpic='0' WHERE levelID=:levelID");
	$query->execute([':levelID' => $levelID]);
	$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
	$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
	return true;
}
?>