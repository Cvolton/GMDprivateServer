<?php
class generatePass
{
	public function isValidUsrname($userName, $pass) {
		include dirname(__FILE__)."/connection.php";
		require_once dirname(__FILE__)."/mainLib.php";
		$gs = new mainLib();
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$newtime = time() - (60*60);
		$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type = '6' AND timestamp > :time AND value2 = :ip");
		$query6->execute([':time' => $newtime, ':ip' => $ip]);
		if($query6->fetchColumn() > 7){
			return -1;
		}else{
			$query = $db->prepare("SELECT accountID, salt, password, isAdmin FROM accounts WHERE userName LIKE :userName");
			$query->execute([':userName' => $userName]);
			if($query->rowCount() == 0){
				return 0;
			}
			$result = $query->fetch();
			if(password_verify($pass, $result["password"])){
				$modipCategory = $gs->getMaxValuePermission($result["accountID"], "modipCategory");
				if($modipCategory > 0){ //modIPs
					$query4 = $db->prepare("SELECT count(*) FROM modips WHERE accountID = :id");
					$query4->execute([':id' => $result["accountID"]]);
					if ($query4->fetchColumn() > 0) {
						$query6 = $db->prepare("UPDATE modips SET IP=:hostname, modipCategory=:modipCategory WHERE accountID=:id");
					}else{
						$query6 = $db->prepare("INSERT INTO modips (IP, accountID, isMod, modipCategory) VALUES (:hostname,:id,'1',:modipCategory)");
					}
					$query6->execute([':hostname' => $ip, ':id' => $result["accountID"], ':modipCategory' => $modipCategory]);
				}
				return 1;
			}else{
				$md5pass = md5($pass . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
				CRYPT_BLOWFISH or die ('-2');
				$Blowfish_Pre = '$2a$05$';
				$Blowfish_End = '$';
				$hashed_pass = crypt($md5pass, $Blowfish_Pre . $result['salt'] . $Blowfish_End);
				if ($hashed_pass == $result['password']) {
					$pass = password_hash($pass, PASSWORD_DEFAULT);
					//updating hash
					$query = $db->prepare("UPDATE accounts SET password=:password WHERE userName=:userName");
					$query->execute([':userName' => $userName, ':password' => $pass]);
					return 1;
				} else {
					if($md5pass == $result['password']){
						$pass = password_hash($pass, PASSWORD_DEFAULT);
						//updating hash
						$query = $db->prepare("UPDATE accounts SET password=:password WHERE userName=:userName");
						$query->execute([':userName' => $userName, ':password' => $pass]);
						return 1;
					} else {
						$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
																	('6',:username,:time,:ip)");
						$query6->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
						return 0;
					}
				}
			}
		}
	}
	public function isValid($accid, $pass){
		include dirname(__FILE__)."/connection.php";
		$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :accid");
		$query->execute([':accid' => $accid]);
		if($query->rowCount() == 0){
			return 0;
		}
		$result = $query->fetch();
		$userName = $result["userName"];
		$generatePass = new generatePass();
		return $generatePass->isValidUsrname($userName, $pass);
	}
}
?>