<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."config/security.php";
require "../".$dbPath."config/mail.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."incl/lib/generatePass.php";
require "../".$dbPath."incl/lib/automod.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("registerAcc"));
$dl->printFooter('../');
if(Automod::isAccountsDisabled(0)) exit($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="">
	<p>'.$dl->getLocalizedString("pageDisabled").'</p>
	<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
	</form>
</div>'));
if(!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0) {
if(!isset($preactivateAccounts)) $preactivateAccounts = false;
if(!isset($filterUsernames)) global $filterUsernames;
// here begins the checks
if(!empty($_POST["username"]) AND !empty($_POST["email"]) AND !empty($_POST["repeatemail"]) AND !empty($_POST["password"]) AND !empty($_POST["repeatpassword"])){
	if(!Captcha::validateCaptcha()) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	$username = str_replace(' ', '', ExploitPatch::charclean($_POST["username"]));
	$password = $_POST["password"];
	$repeat_password = $_POST["repeatpassword"];
	$email = ExploitPatch::rucharclean($_POST["email"]);
	$repeat_email = ExploitPatch::rucharclean($_POST["repeatemail"]);
	if($filterUsernames >= 1) {
		$bannedUsernamesList = array_map('strtolower', $bannedUsernames);
		switch($filterUsernames) {
			case 1:
				if(in_array(strtolower($username), $bannedUsernamesList)) exit($dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("badUsername").'</p>
					<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>'));
				break;
			case 2:
				foreach($bannedUsernamesList as $bannedUsername) {
					if(!empty($bannedUsername) && mb_strpos(strtolower($username), $bannedUsername) !== false) exit($dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("badUsername").'</p>
					<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>'));
				}
		}
	}
	if(strlen($username) < 3) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("smallNick").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	if(strlen($username) > 20) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("bigNick").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	if(strlen($password) < 6) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("smallPass").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	} else {
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $username]);
		$registred_users = $query->fetchColumn();
		if($registred_users > 0){
			exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("alreadyUsedNick").'</p>
				<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>'));
			} else {
				if($password != $repeat_password){
					exit($dl->printSong('<div class="form">
						<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
						<form class="form__inner" method="post" action="">
						<p>'.$dl->getLocalizedString("passDontMatch").'</p>
						<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
						</form>
					</div>'));
			} elseif($email != $repeat_email){
				exit($dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("emailDontMatch").'</p>
					<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>'));
				}else{
				if($mailEnabled) {
					$checkMail = $db->prepare("SELECT count(*) FROM accounts WHERE email LIKE :mail");
					$checkMail->execute([':mail' => $email]);
					$checkMail = $checkMail->fetchColumn();
					if($checkMail > 0) exit($dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("mailExists").'</p>
					<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>'));
				}
				$hashpass = password_hash($password, PASSWORD_DEFAULT);
				$gjp2 = GeneratePass::GJP2hash($password);
				$query2 = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive, gjp2)
				VALUES (:userName, :password, :email, :time, :isActive, :gjp)");
				$query2->execute([':userName' => $username, ':password' => $hashpass, ':email' => $email, ':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0, ':gjp' => $gjp2]);
				$accountID = $db->lastInsertId();
				$gs->logAction($accountID, 1, $username, $email, $gs->getUserID($accountID, $username));
              	$gs->sendLogsRegisterWebhook($accountID);
				if($mailEnabled) {
					$gs->mail($email, $username);
					exit($dl->printSong('<div class="form">
						<h1>'.$dl->getLocalizedString("registerAcc").'</h1>
						<form class="form__inner" method="post" action="."style="grid-gap: 0px;">
						<p>'.$dl->getLocalizedString("registered").'</p>
						<p style="margin-bottom: 20px">'.$dl->getLocalizedString("checkMail").'</p>
						<button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
						</form>
					</div>'));
				} else exit($dl->printSong('<div class="form">
						<h1>'.$dl->getLocalizedString("registerAcc").'</h1>
						<form class="form__inner" method="post" action="."style="grid-gap: 0px;">
						<p>'.$dl->getLocalizedString("registered").'</p>
						<button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
						</form>
					</div>'));
			}
		}
	}
}else{
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("registerAcc").'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("registerDesc").'</p>
			<div class="field"><input type="text" id="registerInput1" name="username" placeholder="'.$dl->getLocalizedString("username").'"></div>
			<div class="field"><input type="password" id="registerInput2" name="password" placeholder="'.$dl->getLocalizedString("password").'"></div>
			<text class="samepass" id="registerText1">'.$dl->getLocalizedString("passDontMatch").'</text>
			<div class="field"><input type="password" id="registerInput3" name="repeatpassword" placeholder="'.$dl->getLocalizedString("repeatpassword").'"></div>
			<div class="field"><input type="email" name="email" id="registerInput4" placeholder="'.$dl->getLocalizedString("email").'"></div>
			<text class="samepass" id="registerText2">'.$dl->getLocalizedString("emailDontMatch").'</text>
			<div class="field"><input type="email" name="repeatemail" id="registerInput5" placeholder="'.$dl->getLocalizedString("repeatemail").'"></div>
			'.Captcha::displayCaptcha(true).'
			<button type="submit" class="btn-song" id="submitRegister">'.$dl->getLocalizedString("register").'</button>
		</form>
	</div>');
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action=".">
	<p>'.$dl->getLocalizedString("loginAlready").'</p>
	    <button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>');
}
?>