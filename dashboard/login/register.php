<?php
session_start();
include "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."config/security.php";
include "../".$dbPath."config/mail.php";
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("registerAcc"));
$dl->printFooter('../');
if(!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0){
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
	$password = $_POST["password"];
	$repeat_password = $_POST["repeatpassword"];
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
				$query2->execute([':userName' => $username, ':password' => $hashpass, ':email' => $email, ':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0]);
				// there you go, you are registered.
              	if($mailEnabled) {
					$gs->mail($email, $username);
					$dl->printSong('<div class="form">
						<h1>'.$dl->getLocalizedString("registerAcc").'</h1>
						<form class="form__inner" method="post" action="."style="grid-gap: 0px;">
						<p>'.$dl->getLocalizedString("registered").'</p>
						<p style="margin-bottom: 20px">'.$dl->getLocalizedString("checkMail").'</p>
						<button type="submit" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
						</form>
					</div>');
				} else $dl->printSong('<div class="form">
						<h1>'.$dl->getLocalizedString("registerAcc").'</h1>
						<form class="form__inner" method="post" action="."style="grid-gap: 0px;">
						<p>'.$dl->getLocalizedString("registered").'</p>
      						<p><a href="login/activate.php">'.(!$preactivateAccounts ? $dl->getLocalizedString('activateDesc') : '').'</a>
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
        <div class="field"><input type="text" id="p1" name="username" placeholder="'.$dl->getLocalizedString("username").'"></div>
        <div class="field"><input type="password" id="p2" name="password" placeholder="'.$dl->getLocalizedString("password").'"></div>
        <text class="samepass" id="sp">'.$dl->getLocalizedString("passDontMatch").'</text>
		<div class="field"><input type="password" id="p3" name="repeatpassword" placeholder="'.$dl->getLocalizedString("repeatpassword").'"></div>
		<div class="field"><input type="email" name="email" id="p4" placeholder="'.$dl->getLocalizedString("email").'"></div>
        <text class="samepass" id="sp2">'.$dl->getLocalizedString("emailDontMatch").'</text>
		<div class="field"><input type="email" name="repeatemail" id="p5" placeholder="'.$dl->getLocalizedString("repeatemail").'"></div>
		');
		Captcha::displayCaptcha();
        echo '
        <button type="submit" class="btn-song btn-block" id="submita" disabled>'.$dl->getLocalizedString("register").'</button>
    </form>
</div>
<script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const p3 = document.getElementById("p3");
   const p4 = document.getElementById("p4");
   const p5 = document.getElementById("p5");
   const btn = document.getElementById("submita");
   const sp = document.getElementById("sp");
   const sp2 = document.getElementById("sp2");
   if(!p1.value.trim().length || !p2.value.trim().length || !p3.value.trim().length || !p4.value.trim().length || !p5.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-song");
                sp.classList.remove("no");
                sp2.classList.remove("no");
	}
    if(p2.value != p3.value) {
    			sp.classList.add("no");
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
                btn.classList.add("btn-size");
	} else sp.classList.remove("no");
    if(p4.value != p5.value) {
    			sp2.classList.add("no");
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
                btn.classList.add("btn-size");
	} else sp2.classList.remove("no");
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
?>
