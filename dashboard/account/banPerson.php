<?php
session_start();
require_once "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("banUserPlace"));
$dl->printFooter('../');
if(!$gs->checkPermission($_SESSION["accountID"], "dashboardModTools")) {
	die($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<p id="bruh">'.$dl->getLocalizedString("noPermission").'</p>
		<form class="form__inner" method="post" action=".">
		<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
		</form>
	</div>', 'mod'));
}
if(isset($_POST["person"]) && isset($_POST["personType"]) && isset($_POST["banType"])) {
		if(!Captcha::validateCaptcha()) {
			die($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod'));
		}
		$person = ExploitPatch::rucharclean($_POST["person"]);
		$personType = ExploitPatch::number($_POST["personType"]);
		$reason = ExploitPatch::rucharclean($_POST["reason"]);
		$banType = ExploitPatch::number($_POST["banType"]);
		$expires = (new DateTime($_POST['expires']))->getTimestamp();
		$check = $gs->getBan($person, $personType, $banType);
		if($check) die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("userIsBanned").'</p>
			<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
		if(time() >= $expires) die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("noBanInPast").'</p>
			<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
		$gs->banPerson($_SESSION['accountID'], $person, $reason, $banType, $personType, $expires);
		$banTypes = ['playerTop', 'creatorTop', 'levelUploading', 'commentBan', 'account'];
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.sprintf($dl->getLocalizedString("banSuccess"), $person, $dl->getLocalizedString($banTypes[$banType]), date("d.m.Y G:i", $expires)).'</p>
			<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
			</form>
		</div>', 'mod');		
} else {
$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
	<h2>'.$dl->getLocalizedString("banDesc").'</h2>
    <form class="form__inner" method="post" action="">
        <div class="field selectField"><input type="text" name="person" id="personField" placeholder="'.$dl->getLocalizedString("person").'">
		<select style="width:60%" name="personType">
			<option value="0">'.$dl->getLocalizedString('accountID').'</option>
			<option value="1">'.$dl->getLocalizedString('userID').'</option>
			<option value="2">'.$dl->getLocalizedString('IP').'</option>
		</select>
		</div>
        <div class="field selectField"><select style="width:60%" name="banType">
			<option value="0">'.$dl->getLocalizedString('playerTop').'</option>
			<option value="1">'.$dl->getLocalizedString('creatorTop').'</option>
			<option value="2">'.$dl->getLocalizedString('levelUploading').'</option>
			<option value="3">'.$dl->getLocalizedString('commentBan').'</option>
			<option value="4">'.$dl->getLocalizedString('account').'</option>
		</select><input type="datetime-local" name="expires" min="'.substr(explode('+', (new DateTime())->format('c'))[0], 0, -3).'" placeholder="'.$dl->getLocalizedString("expires").'"></div>
        <div class="field"><input type="text" name="reason" placeholder="'.$dl->getLocalizedString("banReason").'"></div>
		'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'account/banPerson.php\', true, true, \'POST\')" class="btn-primary btn-block" id="banSubmit" disabled>'.$dl->getLocalizedString("ban").'</button>
    </form>
</div>
<script>
$(document).on("keyup keypress change keydown",function(){
   const personField = document.getElementById("personField");
   const btn = document.getElementById("banSubmit");
   if(!personField.value.trim().length) {
        btn.disabled = true;
        btn.classList.add("btn-block");
        btn.classList.remove("btn-primary");
	} else {
		btn.removeAttribute("disabled");
        btn.classList.remove("btn-block");
        btn.classList.add("btn-primary");
	}
});
</script>', 'mod');
}
?>