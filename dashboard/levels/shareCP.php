<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$dl->printFooter('../');
$dl->title($dl->getLocalizedString("shareCPTitle"));
if($gs->checkPermission($_SESSION["accountID"], "commandSharecpAll")){
	$query = $db->prepare("SELECT userID, userName FROM users WHERE isRegistered=1 ORDER BY userName ASC");
	$query->execute();
	$result = $query->fetchAll();
if(!empty($_POST["username"]) AND !empty($_POST["level"])) {
		if(!Captcha::validateCaptcha()) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
		die();
		}
	$username = ExploitPatch::remove($_POST["username"]);
	$level = ExploitPatch::remove($_POST["level"]);
	$query = $db->prepare("SELECT * FROM cpshares WHERE levelID=:level AND userID=:user");
	$query->execute([':level' => $level, ':user' => $username]);
	$res = $query->fetchAll();
	if(count($res) != 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("alreadyShared").'</p>
			<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$query = $db->prepare("SELECT * FROM levels WHERE levelID=:level AND userID=:user");
	$query->execute([':level' => $level, ':user' => $username]);
	$res = $query->fetchAll();
	if(count($res) != 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("shareToAuthor").'</p>
			<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$query = $db->prepare("SELECT isCreatorBanned FROM users WHERE userID=:user AND isCreatorBanned=1");
	$query->execute([':user' => $username]);
	$res = $query->fetchAll();
	if(count($res) != 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("userIsBanned").'</p>
			<button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$accountID = $_SESSION["accountID"];
	$query = $db->prepare("INSERT INTO cpshares (levelID, userID) VALUES (:level, :user)");
	$query->execute([':level' => $level, ':user' => $username]);
	$query = $db->prepare("UPDATE levels SET isCPShared=1 WHERE levelID=:level");
	$query->execute([':level' => $level]);
	$username = $gs->getUserName($username);
	$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value3) VALUES ('11',:value,:timestamp,:account,:level)"); 
	$query->execute([':value' => $username, ':timestamp' => time(), ':account' => $accountID, ':level' => $level]);
	$query = $db->prepare("SELECT levelName FROM levels WHERE levelID=:level");
	$query->execute([':level' => $level]);
	$res = $query->fetch();
	$level = $res["levelName"];
	$success = $dl->getLocalizedString("shareCPSuccess").' <b>'.$level.' </b>'.$dl->getLocalizedString("shareCPSuccess2").' <b>'.$username.'</b>!';
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("shareCPTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$success.'</p>
		<a class="a">'.$dl->getLocalizedString("updateCron").'</a>
	    <button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("shareCPOneMore").'</button>
    </form>
</div>', 'mod');
} else {
	$optionUser = '';
	foreach ($result as $i => $row) {
			$optionUser .= '<option value="'. $row['userID'] .'">'. $row['userName'] .'</option>';
	}
	$query = $db->prepare("SELECT levelID, levelName, starStars FROM levels ORDER BY levelName ASC");
	$query->execute();
	$result = $query->fetchAll();
	$optionLevel = '';
	foreach ($result as $i => $row) {
		if($row["starStars"] != 0)
			$optionLevel .= '<option value="'. $row['levelID'] .'">'. $row['levelName'] .'</option>';
	}
	$dl->printSong('<div class="form">
    <h1>' . $dl->getLocalizedString("shareCPTitle") . '</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>' . $dl->getLocalizedString("shareCPDesc") . '</p>
    <div>
    <select name="username">
        '.$optionUser.'
    </select>
    <select name="level">
        '.$optionLevel.'
    </select>
    </div>
	', 'mod');
		Captcha::displayCaptcha();
        echo '
        <button type="button" onclick="a(\'levels/shareCP.php\', true, false, \'POST\')" class="btn-primary">' . $dl->getLocalizedString("shareCP") . '</button>
    </form>
    </div>';
}
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
?>