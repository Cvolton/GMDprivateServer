<?php
function magic($uploadDate, $accountID, $levelID) {
    include dirname(__FILE__)."/../../lib/connection.php";
    $query = $db->prepare("UPDATE levels SET starMagic='1' WHERE levelID=:levelID");
	$query->execute([':levelID' => $levelID]);
	$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('16', :value, :levelID, :timestamp, :id)");
	$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
	return true;
}
?>