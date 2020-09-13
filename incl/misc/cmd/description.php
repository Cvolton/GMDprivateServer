<?php
function description($comment, $uploadDate, $accountID, $levelID) {
	include dirname(__FILE__)."/../../lib/connection.php";
	include "../../../config/commands.php";
	$desc = base64_encode($ep->remove(str_replace($prefix."description ", "", $comment)));
	$query = $db->prepare("UPDATE levels SET levelDesc=:desc WHERE levelID=:levelID");
	$query->execute([':levelID' => $levelID, ':desc' => $desc]);
	$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('13', :value, :timestamp, :id, :levelID)");
	$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
	return true;
}
?>