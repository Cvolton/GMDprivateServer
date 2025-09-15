<?php
session_start();
require_once "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("banUserPlace"));
$dl->printFooter('../');
if(!$gs->checkPermission($_SESSION["accountID"], "dashboardModTools")) {
	die($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
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
				<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod'));
		}
		$person = trim(ExploitPatch::rucharclean($_POST["person"]));
		$personType = ExploitPatch::number($_POST["personType"]);
		$reason = trim(ExploitPatch::rucharclean($_POST["reason"]));
		$banType = ExploitPatch::number($_POST["banType"]);
		$expires = !empty($_POST['expires']) ? (new DateTime($_POST['expires']))->getTimestamp() : 2147483647;
		$alsoBanIP = $_POST["alsoBanIP"] == 'on' && $personType != 2;
		$check = $gs->getBan($person, $personType, $banType);
		$triedToBanYourself = $getIP = false;
		switch($personType) {
			case 0:
				if($_SESSION['accountID'] == $person) $triedToBanYourself = true;
				elseif($alsoBanIP) {
					$getIP = $db->prepare('SELECT IP FROM users WHERE extID = :person');
					$getIP->execute([':person' => $person]);
					$getIP = $getIP->fetchColumn();
				}
				break;
			case 1:
				if($gs->getUserID($_SESSION['accountID'], $gs->getAccountName($_SESSION['accountID'])) == $person) $triedToBanYourself = true;
				elseif($alsoBanIP) {
					$getIP = $db->prepare('SELECT IP FROM users WHERE userID = :person');
					$getIP->execute([':person' => $person]);
					$getIP = $getIP->fetchColumn();
				}
				break;
			case 2:
				if($gs->IPForBan($gs->getIP()) == $gs->IPForBan($person)) $triedToBanYourself = true;
				break;
		}
		if($triedToBanYourself) die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("banYourself").'</p>
			<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
		if($check) die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("userIsBanned").'</p>
			<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
		if(time() >= $expires) die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("noBanInPast").'</p>
			<button type="button" onclick="a(\'account/banPerson.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
		$gs->banPerson($_SESSION['accountID'], $person, $reason, $banType, $personType, $expires);
		if($getIP) $gs->banPerson($_SESSION['accountID'], $getIP, $reason, $banType, 2, $expires);
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
        <div class="field selectField"><input type="text" value="'.ExploitPatch::rucharclean($_GET['person']).'" name="person" id="personField" placeholder="'.$dl->getLocalizedString("person").'">
		<select style="width:60%" name="personType" id="personType">
			<option value="0">'.$dl->getLocalizedString('accountID').'</option>
			<option value="1">'.$dl->getLocalizedString('userID').'</option>
			<option value="2">'.$dl->getLocalizedString('IP').'</option>
		</select>
		</div>
        <div class="field selectField"><select style="width:60%" name="banType" id="banType">
			<option value="0">'.$dl->getLocalizedString('playerTop').'</option>
			<option value="1">'.$dl->getLocalizedString('creatorTop').'</option>
			<option value="2">'.$dl->getLocalizedString('levelUploading').'</option>
			<option value="3">'.$dl->getLocalizedString('commentBan').'</option>
			<option value="4">'.$dl->getLocalizedString('account').'</option>
		</select><input type="datetime-local" name="expires" min="'.substr(explode('+', (new DateTime())->format('c'))[0], 0, -3).'" placeholder="'.$dl->getLocalizedString("expires").'"></div>
        <div class="field"><input type="text" name="reason" placeholder="'.$dl->getLocalizedString("banReason").'"></div>
		<div class="checkbox" id="alsoBanIP" style="display: flex; width: 100%;">
			<input name="alsoBanIP" type="checkbox">
			<h3>'.$dl->getLocalizedString('alsoBanIP').'</h3>
		</div>
		'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'account/banPerson.php\', true, true, \'POST\')" class="btn-primary" id="banSubmit">'.$dl->getLocalizedString("ban").'</button>
    </form>
</div>
<script>
personTypes = ["'.$dl->getLocalizedString('accountID').'", "'.$dl->getLocalizedString('userID').'", "'.$dl->getLocalizedString('IP').'"];
const personField = document.getElementById("personField");

document.getElementById("personType").value = "'.(ExploitPatch::number($_GET['personType']) ?: 0).'";
document.getElementById("banType").value = "'.(ExploitPatch::number($_GET['banType']) ?: 0).'";
var personType = document.getElementById("personType").value;
personField.setAttribute("placeholder", personTypes[personType]);
document.getElementById("alsoBanIP").style.display = personType != 2 ? "flex" : "none";
</script>', 'mod');
}
?>