<?php

function generateRandomString($length = 32)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class Auth
{
	public static function make_auth($userName, $pswd)
	{
		require_once dirname(__FILE__)."/generatePass.php";
		include dirname(__FILE__)."/connection.php";
		
		//validating username and password
		$gp = new generatePass();
		if ($gp->isValidUsrname($userName, $pswd) != 1)
		{
			return 1;
		}
		
		//getting accountid + checking if user exists
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :username");
		$query->execute([':username' => $userName]);
		if ($query->rowCount() == 0)
		{
			return 2;
		}
		$accountid = $query->fetch()["accountID"];

		//generating authkey
		$authkey = hash('sha256', generateRandomString());
		
		//user logged in to too many devices
		$queryLimit = $db->prepare("SELECT count(*) FROM auth WHERE accountid = :accountid");
		$queryLimit->execute([':accountid' => $accountid]);
		if ($queryLimit->fetchColumn() > 16)
		{
			return 3;
		}
		
		//checking if authkey is a dupe
		$queryDupe = $db->prepare("SELECT count(*) FROM auth WHERE authkey LIKE :authkey");
		$queryDupe->execute([':authkey' => $authkey]);
		if ($queryDupe->fetchColumn() > 0)
		{
			return 4;
		}
		
		//inserting auth
		$queryAdd = $db->prepare("INSERT INTO auth (accountid, authkey, created, ip) VALUES (:accountid, :authkey, :time, :ip)");
		$queryAdd->execute([':accountid' => $accountid, ':authkey' => $authkey, ':time' => time(), ':ip' => $_SERVER['REMOTE_ADDR']]);
		
		return $authkey;
	}
	
	public static function is_auth_valid($key)
	{
		include dirname(__FILE__)."/connection.php";
		
		$query = $db->prepare("SELECT count(*) FROM auth WHERE authkey = :authkey");
		$query->execute([':authkey' => $key]);
		return $query->fetchColumn() > 0;
	}
	
	public static function revoke_auth($key)
	{
		include dirname(__FILE__)."/connection.php";
		
		if (!Auth::is_auth_valid($key))
		{
			return 0;
		}
		
		$query = $db->prepare("DELETE FROM auth WHERE authkey = :authkey");
		$query->execute([':authkey' => $key]);
		return 1;
	}
	
	public static function revoke_all_auth($key)
	{
		include dirname(__FILE__)."/connection.php";

		$query = $db->prepare("SELECT accountid FROM auth WHERE authkey = :authkey");
		$query->execute([':authkey' => $key]);
		if ($query->rowCount() == 0)
		{
			return 0;
		}
		
		$accountid = $query->fetch()["accountid"];
		
		$queryRemove = $db->prepare("DELETE FROM auth WHERE accountid = :accountid");
		$queryRemove->execute([':accountid' => $accountid]);
		return 1;
	}
	
	public static function revoke_all_auth_up($userName, $pswd)
	{
		require_once dirname(__FILE__)."/generatePass.php";
		include dirname(__FILE__)."/connection.php";
		
		//validating username and password
		$gp = new generatePass();
		if ($gp->isValidUsrname($userName, $pswd) != 1)
		{
			return 0;
		}
		
		//getting accountid + checking if user exists
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :username");
		$query->execute([':username' => $userName]);
		if ($query->rowCount() == 0)
		{
			return 0;
		}
		$accountid = $query->fetch()["accountID"];
		
		$queryRemove = $db->prepare("DELETE FROM auth WHERE accountid = :accountid");
		$queryRemove->execute([':accountid' => $accountid]);
		return 1;
	}
	
	public static function make_session($key)
	{
		require_once dirname(__FILE__)."/sessions.php";
		include dirname(__FILE__)."/connection.php";

		$query = $db->prepare("SELECT accountid FROM auth WHERE authkey = :authkey");
		$query->execute([':authkey' => $key]);
		if ($query->rowCount() == 0)
		{
			return 0;
		}
		
		$accountid = $query->fetch()["accountid"];
		
		$session = new accSession();
		return $session->newSessionId($accountid);
	}
}

?>