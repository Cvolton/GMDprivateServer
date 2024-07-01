<?php
session_start();
require "../incl/dashboardLib.php";
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."config/security.php";
include "../".$dbPath."config/mail.php";
$dl = new dashboardLib();
require "../".$dbPath."incl/lib/generatePass.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) {
	header('Location: ../');
	exit();
}
if(isset($_POST["userName"]) AND isset($_POST["password"])) {
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
            <p>'.$dl->getLocalizedString("didntActivatedEmail").'</p><br>
            <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
            </form>
            </div>');
			else $dl->printSong('<div class="form">
            <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
            <form class="form__inner" action="" method="post">
            <p><a href="login/activate.php">'.$dl->getLocalizedString("activateDesc").'</a></p><br>
            <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
            </form>
            </div>');
			die();
        }
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" action="" method="post">
		<p>'.$dl->getLocalizedString("wrongNickOrPass").'</p>
		<button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>');
		exit();
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
	if(!empty($_POST["ref"])) header('Location: '.$_POST["ref"]);
	elseif(!empty($_SERVER["HTTP_REFERER"])) header('Location: '.$_SERVER["HTTP_REFERER"]);
	else header('Location: ../');
} else {
	$loginbox = '<form class="field" action="" method="post">
							<div class="form-group">
								<input type="text" class="form-control login-input" id="p1" name="userName" placeholder="'.$dl->getLocalizedString("enterUsername").'">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="p2" name="password" placeholder="'.$dl->getLocalizedString("enterPassword").'">
							</div>'.($mailEnabled ? '<button style="margin-top: -10px" type="button" onclick="a(\'login/forgotPassword.php\')" class="forgotPassword">'.$dl->getLocalizedString("forgotPasswordTitle").'</button>' : '');
	if(isset($_SERVER["HTTP_REFERER"])){
		$loginbox .= '<input type="hidden" name="ref" value="'.$_SERVER["HTTP_REFERER"].'">';
	}
	$loginbox .= '<button type="submit" class="btn-primary btn-block" id="submit2" disabled>'.$dl->getLocalizedString("login").'</button>
						</form>
<script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const btn = document.getElementById("submit2");
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
	$dl->title($dl->getLocalizedString("loginBox"));
	$dl->printFooter('../');
	$dl->printSong('<div class="form">
		<h1 style="margin-bottom:10px">'.$dl->getLocalizedString("loginBox").'</h1>
		<p style="margin-bottom:15px">'.$dl->getLocalizedString('loginDesc').'</p>
			'.$loginbox.'
	</div>');
}
?>