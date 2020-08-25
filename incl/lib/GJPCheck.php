<?php
class GJPCheck {
	public function check($gjp, $accountID) {
		include dirname(__FILE__)."/connection.php";
		include dirname(__FILE__)."/../../config/security.php";
		if($sessionGrants){
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			if ($_SESSION["ip"] == $ip) {
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
			$query = $db->prepare("INSERT INTO actions (type, value, timestamp) VALUES (10, :accountID, :timestamp)");
			$query->execute([':accountID' => $accountID, ':timestamp' => time()]);
		}
		return $generatePass->isValid($accountID, $gjpdecode);
	}
}
?>
