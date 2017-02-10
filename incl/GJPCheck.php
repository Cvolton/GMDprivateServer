<?php
class GJPCheck {
	public function check($gjp, $accountID) {
		require_once "XORCipher.php";
		require_once "generatePass.php";
		include "connection.php";
		$xor = new XORCipher();
		$gjpdecode = str_replace("_","/",$gjp);
		$gjpdecode = str_replace("-","+",$gjpdecode);
		$gjpdecode = base64_decode($gjpdecode);
		$gjpdecode = $xor->cipher($gjpdecode,37526);
		$md5pass = md5($gjpdecode . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
		$generatePass = new generatePass();
		return $generatePass->isValid($accountID, $md5pass);
	}
}
?>