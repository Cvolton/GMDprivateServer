<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
include_once "../config/security.php";
include_once "../incl/lib/defuse-crypto.phar";
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

$userName = ExploitPatch::remove($_GET["userName"]);
$password = $_GET["password"];
$pass = GeneratePass::isValidUsrname($userName, $password);
if ($pass == 1) {
	$query = $db->prepare("select accountID, saveData from accounts where userName = :userName");
	$query->execute([':userName' => $userName]);
	$account = $query->fetch();
	$accountID = $account["accountID"];
	if(!is_numeric($accountID)){
		exit("unknown account");
	}
	if(!file_exists("../data/accounts/$accountID")){
		exit("save data not found")
	}else{
		$saveData = file_get_contents("../data/accounts/$accountID");
		if(file_exists("../data/accounts/keys/$accountID")){
			if(substr($saveData,0,3) != "H4s"){
				$protected_key_encoded = file_get_contents("../data/accounts/keys/$accountID");
				$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
				$user_key = $protected_key->unlockKey($password);
				try {
					$saveData = Crypto::decrypt($saveData, $user_key);
				} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
					exit("-2");	
				}
			}
		}
	}
	echo $saveData.";21;30;a;a";
}else{
	echo "wrong pass";
}
?>