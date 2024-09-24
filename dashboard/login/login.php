<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/security.php";
require "../".$dbPath."config/mail.php";
$dl = new dashboardLib();
require "../".$dbPath."incl/lib/generatePass.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/Captcha.php";
if(isset($_SESSION["accountID"]) && $_SESSION["accountID"] != 0) header('Location: ../');
if(isset($_POST["resendMailUserName"]) && isset($_POST["resendMailEmail"]) && $mailEnabled) {
	$dl->title($dl->getLocalizedString("resendMailTitle"));
	$dl->printFooter('../');
	if(!Captcha::validateCaptcha()) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	$userName = ExploitPatch::charclean($_POST["resendMailUserName"]);
	$email = ExploitPatch::rucharclean($_POST["resendMailEmail"]);
	$check = $db->prepare('SELECT count(*) FROM accounts WHERE userName = :username AND email = :email AND isActive = 0');
	$check->execute([':username' => $userName, ':email' => $email]);
	$check = $check->fetchColumn();
	if($check) $gs->mail($email, $userName);
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("resendMailTitle").'</h1>
		<form class="form__inner" action="" method="post">
			<p>'.$dl->getLocalizedString("maybeSentAMessage").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>'));
}
if(isset($_POST["userName"]) && isset($_POST["password"])) {
	$userName = ExploitPatch::charclean($_POST["userName"]);
	$password = $_POST["password"];
	$valid = GeneratePass::isValidUsrname($userName, $password);
	if($valid != 1) {
		$dl->title($dl->getLocalizedString("loginBox"));
        $dl->printFooter('../');
      	if($valid == -2) {
            if($mailEnabled) $dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" action="" method="post">
					<p>'.$dl->getLocalizedString("didntActivatedEmail").'</p>
					<p style="margin-top: -20px;"><a style="color: #007bff; cursor: pointer;" onclick="a(\'login/login.php?resend_mail\', true, true, \'GET\')">'.$dl->getLocalizedString("resendMailHint").'</a></p>
					<button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
            </div>');
			else $dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" action="" method="post">
					<p style="margin-top: -20px;"><a style="color: #007bff; cursor: pointer;" onclick="a(\'login/activate.php\', true, false, \'GET\'>'.$dl->getLocalizedString("activateDesc").'</a></p>
					<button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
            </div>');
			die();
        }
		if($valid == -1) {
			$accountID = $gs->getAccountIDFromName($userName);
			$userID = $gs->getUserID($accountID, $userName);
			$checkBan = $gs->getPersonBan($accountID, $userID, 4);
			if($checkBan) {
				exit($dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" action="" method="post">
						<p>'.sprintf($dl->getLocalizedString("youAreBanned"), htmlspecialchars(base64_decode($checkBan['reason'])), date("d.m.Y G:i", $checkBan['expires'])).'</p>
						<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
					</form>
				</div>'));
			}
		}
		exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" action="" method="post">
				<p>'.$dl->getLocalizedString("wrongNickOrPass").'</p>
				<button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>'));
	}
	$accountID = $gs->getAccountIDFromName($userName);
  	$_SESSION["accountID"] = $accountID;
  	$query = $db->prepare("SELECT auth FROM accounts WHERE accountID = :id");
  	$query->execute([':id' => $accountID]);
  	$auth = $query->fetch();
    if($auth["auth"] == 'none') {
          $auth = $gs->randomString(8);
          $query = $db->prepare("UPDATE accounts SET auth = :auth WHERE accountID = :id");
          $query->execute([':auth' => $auth, ':id' => $accountID]);
		  setcookie('auth', $auth, 2147483647, '/');
    } else setcookie('auth', $auth["auth"], 2147483647, '/');
	if(!empty($_SERVER["HTTP_REFERER"])) header('Location: '.$_SERVER["HTTP_REFERER"]);
	else header('Location: ../');
} else {
	$dl->printFooter('../');
	if(isset($_GET['resend_mail']) && $mailEnabled) {
		$dl->title($dl->getLocalizedString("resendMailTitle"));
		exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("resendMailTitle").'</h1>
		<form class="form__inner" action="" method="post">
			<p>'.$dl->getLocalizedString('resendMailDesc').'</p>
			<div class="field">
				<input type="text" class="form-control login-input" id="resendMailUserName" name="resendMailUserName" placeholder="'.$dl->getLocalizedString("username").'">
			</div>
			<div class="field">
				<input type="email" class="form-control" id="resendMailEmail" name="resendMailEmail" placeholder="'.$dl->getLocalizedString("email").'">
			</div>
			'.Captcha::displayCaptcha(true).'
			<button type="submit" class="btn-primary btn-block" id="resendMailSubmit" disabled>'.$dl->getLocalizedString("resendMailButton").'</button>
		</form>
		<script>
		$(document).on("keyup keypress change keydown", function() {
		   const resendMailUserName = document.getElementById("resendMailUserName");
		   const resendMailEmail = document.getElementById("resendMailEmail");
		   const btn = document.getElementById("resendMailSubmit");
		   if(!resendMailUserName.value.trim().length || !resendMailEmail.value.trim().length) {
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
	</div>'));
	}
	$dl->title($dl->getLocalizedString("loginBox"));
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("loginBox").'</h1>
		<form class="form__inner" action="" method="post">
			<p>'.$dl->getLocalizedString('loginDesc').'</p>
			<div class="field">
				<input type="text" class="form-control login-input" id="loginPageUserName" name="userName" placeholder="'.$dl->getLocalizedString("enterUsername").'">
			</div>
			<div class="field">
				<input type="password" class="form-control" id="loginPagePassword" name="password" placeholder="'.$dl->getLocalizedString("enterPassword").'">
			</div>'.(!$preactivateAccounts ? ($mailEnabled ? '<button style="margin: -15px 0px;" type="button" onclick="a(\'login/forgotPassword.php\')" class="forgotPassword">'.$dl->getLocalizedString("forgotPasswordTitle").'</button>' : '<button style="margin: -15px 0px;" type="button" onclick="a(\'login/activate.php\')" class="forgotPassword">'.$dl->getLocalizedString("activateAccount").'</button>') : '').'
			<button type="submit" class="btn-primary btn-block" id="loginPageSubmit" disabled>'.$dl->getLocalizedString("login").'</button>
		</form>
		<script>
		$(document).on("keyup keypress change keydown", function() {
		   const loginPageUserName = document.getElementById("loginPageUserName");
		   const loginPagePassword = document.getElementById("loginPagePassword");
		   const btn = document.getElementById("loginPageSubmit");
		   if(!loginPageUserName.value.trim().length || !loginPagePassword.value.trim().length) {
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
	</div>');
}
?>