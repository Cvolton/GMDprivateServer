<?php
session_start();
require "../../incl/lib/Captcha.php";
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
include "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$dl->title($dl->getLocalizedString("addMod"));
$dl->printFooter('../');
if($gs->checkPermission($_SESSION["accountID"], "dashboardAddMod")){
	$accountID = $_SESSION["accountID"];
if(!empty($_POST["user"])) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	$mod = ExploitPatch::remove($_POST["user"]);
	$role = ExploitPatch::remove($_POST["role"]);
	if(!is_numeric($role) OR $role != 2 AND $role != 3) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidPost").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	if(!is_numeric($mod)) $mod = $gs->getAccountIDFromName($mod); 
	$query = $db->prepare("SELECT accountID FROM accounts WHERE accountID=".$mod."");
	$query->execute();
	$res = $query->fetchAll();
	if(count($res) == 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("nothingFound").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	if($mod == $accountID) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("modYourself").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	$query = $db->prepare("SELECT accountID FROM roleassign WHERE accountID=:mod");
	$query->execute([':mod' => $mod]);
	$res = $query->fetchAll();
	if(count($res) != 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("alreadyMod").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}

	$query = $db->prepare("INSERT INTO roleassign (roleID, accountID) VALUES (:role, :mod)");
	$query->execute([':role' => $role, ':mod' => $mod]);
	$mod = $gs->getAccountName($mod);
	$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account) VALUES ('20', :value, :timestamp, :account)");
	$query->execute([':value' => $mod, ':timestamp' => time(), ':account' => $accountID]);
	$success = $dl->getLocalizedString("addedMod").' <b>'.$mod."</b>!";
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("addMod").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$success.'</p>
	    <button type="submit" class="btn-primary">'.$dl->getLocalizedString("addModOneMore").'</button>
    </form>
</div>', 'mod');
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("addMod").'</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>'.$dl->getLocalizedString("addModDesc").'</p>
    <div class="field"><input type="text" name="user" placeholder="' . $dl->getLocalizedString("banUserID") . '"></div>
	<div id="selecthihi">
	<select name="role">
		<option value="2">'.$dl->getLocalizedString("elder").'</option>
		<option value="3">'.$dl->getLocalizedString("moder").'</option>
	</select>
	</div>
	', 'mod');
		Captcha::displayCaptcha();
        echo '
        <button type="submit" class="btn-primary">' . $dl->getLocalizedString("addMod") . '</button>
    </form>
    </div>';
}
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>');
?>