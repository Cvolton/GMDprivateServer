<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/misc.php";
require_once "../".$dbPath."incl/lib/Captcha.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/cron.php";
$dl = new dashboardLib();
$gs = new mainLib();
$dl->printFooter('../');
$dl->title($dl->getLocalizedString("shareCPTitle"));
if($gs->checkPermission($_SESSION["accountID"], "commandSharecpAll")){
if(!empty($_POST["username"]) AND !empty($_POST["level"])) {
		if(!Captcha::validateCaptcha()) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
		die();
		}
	$userID = ExploitPatch::number($_POST["username"]);
	$level = ExploitPatch::number($_POST["level"]);
	$query = $db->prepare("SELECT * FROM cpshares WHERE levelID = :level AND userID = :user");
	$query->execute([':level' => $level, ':user' => $userID]);
	$res = $query->fetchAll();
	if(count($res) != 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("alreadyShared").'</p>
			<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$query = $db->prepare("SELECT * FROM levels WHERE levelID = :level AND userID = :user");
	$query->execute([':level' => $level, ':user' => $userID]);
	$res = $query->fetchAll();
	if(count($res) != 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("shareToAuthor").'</p>
			<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$query = $db->prepare("SELECT IP FROM users WHERE userID = :user");
	$query->execute([':user' => $userID]);
	$query = $query->fetchColumn();
	$res = $gs->getPersonBan($gs->getExtID($userID), $userID, 1, $query);
	if($res) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("userIsBanned").'</p>
			<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$accountID = $_SESSION["accountID"];
	$query = $db->prepare("INSERT INTO cpshares (levelID, userID) VALUES (:level, :user)");
	$query->execute([':level' => $level, ':user' => $userID]);
	$query = $db->prepare("UPDATE levels SET isCPShared = 1 WHERE levelID = :level");
	$query->execute([':level' => $level]);
	$username = $gs->getAccountName($userID);
	$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value3) VALUES ('11',:value,:timestamp,:account,:level)"); 
	$query->execute([':value' => $username, ':timestamp' => time(), ':account' => $accountID, ':level' => $level]);
	$query = $db->prepare("SELECT levelName FROM levels WHERE levelID=:level");
	$query->execute([':level' => $level]);
	$res = $query->fetch();
	$level = $res["levelName"];
	$success = sprintf($dl->getLocalizedString("shareCPSuccessNew"), $level, $username);
	if($automaticCron) Cron::updateCreatorPoints($_SESSION['accountID'], false);
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("shareCPTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$success.'</p>
	    <button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("shareCPOneMore").'</button>
    </form>
</div>', 'mod');
} else {
	$dl->printSong('<div class="form">
    <h1>' . $dl->getLocalizedString("shareCPTitle") . '</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>' . $dl->getLocalizedString("shareCPDesc") . '</p>
	<div class="field" style="grid-gap: 5px"><input name="username" type="number" placeholder="'.$dl->getLocalizedString('accountID').'"></input>
	<input name="level" type="number" placeholder="'.$dl->getLocalizedString('levelID').'"></input></div>
	'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'POST\')" class="btn-primary">' . $dl->getLocalizedString("shareCP") . '</button>
    </form>
    </div>', 'mod');
}
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
?>