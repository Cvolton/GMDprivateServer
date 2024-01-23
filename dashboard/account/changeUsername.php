<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
include_once "../".$dbPath."config/security.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$ep = new exploitPatch();
$dl->title($dl->getLocalizedString("changeNickTitle"));
$dl->printFooter('../');
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if($_POST["oldnickname"] != "" AND $_POST["newnickname"] != "" AND $_POST["password"] != "") {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'account');
		die();
	}
	$userName = $gs->getAccountName($_SESSION["accountID"]);
	$accID = $_SESSION["accountID"];
	$oldnick = ExploitPatch::charclean($_POST["oldnickname"]);
	$newnick = ExploitPatch::charclean($_POST["newnickname"]);
	if($oldnick != $userName){
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("wrongNick").'</p>
        <button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>', 'account');
		die();
	} elseif($userName == $newnick OR $oldnick == $newnick){
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("sameNick").'</p>
        <button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>', 'account');
		die();
	}
	$pass = $_POST["password"];
	$pass = GeneratePass::isValidUsrname($userName, $pass);
	$salt = "";
if($pass == 1) {
	$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName=:userName");
	$query->execute([':userName' => $newnick]);
	$count = $query->fetchColumn();
	if($count > 0){
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("alreadyUsedNick").'</p>
				<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
				</div>', 'account');
				die();
	}
	$auth = $gs->randomString(8);
	$query = $db->prepare("UPDATE accounts SET userName=:userName, salt=:salt, auth=:auth WHERE accountID=:accountid");	
	$query->execute([':userName' => $newnick, ':salt' => $salt, ':accountid' => $accID, ':auth' => $auth]);
	$query = $db->prepare("UPDATE users SET userName=:userName WHERE extID=:accountid");
	$query->execute([':userName' => $newnick,':accountid' => $accID]);
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
		<p>'.$dl->getLocalizedString("wrongPass").'</p>
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
		<button type="button" onclick="a(\'account/changeUsername.php\', true, true, \'POST\')" style="margin-top:5px" type="submit" id="submit" class="btn-song btn-block" disabled>'.$dl->getLocalizedString("changeUsername").'</button>
		</form>
		</div><script>
		$(document).on("keyup keypress change keydown",function(){
		   const p1 = document.getElementById("p1");
		   const p2 = document.getElementById("p2");
		   const p3 = document.getElementById("p3");
		   const btn = document.getElementById("submit");
		   if(!p1.value.trim().length || !p2.value.trim().length || !p3.value.trim().length) {
						btn.disabled = true;
						btn.classList.add("btn-block");
						btn.classList.remove("btn-song");
			} else {
						btn.removeAttribute("disabled");
						btn.classList.remove("btn-block");
						btn.classList.remove("btn-size");
						btn.classList.add("btn-song");
			}
		});
    </script>', 'account');
}} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="./login/login.php">
		<p>'.$dl->getLocalizedString("noLogin?").'</p>
	    <button type="button" onclick="a(\'login/login.php\')" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
		</form>
		</div>', 'account');
}
?>