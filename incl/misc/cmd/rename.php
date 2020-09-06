<?php
function renamelevel($comment, $uploadDate, $accountID, $levelID) {
	include dirname(__FILE__)."/../../lib/connection.php";
	include "../../../config/commands.php";
    $name = $ep->remove(str_replace($prefix."rename ", "", $comment));
	$query = $db->prepare("UPDATE levels SET levelName=:levelName WHERE levelID=:levelID");
	$query->execute([':levelID' => $levelID, ':levelName' => $name]);
	$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :id, :levelID)");
	$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
	return true;
}
?>