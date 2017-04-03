<?php
include "../../incl/lib/connection.php";
include_once "../../config/security.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
include_once "../../incl/lib/defuse-crypto.phar";
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$ep = new exploitPatch();
$userName = $ep->remove($_POST["userName"]);
$oldpass = $_POST["oldpassword"];
$newpass = $_POST["newpassword"];
$oldpassword = md5($oldpass . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$newpassword = md5($newpass . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
if($userName != "" AND $newpass != "" AND $oldpass != ""){
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $oldpassword);
if ($pass == 1) {
	if($cloudSaveEncryption == 1){
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchAll()[0]["accountID"];
		$saveData = file_get_contents("../../data/accounts/$accountID");
		if(file_exists("../../data/accounts/keys/$accountID")){
			$protected_key_encoded = file_get_contents("../../data/accounts/keys/$accountID");
			$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
			$user_key = $protected_key->unlockKey($oldpass);
			try {
				$saveData = Crypto::decrypt($saveData, $user_key);
			} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
				exit("-2");	
			}
			$protected_key = KeyProtectedByPassword::createRandomPasswordProtectedKey($newpass);
			$protected_key_encoded = $protected_key->saveToAsciiSafeString();
			$user_key = $protected_key->unlockKey($newpass);
			$saveData = Crypto::encrypt($saveData, $user_key);
			file_put_contents("../../data/accounts/$accountID",$saveData);
			file_put_contents("../../data/accounts/keys/$accountID",$protected_key_encoded);
		}
	}
	//creating pass hash
	CRYPT_BLOWFISH or die ('-2');
	//This string tells crypt to use blowfish for 5 rounds.
	$Blowfish_Pre = '$2a$05$';
	$Blowfish_End = '$';
	// Blowfish accepts these characters for salts.
	$Allowed_Chars =
	'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
	$Chars_Len = 63;
	$Salt_Length = 21;
	$salt = "";
	for($i=0; $i < $Salt_Length; $i++)
	{
		$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
	}
	$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
	$password = crypt($newpassword, $bcrypt_salt);
	$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");	
	$query->execute([':password' => $password, ':userName' => $userName, ':salt' => $salt]);
	echo "Password changed. <a href='accountManagement.php'>Go back to account management</a>";
}else{
	echo "Invalid old password or nonexistent account. <a href='changePassword.php'>Try again</a>";

}
}else{
	echo '<form action="changePassword.php" method="post">Username: <input type="text" name="userName"><br>Old password: <input type="password" name="oldpassword"><br>New password: <input type="password" name="newpassword"><br><input type="submit" value="Change"></form>';
}
?>