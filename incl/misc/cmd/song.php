<?php
function song($comment, $uploadDate, $accountID, $levelID) {
	include dirname(__FILE__)."/../../lib/connection.php";
	include "../../../config/commands.php";
	$song = $ep->remove(str_replace($prefix."song ", "", $comment));
	if(is_numeric($song)){
		$query = $db->prepare("UPDATE levels SET songID=:song WHERE levelID=:levelID");
		$query->execute([':levelID' => $levelID, ':song' => $song]);
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('17', :value, :timestamp, :id, :levelID)");
		$query->execute([':value' => $song, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
		return true;
	}
}
?>