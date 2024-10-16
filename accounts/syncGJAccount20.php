<?php
chdir(dirname(__FILE__));
require "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
require_once "../config/security.php";
require_once "../incl/lib/defuse-crypto.phar";
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$password = !empty($_POST["password"]) ? $_POST["password"] : "";
$userName = ExploitPatch::charclean($_POST["userName"]) ?? '';

if(empty($_POST["accountID"])) {
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
} else {
	$accountID = ExploitPatch::number($_POST["accountID"]);
}

$pass = 0;
if(!empty($_POST["password"])) $pass = GeneratePass::isValid($accountID, $_POST["password"]);
elseif(!empty($_POST["gjp2"])) $pass = GeneratePass::isGJP2Valid($accountID, $_POST["gjp2"]);
if($pass == 1) {
	if(!is_numeric($accountID) || !file_exists("../data/accounts/$accountID")) {
		exit("-1");
	} else {
		$saveData = file_get_contents("../data/accounts/$accountID");
		if(file_exists("../data/accounts/keys/$accountID") && substr($saveData,0,3) != "H4s") {
			$protected_key_encoded = file_get_contents("../data/accounts/keys/$accountID");
			$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
			$user_key = $protected_key->unlockKey($password);
			try {
				$saveData = Crypto::decrypt($saveData, $user_key);
				file_put_contents("../data/accounts/$accountID",$saveData);
				file_put_contents("../data/accounts/keys/$accountID","");
			} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
				$gs->logAction($accountID, 11, $userName, 2);
				exit("-3");	
			}
		}
	}
	$gs->logAction($accountID, 10, $userName, strlen($saveData));
	echo $saveData.";21;30;a;a";
} else {
	$gs->logAction($accountID, 11, $userName, 1);
	echo -2;
}
?>