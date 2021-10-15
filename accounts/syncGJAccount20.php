<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
include_once "../config/security.php";
include_once "../incl/lib/defuse-crypto.phar";
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
//here im getting all the data
$userName = ExploitPatch::remove($_POST["userName"]);
$password = $_POST["password"];
$secret = "";
$pass = GeneratePass::isValidUsrname($userName, $password);
if ($pass == 1) {
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
	if(!is_numeric($accountID) || !file_exists("../data/accounts/$accountID")){
		exit("-1");
	}else{
		$saveData = file_get_contents("../data/accounts/$accountID");
		if(file_exists("../data/accounts/keys/$accountID") && substr($saveData,0,3) != "H4s"){
			$protected_key_encoded = file_get_contents("../data/accounts/keys/$accountID");
			$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
			$user_key = $protected_key->unlockKey($password);
			try {
				$saveData = Crypto::decrypt($saveData, $user_key);
				file_put_contents("../data/accounts/$accountID",$saveData);
				file_put_contents("../data/accounts/keys/$accountID","");
			} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
				exit("-3");	
			}
		}
	}
	echo $saveData.";21;30;a;a";
}else{
	echo -2;
}
?>