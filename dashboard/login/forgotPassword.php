<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."config/mail.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("forgotPasswordTitle"));
$dl->printFooter('../');
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] > 0) {
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("loginAlready").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>'));
}
if(!$mailEnabled) {
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("pageDisabled").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>'));
}
if(!empty(ExploitPatch::charclean($_POST['code'])) AND !empty($_POST['password']) AND !empty($_POST['repeatpassword'])) {
	if(!Captcha::validateCaptcha()) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<input type="hidden" name="code" value="'.$_POST['code'].'"></input>
			<input type="hidden" name="password" value="'.$_POST['password'].'"></input>
			<input type="hidden" name="repeatpassword" value="'.$_POST['repeatpassword'].'"></input>
			<button type="button" onclick="a(\'login/forgotPassword.php\', true, false, \'POST\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	$code = ExploitPatch::charclean($_POST['code']);
	$accountID = $db->prepare("SELECT accountID FROM accounts WHERE passCode = :code");
	$accountID->execute([':code' => $code]);
	$accountID = $accountID->fetchColumn();
	if(empty($accountID)) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("nothingFound").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form></div>'));
	} 
	$pass = $_POST['password'];
	$repeatPass = $_POST['repeatpassword'];
	if($pass !== $repeatPass) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("passDontMatch").'</p>
			<input type="hidden" name="code" value="'.$_POST['code'].'"></input>
			<input type="hidden" name="password" value="'.$_POST['password'].'"></input>
			<input type="hidden" name="repeatpassword" value="'.$_POST['repeatpassword'].'"></input>
			<button type="button" onclick="a(\'login/forgotPassword.php\', true, false, \'POST\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	$passhash = password_hash($pass, PASSWORD_DEFAULT);
	$gjp2 = GeneratePass::GJP2hash($pass);
	$auth = $gs->randomString(8);
	$query = $db->prepare("UPDATE accounts SET password = :password, gjp2 = :gjp, auth = :auth, passCode = '' WHERE accountID = :id");	
	$test = $query->execute([':auth' => $auth, ':password' => $passhash, ':id' => $accountID, ':gjp' => $gjp2]);
	var_dump($test);
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("forgotPasswordChangeTitle").'</h1>
		<form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("successfullyChangedPass").'</p>
		<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
	</form></div>'));
}
if(!empty($_GET['code'])) {
	$code = ExploitPatch::charclean(explode('/', $_GET["code"])[count(explode('/', $_GET["code"]))-1]);
	$check = $db->prepare("SELECT accountID FROM accounts WHERE passCode = :code");
	$check->execute([':code' => $code]);
	$check = $check->fetch();
	if(empty($check) || empty($code)) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("nothingFound").'</p>
			<button type="button" onclick="a(\'login/forgotPassword.php\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form></div>'));
	} else {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("forgotPasswordChangeTitle").'</h1>
			<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("changePassDesc").'</p>
				<div class="field"><input type="password" id="forgotChangeInput1" name="password" placeholder="'.$dl->getLocalizedString("password").'"></div>
				<text class="samepass" id="forgotChangeText1">'.$dl->getLocalizedString("passDontMatch").'</text>
				<div class="field"><input type="password" id="forgotChangeInput2" name="repeatpassword" placeholder="'.$dl->getLocalizedString("repeatpassword").'"></div>
				'.Captcha::displayCaptcha(true).'
				<button type="button" onclick="a(\'login/forgotPassword.php\', true, false, \'POST\')" class="btn-song" id="submitForgotChange">'.$dl->getLocalizedString("change").'</button>
				<input type="hidden" name="code" value="'.$code.'"></input>
			</form>
		</div>'));
	}
}
if(!empty($_POST['username']) && !empty($_POST['email'])) {
	if(!Captcha::validateCaptcha()) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'login/forgotPassword.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	$username = ExploitPatch::charclean($_POST["username"]);
	$email = ExploitPatch::rucharclean($_POST["email"]);
	$check = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :username AND email LIKE :email");
	$check->execute([':username' => $username, ':email' => $email]);
	$check = $check->fetch();
	if($check) {
		$code = $gs->randomString(6);
		$sendCode = $db->prepare("UPDATE accounts SET passCode = :code WHERE accountID = :id");
		$sendCode->execute([':code' => $code, ':id' => $check['accountID']]);
		$gs->mail($email, $username, $code);
	}
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("forgotPasswordTitle").'</h1>
		<form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("maybeSentAMessage").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>'));
} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("forgotPasswordTitle").'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("forgotPasswordDesc").'</p>
			<div class="field"><input type="text" id="forgotInput1" name="username" placeholder="'.$dl->getLocalizedString("username").'"></div>
			<div class="field"><input type="email" name="email" id="forgotInput2" placeholder="'.$dl->getLocalizedString("email").'"></div>
			'.Captcha::displayCaptcha(true).'
			<button type="button" onclick="a(\'login/forgotPassword.php\', true, false, \'POST\')" class="btn-song" id="submitForgot">'.$dl->getLocalizedString("forgotPasswordButton").'</button>
		</form>
	</div>');
}
?>