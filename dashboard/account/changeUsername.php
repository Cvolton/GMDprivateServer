<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/security.php";
require "../".$dbPath."config/misc.php";
require_once "../".$dbPath."incl/lib/Captcha.php";
require_once "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/cron.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("changeNickTitle"));
$dl->printFooter('../');
if(!isset($_SESSION["accountID"]) || $_SESSION["accountID"] == 0) exit($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p id="dashboard-error-text">'.$dl->getLocalizedString("noLogin?").'</p>
    <button type="button" onclick="a(\'login/login.php\')" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
	</form>
</div>', 'account')); 
if($_POST["oldnickname"] != "" AND $_POST["newnickname"] != "" AND $_POST["password"] != "") {
	if(!Captcha::validateCaptcha()) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'account'));
	}
	$userName = $gs->getAccountName($_SESSION["accountID"]);
	$accID = $_SESSION["accountID"];
	$getAccountData = $db->prepare("SELECT * FROM accounts WHERE accountID = :accountID");
	$getAccountData->execute([':accountID' => $accID]);
	$getAccountData = $getAccountData->fetch();
	$oldnick = ExploitPatch::charclean($_POST["oldnickname"]);
	$newnick = str_replace(' ', '', ExploitPatch::charclean($_POST["newnickname"]));
	if($oldnick != $userName) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("wrongNick").'</p>
			<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'account'));
	}
	if($userName == $newnick || $oldnick == $newnick) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("sameNick").'</p>
			<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'account'));
	}
	$pass = $_POST["password"];
	$pass = GeneratePass::isValidUsrname($userName, $pass);
	$salt = "";
	if($pass == 1) {
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $newnick]);
		$count = $query->fetchColumn();
		if($count > 0) {
			exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("alreadyUsedNick").'</p>
				<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'account'));
		}
		$auth = $gs->randomString(8);
		$query = $db->prepare("UPDATE accounts SET userName = :userName, salt = :salt, auth = :auth WHERE accountID = :accountid");	
		$query->execute([':userName' => $newnick, ':salt' => $salt, ':accountid' => $accID, ':auth' => $auth]);
		$gs->sendLogsAccountChangeWebhook($accID, $accID, $getAccountData);
		if($automaticCron) Cron::fixUsernames($accID, false);
		$_SESSION["accountID"] = 0;
		setcookie('auth', 'no', 2147483647, '/');
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("changeNickTitle").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("changedNick").'</p>
			<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>', 'account');
	} else {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("wrongPass").'</p>
			<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'account');
	}
} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("changeNickTitle").'</h1>
		<form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("changeNickDesc").'</p>
        <div class="field"><input type="text" name="oldnickname" id="p1" placeholder="'.$dl->getLocalizedString("oldNick").'"></div>
        <div class="field"><input type="text" name="newnickname" id="p2" placeholder="'.$dl->getLocalizedString("newNick").'"></div>
		<div class="field"><input type="password" name="password" id="p3" placeholder="'.$dl->getLocalizedString("password").'"></div>
		'.Captcha::displayCaptcha(true).'
		<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'POST\')" style="margin-top:5px" type="submit" id="submit" class="btn-song">'.$dl->getLocalizedString("changeUsername").'</button>
		</form>
		</div>', 'account');
}
?>