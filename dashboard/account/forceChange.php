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
$dl->printFooter('../');
$acc = $_SESSION["accountID"];
error_reporting(E_ERROR | E_PARSE);
if(!$gs->checkPermission($acc, 'dashboardForceChangePassNick')) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<p id="bruh">'.$dl->getLocalizedString("noPermission").'</p>
    <form class="form__inner" method="post" action=".">
	<button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
	</div>', 'mod');
	die();
}
if($_POST["type"] == 0) $type = 'Password'; else $type = 'Nick';
$dl->title($dl->getLocalizedString("force".$type));
if(!empty($_POST["userID"]) AND !empty($_POST[$type])) {
  	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
  if(!empty($_POST["Nick"])) {
    $newnick = ExploitPatch::remove($_POST["Nick"]);
    if(!is_numeric($_POST["userID"])) $accID = $gs->getAccountIDFromName($_POST["userID"]); 
    else $accID = ExploitPatch::number($_POST["userID"]);
    $salt = '';
   	$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName=:userName");
	$query->execute([':userName' => $newnick]);
	$count = $query->fetchColumn();
	if($count > 0) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("alreadyUsedNick").'</p>
				<button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
				</div>', 'mod');
				die();
	}
	$query = $db->prepare("UPDATE accounts SET userName=:userName, salt=:salt WHERE accountID=:accountid");	
	$query->execute([':userName' => $newnick, ':salt' => $salt, ':accountid' => $accID]);
	$query = $db->prepare("UPDATE users SET userName=:userName WHERE extID=:accountid");
	$query->execute([':userName' => $newnick,':accountid' => $accID]);
    $query = $db->prepare("INSERT INTO modactions (type, value, value2, timestamp, account) VALUES ('26',:userID, :type, :timestamp,:account)");
	$query->execute([':userID' => $accID, ':timestamp' => time(), ':type' => $type, ':account' => $acc]);
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("changeNickTitle").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.sprintf($dl->getLocalizedString("forceChangedNick"), $newnick).'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
		</div>', 'mod');
  } elseif($type == 'Password') {
	$newpass = $_POST["Password"]; 
  	if(is_numeric($_POST["userID"])) $userName = $gs->getAccountName($_POST["userID"]); 
    else $userName = ExploitPatch::remove($_POST["userID"]);
  	$salt = '';
	$passhash = password_hash($newpass, PASSWORD_DEFAULT);
	$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");	
	$query->execute([':password' => $passhash, ':userName' => $userName, ':salt' => $salt]);
    $accountID = $gs->getAccountIDFromName($userName);
    $query = $db->prepare("INSERT INTO modactions  (type, value, value2, timestamp, account) VALUES ('26',:userID, :type, :timestamp,:account)");
	$query->execute([':userID' => $accountID, ':timestamp' => time(), ':type' => $type, ':account' => $acc]);
	$saveData = file_get_contents("../".$dbPath."data/accounts/$accountID");
    $dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("changePassTitle").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.sprintf($dl->getLocalizedString("forceChangedPass"), $userName).'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
		</div>', 'mod');
	}
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
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("force".$type).'</h1>
	<h2>'.$dl->getLocalizedString("force".$type.'Desc').'</h2>
    <form method="post" action="" style="display: flex;width: 100%;">
  	  	<button type="submit" name="type" value="1" class="btn-rendel" style="margin-right: 5;">'.$dl->getLocalizedString('changeNickTitle').'</button>
    	<button type="submit" name="type" value="0" class="btn-rendel">'.$dl->getLocalizedString('changePassTitle').'</button>
    </form>
    <form class="form__inner" method="post" action="">
        <div class="field"><input type="text" name="userID" id="p1" placeholder="'.$dl->getLocalizedString("banUserID").'"></div>
        <div class="field"><input type="'.$type.'" name="'.$type.'" id="p2" placeholder="'.$dl->getLocalizedString("new".$type).'"></div>
		', 'mod');
		Captcha::displayCaptcha();
        echo '
        <button type="submit" class="btn-primary btn-block" id="submit" name="type" value="'.$_POST["type"].'" disabled>'.$dl->getLocalizedString("ban").'</button>
    </form><script>
$(document).change(function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length || !p2.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-primary");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-primary");
	}
});
</script>
</div>';
}
?>