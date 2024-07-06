<?php
require_once dirname(__FILE__)."/mainLib.php";

class GeneratePass
{
	public static function GJP2fromPassword($pass) {
		return sha1($pass . "mI29fmAnxgTs");
	}

	public static function GJP2hash($pass) {
		return password_hash(self::GJP2fromPassword($pass), PASSWORD_DEFAULT);
	}

	public static function assignGJP2($accid, $pass) {
		include dirname(__FILE__)."/connection.php";

		$query = $db->prepare("UPDATE accounts SET gjp2 = :gjp2 WHERE accountID = :id");
		$query->execute(["gjp2" => self::GJP2hash($pass), ":id" => $accid]);
	}

	public static function attemptsFromIP() {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();
		$ip = $gs->getIP();
		$newtime = time() - (60*60);
		$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type = '6' AND timestamp > :time AND value2 = :ip");
		$query6->execute([':time' => $newtime, ':ip' => $ip]);
		return $query6->fetchColumn();
	}

	public static function tooManyAttemptsFromIP() {
		return self::attemptsFromIP() > 20;
	}

	public static function logInvalidAttemptFromIP($accid) {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();
		$ip = $gs->getIP();
		$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
													('6',:accid,:time,:ip)");
		$query6->execute([':accid' => $accid, ':time' => time(), ':ip' => $ip]);
	}

	public static function assignModIPs($accountID, $ip) {
		//this system is most likely going to be removed altogether soon
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();
		$modipCategory = $gs->getMaxValuePermission($accountID, "modipCategory");
		if($modipCategory > 0){ //modIPs
			$query4 = $db->prepare("SELECT count(*) FROM modips WHERE accountID = :id");
			$query4->execute([':id' => $accountID]);
			if ($query4->fetchColumn() > 0) {
				$query6 = $db->prepare("UPDATE modips SET IP=:hostname, modipCategory=:modipCategory WHERE accountID=:id");
			}else{
				$query6 = $db->prepare("INSERT INTO modips (IP, accountID, isMod, modipCategory) VALUES (:hostname,:id,'1',:modipCategory)");
			}
			$query6->execute([':hostname' => $ip, ':id' => $accountID, ':modipCategory' => $modipCategory]);
		}
	}

	public static function isGJP2Valid($accid, $gjp2) {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();

		if(self::tooManyAttemptsFromIP()) return -1;

		$userInfo = $db->prepare("SELECT userName, gjp2, isActive FROM accounts WHERE accountID = :accid");
		$userInfo->execute([':accid' => $accid]);
		if($userInfo->rowCount() == 0) return 0;

		$userInfo = $userInfo->fetch();
		if(!($userInfo['gjp2'])) return -2;

		if(password_verify($gjp2, $userInfo['gjp2'])) {
			self::assignModIPs($accid, $gs->getIP());
			$checkBan = $gs->getPersonBan($accid, $gs->getUserID($accid, $userInfo['userName']), 4);
			if($checkBan) return -1;
			return $userInfo['isActive'] ? 1 : -2;
		} else {
			self::logInvalidAttemptFromIP($accid);
			return 0;
		}
		
	}

	public static function isGJP2ValidUsrname($userName, $gjp2) {
		include dirname(__FILE__)."/connection.php";
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $userName]);
		if($query->rowCount() == 0){
			return 0;
		}
		$result = $query->fetch();
		$accID = $result["accountID"];
		return self::isGJP2Valid($accID, $gjp2);
		
	}

	public static function isValid($accid, $pass) {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();

		if(self::tooManyAttemptsFromIP()) return -1;

		$query = $db->prepare("SELECT userName, accountID, salt, password, isActive, gjp2 FROM accounts WHERE accountID = :accid");
		$query->execute([':accid' => $accid]);
		if($query->rowCount() == 0) return 0;
		
		$result = $query->fetch();
		if(password_verify($pass, $result["password"])){
			if(!$result["gjp2"]) self::assignGJP2($accid, $pass);
			$checkBan = $gs->getPersonBan($accid, $gs->getUserID($accid, $result['userName']), 4);
			if($checkBan) return -1;
			self::assignModIPs($accid, $gs->getIP());
			return $result['isActive'] ? 1 : -2;
		} else {
			// Code to validate password hashes created prior to March 2017 has been removed.
			self::logInvalidAttemptFromIP($accid);
			return 0;
		}
	}

	public static function isValidUsrname($userName, $pass){
		include dirname(__FILE__)."/connection.php";
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $userName]);
		if($query->rowCount() == 0){
			return 0;
		}
		$result = $query->fetch();
		$accID = $result["accountID"];
		return self::isValid($accID, $pass);
	}

	public static function isValidToken($auth) {
		include dirname(__FILE__)."/connection.php";
		$gs = new mainLib();
		if(self::tooManyAttemptsFromIP() || empty(trim($auth))) return '-3';
		$query = $db->prepare("SELECT userName, accountID, isActive FROM accounts WHERE auth = :id");
		$query->execute([':id' => $auth]);
		$fetch = $query->fetch();
		if(!$fetch) {
			self::logInvalidAttemptFromIP(0);
			return '-4';
		} else {
			if(!$fetch['isActive']) return '-2';
			return ['accountID' => $fetch['accountID'], 'userID' => $gs->getUserID($fetch['accountID'], $fetch['userName']), 'userName' => $fetch['userName'], 'color' => $gs->getAccountCommentColor($fetch["accountID"])];
		}
	}
}
?>