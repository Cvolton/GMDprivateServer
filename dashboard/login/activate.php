<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/generatePass.php";
$gs = new mainLib();
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."config/security.php";
require "../".$dbPath."config/mail.php";
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("activateAccount"));
$dl->printFooter('../');
if(!$preactivateAccounts) {
if(!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0){
if($mailEnabled) {
	if(isset($_GET["mail"])) {
		$mail = ExploitPatch::remove(explode('/', $_GET["mail"])[count(explode('/', $_GET["mail"]))-1]);
		$check = $db->prepare("SELECT * FROM accounts WHERE mail = :mail");
		$check->execute([':mail' => $mail]);
		$check = $check->fetch();
		if(empty($check)) {
			$gs->logAction(0, 4, 1);
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action=".">
				<p>'.$dl->getLocalizedString("nothingFound").'</p>
				<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
			</form></div>');
      		die();
		} else {
  			$query = $db->prepare("UPDATE accounts SET isActive = '1', mail = 'activated' WHERE accountID = :acc");
  			$query->execute([':acc' => $check["accountID"]]);
			$gs->logAction($check["accountID"], 3, 1);
			$gs->sendLogsAccountChangeWebhook($check['accountID'], $check['accountID'], $check);
			$dl->printSong('<div class="form">
              <h1>'.$dl->getLocalizedString("activateAccount").'</h1>
              <form class="form__inner" method="post" action=".">
              <p>'.$dl->getLocalizedString("activated").'</p>
              <button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
			</form></div>');
      		die();
		}
	}
	die($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("activateDisabled").'</p>
		<button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>'));
}
if(!empty($_POST["userName"]) && !empty($_POST["password"])){
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>');
	die();
	}
	$userName = ExploitPatch::charclean($_POST["userName"]);
	$password = $_POST["password"];
	$pass = GeneratePass::isValidUsrname($userName, $password);
	$getAccountData = $db->prepare('SELECT * FROM accounts WHERE userName LIKE :userName');
	$getAccountData->execute([':userName' => $userName]);
	$getAccountData = $getAccountData->fetch();
	if($pass == '-2') {
		$query = $db->prepare("UPDATE accounts SET isActive = 1 WHERE userName LIKE :userName");
		$query->execute(['userName' => $userName]);
		$gs->logAction($getAccountData["accountID"], 3, 1);
		$gs->sendLogsAccountChangeWebhook($getAccountData['accountID'], $getAccountData['accountID'], $getAccountData);
		 $dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("activateAccount").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("activated").'</p>
			<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form></div>');
	}
	elseif ($pass == 1) {
		$gs->logAction($getAccountData["accountID"], 4, 1);
		 $dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("alreadyActivated").'</p>
			<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form></div>');
	} else {
		if($getAccountData) $gs->logAction($getAccountData["accountID"], 4, 2);
		 $dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("nothingFound").'</p>
			<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form></div>');
	}
} else {
	 $dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("activateAccount").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("activateDesc").'</p>
		<div class="field"><input type="text" name="userName" id="p1" placeholder="'.$dl->getLocalizedString("enterUsername").'"></div>
		<div class="field"><input type="password" name="password" id="p2" placeholder="'.$dl->getLocalizedString("enterPassword").'"></div>
		');
		Captcha::displayCaptcha();
        echo '
		<button type="submit" class="btn-primary" id="submit11">'.$dl->getLocalizedString("activate").'</button>
	</form></div>';
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
} else {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("activateDisabled").'</p>
		<button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>');
}
?>