<?php
session_start();
include "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
include "../".$dbPath."config/security.php";
include "../".$dbPath."config/mail.php";
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("activateAccount"));
$dl->printFooter('../');
if(!$preactivateAccounts) {
if(!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0){
if($mailEnabled) {
	if(isset($_GET["mail"])) {
		$mail = ExploitPatch::remove(explode('/', $_GET["mail"])[count(explode('/', $_GET["mail"]))-1]);
		$check = $db->prepare("SELECT accountID FROM accounts WHERE mail = :mail");
		$check->execute([':mail' => $mail]);
		$check = $check->fetch();
		if(empty($check)) {
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
	if ($pass == -2){
		$query = $db->prepare("UPDATE accounts SET isActive = 1 WHERE userName LIKE :userName");
		$query->execute(['userName' => $userName]);
		 $dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("activateAccount").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("activated").'</p>
			<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form></div>');
	}
	elseif ($pass == 1) {
		 $dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("alreadyActivated").'</p>
			<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form></div>');
	}else{
		 $dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("nothingFound").'</p>
			<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form></div>');
	}
}else{
	 $dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("activateAccount").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("activateDesc").'</p>
		<div class="field"><input type="text" name="userName" id="p1" placeholder="'.$dl->getLocalizedString("enterUsername").'"></div>
		<div class="field"><input type="password" name="password" id="p2" placeholder="'.$dl->getLocalizedString("enterPassword").'"></div>
		');
		Captcha::displayCaptcha();
        echo '
		<button type="submit" class="btn-primary btn-block" id="submit11" disabled>'.$dl->getLocalizedString("activate").'</button>
	</form></div>
    <script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const btn = document.getElementById("submit11");
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
</script>';
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