<?php
class generatePass
{
	public function isValidUsrname($userName, $pass) {
		include dirname(__FILE__)."/connection.php";
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$newtime = time() - (60*60);
		$query6 = $db->prepare("SELECT * FROM actions WHERE type = '6' AND timestamp > :time AND value2 = :ip");
		$query6->execute([':time' => $newtime, ':ip' => $ip]);
		if($query6->rowCount > 7){
			return 0;
		}else{
			$query = $db->prepare("SELECT accountID, salt, password, isAdmin FROM accounts WHERE userName = :userName");
			$query->execute([':userName' => $userName]);
			$result = $query->fetchAll();
			$result = $result[0];
			if($result["isAdmin"]==1){ //modIPs
				$query4 = $db->prepare("select * from modips where accountID = :id");
				$query4->execute([':id' => $result["accountID"]]);
				if ($query4->rowCount() > 0) {
					$query6 = $db->prepare("UPDATE modips SET IP=:hostname WHERE accountID=:id");
					$query6->execute([':hostname' => $ip, ':id' => $result["accountID"]]);
				}else{
					$query6 = $db->prepare("INSERT INTO modips (IP, accountID, isMod) VALUES (:hostname,:id,'1')");
					$query6->execute([':hostname' => $ip, ':id' => $result["accountID"]]);
				}
			}
			CRYPT_BLOWFISH or die ('-2');
			$Blowfish_Pre = '$2a$05$';
			$Blowfish_End = '$';
			$hashed_pass = crypt($pass, $Blowfish_Pre . $result['salt'] . $Blowfish_End);
			if ($hashed_pass == $result['password']) {
				return 1;
			} else {
				if($pass == $result['password']){
					$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
					$Chars_Len = 63;
					$Salt_Length = 21;
					$salt = "";
					for($i=0; $i < $Salt_Length; $i++)
					{
						$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
					}
					$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
					$pass = crypt($pass, $bcrypt_salt);
					//updating hash
					$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");
					$query->execute([':userName' => $userName, ':password' => $pass, ':salt' => $salt]);
					return 1;
				} else {
					return 0;
					$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
																('6',:username,:time,:ip)");
					$query6->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
				}
			}
		}
	}
	public function isValid($accid, $pass){
		include dirname(__FILE__)."/connection.php";
		$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :accid");
		$query->execute([':accid' => $accid]);
		$result = $query->fetchAll();
		$result = $result[0];
		$userName = $result["userName"];
		$generatePass = new generatePass();
		return $generatePass->isValidUsrname($userName, $pass);
	}
}
?>