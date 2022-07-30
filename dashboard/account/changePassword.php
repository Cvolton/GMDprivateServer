<?php
session_start();
include "../../incl/lib/connection.php";
include_once "../../config/security.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
include_once "../../incl/lib/defuse-crypto.phar";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$ep = new exploitPatch();
error_reporting(E_ERROR | E_PARSE);
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if($_POST["oldpassword"] != "" AND $_POST["newpassword"] != "" AND $_POST["newpassword"] == $_POST["newpassconfirm"]) {
	$userName = $gs->getAccountName($_SESSION["accountID"]);
	$oldpass = $_POST["oldpassword"];
	$newpass = $_POST["newpassword"];
	if($oldpass == $newpass){
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("samePass").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>');
		die();
	}
	$pass = GeneratePass::isValidUsrname($userName, $oldpass);
	$salt = "";
if ($pass == 1) {
	$passhash = password_hash($newpass, PASSWORD_DEFAULT);
	$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");	
	$query->execute([':password' => $passhash, ':userName' => $userName, ':salt' => $salt]);
	$_SESSION["accountID"] = 0;
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("changePassTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("changedPass").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>');
	//decrypting save
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
	$saveData = file_get_contents("../../data/accounts/$accountID");
	if(file_exists("../../data/accounts/keys/$accountID")){
		$protected_key_encoded = file_get_contents("../../data/accounts/keys/$accountID");
		if($protected_key_encoded != ""){
			$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
			$user_key = $protected_key->unlockKey($oldpass);
			try {
				$saveData = Crypto::decrypt($saveData, $user_key);
			} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
				exit("Unable to update save data encryption");	
			}
			file_put_contents("../../data/accounts/$accountID",$saveData);
			file_put_contents("../../data/accounts/keys/$accountID","");
		}
	}
}else{
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("wrongPass").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>');
} 

} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("changePassTitle").'</h1>
    <form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("changePassDesc").'</p>
        <div class="field"><input type="password" name="oldpassword" placeholder="'.$dl->getLocalizedString("oldPassword").'"></div>
        <div class="field"><input type="password" name="newpassword" placeholder="'.$dl->getLocalizedString("newPassword").'"></div>
		<div class="field"><input type="password" name="newpassconfirm" placeholder="'.$dl->getLocalizedString("confirmNew").'"></div>
        <button type="submit" class="btn-song">'.$dl->getLocalizedString("changePassword").'</button>
    </form>
</div>');
}} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="../dashboard/login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>');
}
?>
