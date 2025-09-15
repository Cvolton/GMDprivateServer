<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."config/security.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/defuse-crypto.phar";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$dl->title($dl->getLocalizedString("changePassTitle"));
$dl->printFooter('../');
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if($_POST["oldpassword"] != "" AND $_POST["newpassword"] != "" AND $_POST["newpassword"] == $_POST["newpassconfirm"]) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'account/changePassword.php\', true, true, \'GET\')"  class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'account');
		die();
	}
	$getAccountData = $db->prepare("SELECT * FROM accounts WHERE accountID = :accountID");
	$getAccountData->execute([':accountID' => $_SESSION["accountID"]]);
	$getAccountData = $getAccountData->fetch();
	$userName = $gs->getAccountName($_SESSION["accountID"]);
	$oldpass = ExploitPatch::remove($_POST["oldpassword"]);
	$newpass = ExploitPatch::remove($_POST["newpassword"]);
	if($oldpass == $newpass){
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("samePass").'</p>
        <button type="button" onclick="a(\'account/changePassword.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>', 'account');
		die();
	}
	$pass = GeneratePass::isValidUsrname($userName, $oldpass);
	$salt = "";
if($pass == 1) {
	$passhash = password_hash($newpass, PASSWORD_DEFAULT);
	$gjp2 = GeneratePass::GJP2hash($newpass);
	$auth = $gs->randomString(8);
	$query = $db->prepare("UPDATE accounts SET password=:password, gjp2 = :gjp, salt=:salt, auth=:auth WHERE userName=:userName");	
	$query->execute([':password' => $passhash, ':userName' => $userName, ':salt' => $salt, ':gjp' => $gjp2, ':auth' => $auth]);
	$gs->sendLogsAccountChangeWebhook($_SESSION["accountID"], $_SESSION["accountID"], $getAccountData);
	$_SESSION["accountID"] = 0;
	setcookie('auth', 'no', 2147483647, '/');
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("changePassTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("changedPass").'</p>
        <button type="button" onclick="a(\'account/changePassword.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'account');
	//decrypting save
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
	$saveData = file_get_contents("../".$dbPath."data/accounts/$accountID");
	if(file_exists("../".$dbPath."data/accounts/keys/$accountID")){
		$protected_key_encoded = file_get_contents("../".$dbPath."data/accounts/keys/$accountID");
		if($protected_key_encoded != ""){
			$protected_key = KeyProtectedByPassword::loadFromAsciiSafeString($protected_key_encoded);
			$user_key = $protected_key->unlockKey($oldpass);
			try {
				$saveData = Crypto::decrypt($saveData, $user_key);
			} catch (Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
				exit("Unable to update save data encryption");	
			}
			file_put_contents("../".$dbPath."data/accounts/$accountID",$saveData);
			file_put_contents("../".$dbPath."data/accounts/keys/$accountID","");
		}
	}
}else{
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("wrongPass").'</p>
        <button type="button" onclick="a(\'account/changePassword.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>', 'account');
} 

} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("changePassTitle").'</h1>
    <form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("changePassDesc").'</p>
        <div class="field"><input type="password" name="oldpassword" id="p1" placeholder="'.$dl->getLocalizedString("oldPassword").'"></div>
        <div class="field"><input type="password" name="newpassword" id="p2" placeholder="'.$dl->getLocalizedString("newPassword").'"></div>
        <text class="samepass" id="sp">'.$dl->getLocalizedString("passDontMatch").'</text>
		<div class="field"><input type="password" name="newpassconfirm" id="p3" placeholder="'.$dl->getLocalizedString("confirmNew").'"></div>
		'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'account/changePassword.php\', true, true, \'POST\')" style="margin-top:5px" type="submit" id="submit" class="btn-song">'.$dl->getLocalizedString("changePassword").'</button>
    </form>
</div>', 'account');
}} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p id="dashboard-error-text">'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\')"class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'account');
}
?>
