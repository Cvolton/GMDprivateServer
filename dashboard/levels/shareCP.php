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
				<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>');
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
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>');
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
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>');
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
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>');
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
		<a class="a" href="../tools/cron/cron.php">'.$dl->getLocalizedString("updateCron").'</a>
	    <button type="submit" class="btn-primary">'.$dl->getLocalizedString("shareCPOneMore").'</button>
    </form>
</div>');
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
	');
		Captcha::displayCaptcha();
        echo '
        <button type="submit" class="btn-primary">' . $dl->getLocalizedString("shareCP") . '</button>
    </form>
    </div>
    <script>
        document.addEventListener("submit", () => {
            let selectData = [];
            document.querySelectorAll("select > option").forEach(el => {
                selectData.push(el.value);
            });

            var formData = new FormData();

            formData.append("select_data", selectData);

            var request = new XMLHttpRequest();
            request.open("POST", "/");
            request.send(formData);

        });
    </script>';
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