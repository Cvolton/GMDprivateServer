<?php
class GJPCheck {
	public function check($gjp, $accountID) {
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
		$xor = new XORCipher();
		$gjpdecode = str_replace("_","/",$gjp);
		$gjpdecode = str_replace("-","+",$gjpdecode);
		$gjpdecode = base64_decode($gjpdecode);
		$gjpdecode = $xor->cipher($gjpdecode,37526);
		$generatePass = new generatePass();
		if($generatePass->isValid($accountID, $gjpdecode) == 1 AND $sessionGrants){
			$ip = $ml->getIP();
			$query = $db->prepare("INSERT INTO actions (type, value, value2, timestamp) VALUES (16, :accountID, :ip, :timestamp)");
			$query->execute([':accountID' => $accountID, ':ip' => $ip, ':timestamp' => time()]);
		}
		return $generatePass->isValid($accountID, $gjpdecode);
	}
}
?>
