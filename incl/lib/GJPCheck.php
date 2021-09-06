<?php
class GJPCheck {
	public static function check($gjp, $accountID) {
		include dirname(__FILE__)."/connection.php";
		include dirname(__FILE__)."/../../config/security.php";
		include_once dirname(__FILE__)."/mainLib.php";
		$ml = new mainLib();
		if($sessionGrants){
			$ip = $ml->getIP();
			$query = $db->prepare("SELECT count(*) FROM actions WHERE type = 16 AND value = :accountID AND value2 = :ip AND timestamp > :timestamp");
			$query->execute([':accountID' => $accountID, ':ip' => $ip, ':timestamp' => time() - 3600]);
			if($query->fetchColumn() > 0){
				return 1;
			}
		}
		require_once dirname(__FILE__)."/XORCipher.php";
		require_once dirname(__FILE__)."/generatePass.php";
		$gjpdecode = str_replace("_","/",$gjp);
		$gjpdecode = str_replace("-","+",$gjpdecode);
		$gjpdecode = base64_decode($gjpdecode);
		$gjpdecode = XORCipher::cipher($gjpdecode,37526);
		$validationResult = GeneratePass::isValid($accountID, $gjpdecode);
		if($validationResult == 1 AND $sessionGrants){
			$ip = $ml->getIP();
			$query = $db->prepare("INSERT INTO actions (type, value, value2, timestamp) VALUES (16, :accountID, :ip, :timestamp)");
			$query->execute([':accountID' => $accountID, ':ip' => $ip, ':timestamp' => time()]);
		}
		return $validationResult;
	}

	public static function validateGJPOrDie($gjp, $accountID){
		if(self::check($gjp, $accountID) != 1)
			exit("-1");
	}

	/*
		Gets accountID and from the POST parameters and validates if the provided GJP matches
	*/
	public static function getAccountIDOrDie(){
		require_once "../lib/exploitPatch.php";
		
		if(empty($_POST['accountID']) || empty($_POST['gjp']))
			exit("-1");

		$accountID = ExploitPatch::remove($_POST["accountID"]);
		$gjp = ExploitPatch::remove($_POST["gjp"]);

		self::validateGJPOrDie($gjp, $accountID);

		return $accountID;
	}
}
?>
