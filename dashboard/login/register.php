<?php
session_start();
require "../../incl/lib/Captcha.php";
include "../../config/security.php";
include "../../incl/lib/connection.php";
require "../../incl/lib/exploitPatch.php";
include "../incl/dashboardLib.php";
$dl = new dashboardLib();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] == 0){
if(!isset($preactivateAccounts)){
	$preactivateAccounts = false;
}

// here begins the checks
if(!empty($_POST["username"]) AND !empty($_POST["email"]) AND !empty($_POST["repeatemail"]) AND !empty($_POST["password"]) AND !empty($_POST["repeatpassword"])){
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
	$username = ExploitPatch::remove($_POST["username"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$repeat_password = ExploitPatch::remove($_POST["repeatpassword"]);
	$email = ExploitPatch::remove($_POST["email"]);
	$repeat_email = ExploitPatch::remove($_POST["repeatemail"]);
	if(strlen($username) < 3){
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("smallNick").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>');
	}elseif(strlen($password) < 6){
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("smallPass").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>');
	}else{
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $username]);
		$registred_users = $query->fetchColumn();
		if($registred_users > 0){
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("alreadyUsedNick").'</p>
				<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>');
			}else{
			if($password != $repeat_password){
				$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("passDontMatch").'</p>
					<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>');
			}elseif($email != $repeat_email){
				$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("emailDontMatch").'</p>
					<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>');
				}else{
				// hashing your password and registering your account
				$hashpass = password_hash($password, PASSWORD_DEFAULT);
				$query2 = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive)
				VALUES (:userName, :password, :email, :time, :isActive)");
				$query2->execute([':userName' => $username, ':password' => $hashpass, ':email' => $email,':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0]);
				// there you go, you are registered.
				$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("registerAcc").'</h1>
					<form class="form__inner" method="post" action="../dashboard">
					<p>'.$dl->getLocalizedString("registered").'</p>
					<button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
					</form>
				</div>');
			}
		}
	}
}else{
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("registerAcc").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("registerDesc").'</p>
        <div class="field"><input type="text" name="username" placeholder="'.$dl->getLocalizedString("username").'"></div>
        <div class="field"><input type="password" name="password" placeholder="'.$dl->getLocalizedString("password").'"></div>
		<div class="field"><input type="password" name="repeatpassword" placeholder="'.$dl->getLocalizedString("repeatpassword").'"></div>
		<div class="field"><input type="email" name="email" placeholder="'.$dl->getLocalizedString("email").'"></div>
		<div class="field"><input type="email" name="repeatemail" placeholder="'.$dl->getLocalizedString("repeatemail").'"></div>
		');
		Captcha::displayCaptcha();
        echo '
        <button type="submit" class="btn-song">'.$dl->getLocalizedString("register").'</button>
    </form>
</div>';
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="../dashboard">
	<p>'.$dl->getLocalizedString("loginAlready").'</p>
	        <button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>');
}
?>