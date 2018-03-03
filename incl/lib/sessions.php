<?php
class accSession
{
	public function newSession($userName, $pswd)
	{
		require_once dirname(__FILE__)."/generatePass.php";
		include dirname(__FILE__)."/connection.php";
		$passCheck = new generatePass();
		if ($passCheck->isValidUsrname($userName, $pswd) != 1) { //if incorrect user/pass combination
			return 0;
		}
		
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $userName]);
		if ($query->rowCount() == 0) { //if user doesn't exists
			return 0;
		}
		$result = $query->fetch(); //table from SQL database
		
		$accID = $result["accountID"];
		$ip = $_SERVER["REMOTE_ADDR"];
		$sessionStart = time();
		$sessionEnd = $sessionStart - 172800; //session timeout (12h)
		
		$queryDupe = $db->prepare("SELECT accountID FROM accSessions WHERE accountID = :accID AND sessionStart > :timestamp");
		$queryDupe->execute([':accID' => $accID, ':timestamp' => $sessionEnd]);
		if ($queryDupe->rowCount() > 0) { //if already created a session
			$queryDelete = $db->prepare("DELETE FROM accSessions WHERE accountID = :accID");
			$queryDelete->execute([':accID' => $accID]);
		}
		
		
		$queryAdd = $db->prepare("INSERT INTO accSessions (accountID, ip, sessionStart) VALUES (:accID, :IP, :timestamp)");
		$queryAdd->execute([':accID' => $accID, ':IP' => $ip, ':timestamp' => $sessionStart]);
		return 1;
	}
	
	public function checkSession($accID)
	{
		include dirname(__FILE__)."/connection.php";
		
		$sessionEnd = time() - 172800;

		$query = $db->prepare("SELECT accountID FROM accSessions WHERE accountID = :accID AND ip = :IP AND sessionStart > :timestamp");
		$query->execute([':accID' => $accID, ':IP' => $_SERVER["REMOTE_ADDR"], ':timestamp' => $sessionEnd]);
		if ($query->rowCount() > 0) { //if session exists
			return 1;
		}
		return 0; //oh no, no valid session has been found :(
	}
	
	public function getTimeLeft($accID)
	{
		include dirname(__FILE__)."/connection.php";
		
		$sessionEnd = time() - 172800;

		$query = $db->prepare("SELECT sessionStart FROM accSessions WHERE accountID = :accID AND ip = :IP AND sessionStart > :timestamp");
		$query->execute([':accID' => $accID, ':IP' => $_SERVER["REMOTE_ADDR"], ':timestamp' => $sessionEnd]);
		if ($query->rowCount() > 0)
		{ //if session exists
			return 172800 - (time() - $query->fetch()["sessionStart"]);
		}
		return -1;
	}
}
?>
