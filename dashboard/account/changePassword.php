<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
include_once "../".$dbPath."config/security.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
include_once "../".$dbPath."incl/lib/defuse-crypto.phar";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$ep = new exploitPatch();
error_reporting(E_ERROR | E_PARSE);
$dl->title($dl->getLocalizedString("changePassTitle"));
$dl->printFooter('../');
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if($_POST["oldpassword"] != "" AND $_POST["newpassword"] != "" AND $_POST["newpassword"] == $_POST["newpassconfirm"]) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'account');
		die();
	}
	$userName = $gs->getAccountName($_SESSION["accountID"]);
	$oldpass = ExploitPatch::remove($_POST["oldpassword"]);
	$newpass = ExploitPatch::remove($_POST["newpassword"]);
	if($oldpass == $newpass){
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("samePass").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>', 'account');
		die();
	}
	$pass = GeneratePass::isValidUsrname($userName, $oldpass);
	$salt = "";
if ($pass == 1) {
	$passhash = password_hash($newpass, PASSWORD_DEFAULT);
	$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");	
	$query->execute([':password' => $passhash, ':userName' => $userName, ':salt' => $salt]);
    $auth = $gs->randomString(8);
    $query = $db->prepare("UPDATE accounts SET auth = :auth WHERE accountID = :id");
    $query->execute([':auth' => $auth, ':id' => $_SESSION["accountID"]]);
	$_SESSION["accountID"] = 0;
	setcookie('auth', 'no', 2147483647, '/');
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("changePassTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("changedPass").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
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
		<p>'.$dl->getLocalizedString("wrongPass").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
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
		', 'account');
		Captcha::displayCaptcha();
        echo '
        <button style="margin-top:5px" type="submit" id="submit" class="btn-song btn-block" disabled>'.$dl->getLocalizedString("changePassword").'</button>
    </form>
</div><script>
$(document).change(function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const p3 = document.getElementById("p3");
   const btn = document.getElementById("submit");
   const sp = document.getElementById("sp");
   if(!p1.value.trim().length || !p2.value.trim().length || !p3.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
	} else if(p2.value != p3.value) {
    			sp.classList.add("no");
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
                btn.classList.add("btn-size");
	} else {
    			sp.classList.remove("no");
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-song");
	}
});
</script>';
}} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'account');
}
?>
