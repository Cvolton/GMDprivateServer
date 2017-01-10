<?php
class GJPCheck {
	public function check($gjp, $accountID) {
		require_once "XORCipher.php";
		include "connection.php";
		$xor = new XORCipher();
		$gjpdecode = $xor->cipher(base64_decode($gjp),37526);
		$md5pass = md5($gjpdecode . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
		$query = $db->prepare("select * from accounts where accountID = :accountID AND password = :md5pass");
		$query->execute([':accountID' => $accountID, ':md5pass' => $md5pass]);
		$accounts = $query->rowCount();
		return $accounts;
	}
}
?>