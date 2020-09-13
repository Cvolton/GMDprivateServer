<?php
function pass($comment, $uploadDate, $accountID, $levelID) {
	include dirname(__FILE__)."/../../lib/connection.php";
	include "../../../config/commands.php";
    $pass = $ep->remove(str_replace($prefix."pass ", "", $comment));
	if(is_numeric($pass)){
		$pass = sprintf("%06d", $pass);
		if($pass == "000000"){
			$pass = "";
		}
		$pass = "1".$pass;
		$query = $db->prepare("UPDATE levels SET password=:password WHERE levelID=:levelID");
		$query->execute([':levelID' => $levelID, ':password' => $pass]);
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :id, :levelID)");
		$query->execute([':value' => $pass, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
		return true;
	}
}
?>