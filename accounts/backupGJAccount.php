<?php
chdir(dirname(__FILE__));
set_time_limit(0);
ini_set("memory_limit","128M");
ini_set("post_max_size","50M");
ini_set("upload_max_filesize","50M");
include "../config/security.php";
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
include_once "../incl/lib/defuse-crypto.phar";
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$ep = new exploitPatch();
//here im getting all the data
$userName = $ep->remove($_POST["userName"]);
$password = $_POST["password"];
$saveData = $ep->remove($_POST["saveData"]);
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) {
	$protected_key_encoded = "";
	/*$saveDataArr = explode(";",$saveData); //splitting ccgamemanager and cclocallevels
	$saveData = str_replace("-","+",$saveDataArr[0]); //decoding
	$saveData = str_replace("_","/",$saveData);
	$saveData = base64_decode($saveData);
	$saveData = gzdecode($saveData);
	$protected_key_encoded = "";
	/if($cloudSaveEncryption == 0){
		$saveData = str_replace("<k>GJA_002</k><s>".$password."</s>", "<k>GJA_002</k><s>not the actual password</s>", $saveData); //replacing pass
		//file_put_contents($userName, $saveData);
		$saveData = gzencode($saveData); //encoding back
		$saveData = base64_encode($saveData);
		$saveData = str_replace("+","-",$saveData);
		$saveData = str_replace("/","_",$saveData);
		$saveData = $saveData . ";" . $saveDataArr[1]; //merging ccgamemanager and cclocallevels
	}else if($cloudSaveEncryption == 1){
		$saveData = $ep->remove($_POST["saveData"]);
		$protected_key = KeyProtectedByPassword::createRandomPasswordProtectedKey($password);
		$protected_key_encoded = $protected_key->saveToAsciiSafeString();
		$user_key = $protected_key->unlockKey($password);
		$saveData = Crypto::encrypt($saveData, $user_key);
	}*/
	//$query = $db->prepare("UPDATE `accounts` SET `saveData` = :saveData WHERE userName = :userName");
	//$query->execute([':saveData' => $saveData, ':userName' => $userName]);
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchAll()[0]["accountID"];
	if(!is_numeric($accountID)){
		exit("-1");
	}
	file_put_contents("../data/accounts/$accountID",$saveData);
	file_put_contents("../data/accounts/keys/$accountID",$protected_key_encoded);
	$query = $db->prepare("SELECT extID FROM users WHERE userName = :userName LIMIT 1");
	$query->execute([':userName' => $userName]);
	$result = $query->fetchAll();
	$result = $result[0];
	$extID = $result["extID"];
	echo "1";
}
else
{
	echo -1;
}
?>