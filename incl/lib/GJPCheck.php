<?php
class GJPCheck {
	public function check($gjp, $accountID) {
		require_once dirname(__FILE__)."/XORCipher.php";
		require_once dirname(__FILE__)."/generatePass.php";
		include dirname(__FILE__)."/connection.php";;
		$xor = new XORCipher();
		$gjpdecode = str_replace("_","/",$gjp);
		$gjpdecode = str_replace("-","+",$gjpdecode);
		$gjpdecode = base64_decode($gjpdecode);
		$gjpdecode = $xor->cipher($gjpdecode,37526);
		$generatePass = new generatePass();
		return $generatePass->isValid($accountID, $gjpdecode);
	}
}
?>