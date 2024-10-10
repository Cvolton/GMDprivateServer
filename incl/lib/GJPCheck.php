<?php
require_once dirname(__FILE__)."/XORCipher.php";
require_once dirname(__FILE__)."/generatePass.php";
require_once dirname(__FILE__)."/mainLib.php";

class GJPCheck {
	public static function check($gjp, $accountID) {
		include dirname(__FILE__)."/connection.php";
		include dirname(__FILE__)."/exploitPatch.php";
		include dirname(__FILE__)."/../../config/security.php";
		$gjpdecode = XORCipher::cipher(ExploitPatch::url_base64_decode($gjp), 37526);
		$validationResult = GeneratePass::isValid($accountID, $gjpdecode);
		return $validationResult;
	}

	public static function validateGJPOrDie($gjp, $accountID, $dontDie = false) {
		if(self::check($gjp, $accountID) != 1) {
			if($dontDie) return false;
			else exit('-1');
		}
	}

	public static function validateGJP2OrDie($gjp2, $accountID,$dontDie = false) {
		if(GeneratePass::isGJP2Valid($accountID, $gjp2) != 1) {
			if($dontDie) return false;
			else exit('-1');
		}
	}

	/**
	 * Gets accountID and from the POST parameters and validates if the provided GJP/token matches
	 *
	 * @return     The account id
	 */
	public static function getAccountIDOrDie($dontDie = false) {
		require_once __DIR__."/exploitPatch.php";
		
		if(empty($_POST['accountID']) && empty($_POST['auth'])) {
			if($dontDie) return false;
			else exit('-1');
		}

		$accountID = ExploitPatch::remove($_POST["accountID"]);

		if(!empty($_POST['gjp'])) self::validateGJPOrDie($_POST['gjp'], $accountID, $dontDie);
		elseif(!empty($_POST['gjp2'])) self::validateGJP2OrDie($_POST['gjp2'], $accountID, $dontDie);
		elseif(!empty($_POST['auth'])) {
			$tokenAuth = GeneratePass::isValidToken($_POST['auth']);
			if(!is_array($tokenAuth)) {
				if($dontDie) return false;
				else exit('-1');
			}
			$accountID = $tokenAuth['accountID'];
		}
		else {
			if($dontDie) return false;
			else exit('-1');
		}

		return $accountID;
	}
}
?>
