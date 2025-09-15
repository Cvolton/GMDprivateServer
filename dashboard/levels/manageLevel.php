<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/misc.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/Captcha.php";
require_once "../".$dbPath."incl/lib/cron.php";
$dl = new dashboardLib();
$gs = new mainLib();
$dl->title($dl->getLocalizedString("manageLevel"));
$dl->printFooter('../');
$manageLevelCheck = $gs->checkPermission($_SESSION["accountID"], "dashboardManageLevels");
if(!$manageLevelCheck) exit($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'browse'));
$levelID = ExploitPatch::number($_GET['levelID']);
$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
$query->execute([':levelID' => $levelID]);
$level = $query->fetch();
if(empty($level)) die($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
		<button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
	</form>
</div>', 'browse'));
if(isset($_GET['deleteLevel'])) {
	if($_POST['yesIAmSure'] == 1) {
		$query = $db->prepare("DELETE FROM comments WHERE levelID = :levelID");
		$query->execute([':levelID' => $levelID]);
		$query = $db->prepare("DELETE from levels WHERE levelID = :levelID LIMIT 1");
		$query->execute([':levelID' => $levelID]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('6', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => "1", ":value2" => $level['levelName'], ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
		if($automaticCron) {
			Cron::autoban($_SESSION['accountID'], false);
			Cron::updateCreatorPoints($_SESSION['accountID'], false);
			Cron::updateSongsUsage($_SESSION['accountID'], false);
		}
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("manageLevel").'</h1>
			<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("successfullyDeletedLevel").'</p>
				<button type="button" onclick="a(\'stats/levelsList.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("levelsList").'</button>
			</form>
		</div>', 'browse');
	} else die($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("manageLevel").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("areYouSure").'</p>
		<input type="hidden" name="yesIAmSure" value="1"></input>
		<button type="button" onclick="a(\'levels/manageLevel.php?levelID='.$levelID.'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("change").'</button>
		<button style="width: 80%;" type="button" onclick="a(\'levels/manageLevel.php?levelID='.$levelID.'&deleteLevel\', true, true, \'POST\')" class="btn-song btn-size">'.$dl->getLocalizedString("delete").'</button>
		</form>
	</div>', 'mod'));
}
if(!empty($_POST["levelName"]) && !empty($_POST["levelAuthor"])) {
	if(!Captcha::validateCaptcha()) {
		die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'levels/manageLevel.php?levelID='.$levelID.'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
	}
	$newLevelName = trim(ExploitPatch::charclean($_POST['levelName'], 20));
	$newLevelAuthor = ExploitPatch::number($_POST['levelAuthor']);
	if(empty($newLevelName) || empty($newLevelAuthor)) {
		die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidPost").'</p>
			<button type="button" onclick="a(\'levels/manageLevel.php?levelID='.$levelID.'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
	}
	$newLevelDesc = ExploitPatch::url_base64_encode(trim($_POST['levelDesc'])) ?: '';
	$newStars = max(0, min(10, ExploitPatch::number($_POST['stars']))) ?: 0;
	$newFeatured = max(0, min(4, ExploitPatch::number($_POST['featured']))) ?:  0;
	$newSongID = ExploitPatch::number($_POST['songID']) ?: 0;
	$newPassword = ExploitPatch::number($_POST['password'], 6) ?: 0;
	$newVerifyCoins = $_POST['verifyCoins'] == 'on' ? 1 : 0;
	$newUnlisted = $_POST['isUnlisted'] == 'on' ? 1 : 0;
	$newLockUpdating = $_POST['lockUpdating'] == 'on' ? 1 : 0;
	$newLockCommenting = $_POST['lockCommenting'] == 'on' ? 1 : 0;
	$starFeatured = $starEpic = 0;
	if($newFeatured > 0) {
		$query = $db->prepare("SELECT starFeatured FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $levelID]);
		$starFeatured = $query->fetchColumn();
		if(!$starFeatured) {
			$query = $db->prepare("SELECT starFeatured FROM levels ORDER BY starFeatured DESC LIMIT 1");
			$query->execute();
			$starFeatured = $query->fetchColumn() + 1;
		}
		if($newFeatured > 1) $starEpic = $newFeatured - 1;
	}
	while(strlen($newPassword) < 6) $newPassword = '0'.$newPassword;
	if(strlen($newPassword) == 6 && substr($newPassword, 0, 1) != '1') $newPassword = '1'.$newPassword;
	if($newPassword == '1000000' || empty($newPassword)) $newPassword = 1;
	if($newLevelName != $level['levelName']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, timestamp, account, value3) VALUES ('8', :value, :value2, :timestamp, :id, :levelID)");
		$query->execute([':value' => $newLevelName, ":value2" => $level['levelName'], ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newLevelAuthor != $level['extID']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('7', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $gs->getAccountName($newLevelAuthor), ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newLevelDesc != $level['levelDesc']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('13', :value, :timestamp, :id, :levelID)");
		$query->execute([':value' => $newLevelDesc, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newStars != $level['starStars']) {
		$diffic = $gs->getDiffFromStars($newStars);
		if($diffic["demon"] == 1) $diffic = 'Demon';
		elseif($diffic["auto"] == 1) $diffic = 'Auto';
		else $diffic = $diffic["name"];
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $diffic, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':value2' => $newStars, ':levelID' => $levelID]);
	}
	if($starFeatured != $level['starFeatured']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => 1, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($starEpic != $level['starEpic']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $starEpic, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);	
	}
	if($newSongID != $level['songID']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('16', :value, :timestamp, :id, :levelID)");
		$query->execute([':value' => $newSongID, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newPassword != $level['password']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :id, :levelID)");
		$query->execute([':value' => $newPassword, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newVerifyCoins != $level['starCoins']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $newVerifyCoins, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newUnlisted != $level['unlisted']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $newUnlisted, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newLockUpdating != $level['updateLocked']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('29', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $newLockUpdating, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	if($newLockCommenting != $level['commentLocked']) {
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('38', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $newLockCommenting, ':timestamp' => time(), ':id' => $_SESSION['accountID'], ':levelID' => $levelID]);
	}
	$updateLevel = $db->prepare("UPDATE levels SET levelName = :levelName, extID = :extID, userID = :userID, levelDesc = :levelDesc, starStars = :stars, starFeatured = :starFeatured, starEpic = :starEpic, songID = :songID, password = :password, starCoins = :starCoins, unlisted = :unlisted, unlisted2 = :unlisted, updateLocked = :updateLocked, commentLocked = :commentLocked WHERE levelID = :levelID");
	$updateLevel->execute([':levelName' => $newLevelName, ':extID' => $newLevelAuthor, ':userID' => $gs->getUserID($newLevelAuthor), ':levelDesc' => $newLevelDesc, ':stars' => $newStars, ':starFeatured' => $starFeatured, ':starEpic' => $starEpic, ':songID' => $newSongID, ':password' => $newPassword, ':starCoins' => $newVerifyCoins, ':unlisted' => $newUnlisted, ':updateLocked' => $newLockUpdating, ':commentLocked' => $newLockCommenting, ':levelID' => $levelID]);
	if($newStars != $level['starStars']) $gs->sendRateWebhook($_SESSION['accountID'], $levelID);
	if($automaticCron) {
		Cron::autoban($_SESSION['accountID'], false);
		Cron::updateCreatorPoints($_SESSION['accountID'], false);
		Cron::updateSongsUsage($_SESSION['accountID'], false);
	}
	$gs->sendLogsLevelChangeWebhook($levelID, $_SESSION['accountID'], $level);
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("manageLevel").'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("successfullyChangedLevel").'</p>
			<button type="button" onclick="a(\'levels/manageLevel.php?levelID='.$levelID.'\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("change").'</button>
		</form>
	</div>', 'browse');
} else {
	$levelName = $level['levelName'];
	$levelDesc = ExploitPatch::url_base64_decode($level['levelDesc']);
	$levelAuthor = $level['extID'];
	$dl->printSong('<div class="form">
    <h1>' . $dl->getLocalizedString("manageLevel") . '</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>' . $dl->getLocalizedString("manageLevelDesc") . '</p>
    <div class="field"style="grid-gap: 10px;">
		<input type="text" name="levelName" id="p1" value="'.$levelName.'" placeholder="'.$dl->getLocalizedString("levelname").'">
		<input style="width: 40%;" type="text" name="levelAuthor" id="p2" value="'.$levelAuthor.'" placeholder="'.$dl->getLocalizedString("accountID").'">
	</div>
    <div class="field"><input type="text" name="levelDesc" value="'.$levelDesc.'" placeholder="'.$dl->getLocalizedString("leveldesc").'"></div>
	<div id="selecthihi">
		<select name="stars" id="stars">
			<option value="10">10 '.$dl->getLocalizedString("starsLevel2").'</option>
			<option value="9">9 '.$dl->getLocalizedString("starsLevel2").'</option>
			<option value="8">8 '.$dl->getLocalizedString("starsLevel2").'</option>
			<option value="7">7 '.$dl->getLocalizedString("starsLevel2").'</option>
			<option value="6">6 '.$dl->getLocalizedString("starsLevel2").'</option>
			<option value="5">5 '.$dl->getLocalizedString("starsLevel2").'</option>
			<option value="4">4 '.$dl->getLocalizedString("starsLevel1").'</option>
			<option value="3">3 '.$dl->getLocalizedString("starsLevel1").'</option>
			<option value="2">2 '.$dl->getLocalizedString("starsLevel1").'</option>
			<option value="1">1 '.$dl->getLocalizedString("starsLevel0").'</option>
			<option value="0">0 '.$dl->getLocalizedString("starsLevel2").'</option>
		</select>
		<select name="featured" id="featured">
			<option value="0">'.$dl->getLocalizedString('isAdminNo').'</option>
			<option value="1" '.(($level["starFeatured"] > 0 && $level["starEpic"] == 0) ? 'selected' : '').'>Featured</option>
			<option value="2" '.($level["starEpic"] == 1 ? 'selected' : '').'>Epic</option>
			<option value="3" '.($level["starEpic"] == 2 ? 'selected' : '').'>Legendary</option>
			<option value="4" '.($level["starEpic"] == 3 ? 'selected' : '').'>Mythic</option>
		</select>
	</div>
	<div class="field" style="grid-gap: 10px;">
		<input id="p2" name="songID" type="number" value="'.$level['songID'].'" placeholder="'.$dl->getLocalizedString("songIDw").'">
		<input id="p3" name="password" type="number" value="'.substr($level['password'], 1).'" placeholder="'.$dl->getLocalizedString("password").'">
    </div>
	<div class="checkboxes">
		<div class="checkbox">
			<input name="verifyCoins" type="checkbox" '.($level['starCoins'] ? 'checked' : '').'>
				<h3>'.$dl->getLocalizedString("silverCoins").'</h3>
			</input>
		</div>
		<div class="checkbox">
			<input name="isUnlisted" type="checkbox" '.($level['unlisted'] != 0 || $level['unlisted2'] != 0 ? 'checked' : '').'>
				<h3>'.$dl->getLocalizedString("unlistedLevel").'</h3>
			</input>
		</div>
		<div class="checkbox">
			<input name="lockUpdating" type="checkbox" '.($level['updateLocked'] ? 'checked' : '').'>
				<h3>'.$dl->getLocalizedString("lockUpdates").'</h3>
			</input>
		</div>
		<div class="checkbox">
			<input name="lockCommenting" type="checkbox" '.($level['commentLocked'] ? 'checked' : '').'>
				<h3>'.$dl->getLocalizedString("lockCommenting").'</h3>
			</input>
		</div>
	</div>
    '.Captcha::displayCaptcha(true).'
	<button type="button" onclick="a(\'levels/manageLevel.php?levelID='.$levelID.'\', true, false, \'POST\')" class="btn-primary" id="levelChange">' . $dl->getLocalizedString("change") . '</button>
	<button style="width: 80%" type="button" onclick="a(\'levels/manageLevel.php?levelID='.$levelID.'&deleteLevel\', true, true, \'GET\')" class="btn-primary btn-size">' . $dl->getLocalizedString("delete") . '</button>
    </form>
    </div></div>
    <script>
		document.getElementById("stars").value = '.$level["starStars"].';
	</script>', 'browse');
}
?>