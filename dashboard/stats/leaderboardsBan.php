<?php
session_start();
require "../../incl/lib/Captcha.php";
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
error_reporting(E_ERROR | E_PARSE);
$dl->title($dl->getLocalizedString("banUserPlace"));
$dl->printFooter('../');
if(!empty($_POST["userID"])) {
	if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
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
		$userName = $gs->getAccountName($_SESSION["accountID"]);
		$userID = ExploitPatch::remove($_POST["userID"]);
      	$reason = ExploitPatch::remove($_POST["banReason"]);
      	if(empty($reason)) $reason = 'banned';
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
			if(!is_numeric($userID)){
				$nickname = ExploitPatch::remove($_POST["userID"]);
				$userID = $gs->getAccountIDFromName($userID);
			} else {
				$nickname = $gs->getAccountName($userID);
			}
			if($_SESSION["accountID"] == $userID) {
			$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<p id="bruh">'.$dl->getLocalizedString("banYourself").'</p>
    <form class="form__inner" method="post" action="">
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
    </form>
</div>', 'mod');
			die();
		}	$query = $db->prepare("SELECT isBanned FROM users WHERE extID=:id");
			$query->execute([':id' => $userID]);
			$banned = $query->fetchColumn();
			if($banned != 0) {
				$ban = $db->prepare("UPDATE users SET isBanned = 0, isCreatorBanned = 0, banReason = 'none' WHERE extID = :id");
				$ban->execute([':id' => $userID]);
				$success = $dl->getLocalizedString("player"). ' <b>' .$nickname.'</b> '.$dl->getLocalizedString("accid").' <b>'.$userID.'</b> '.$dl->getLocalizedString("unbanned");
              	$bou = 0;
			} else {
				$ban = $db->prepare("UPDATE users SET isBanned = 1, isCreatorBanned = 1, banReason = :ban WHERE extID = :id");
				$ban->execute([':id' => $userID, ':ban' => $reason]);
				$success = $dl->getLocalizedString("player"). ' <b>' .$nickname.'</b> '.$dl->getLocalizedString("accid").' <b>'.$userID.'</b> '.$dl->getLocalizedString("banned");
              	$bou = 1;
			}
			if($ban->rowCount() != 0){
				$dl->printSong('<div class="form">
                    <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
                    <p id="bruh">'.$success.'</p>
                      <form class="form__inner" method="post" action="">
                          <button type="submit" class="btn-primary">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
                      </form>
              		</div>', 'mod');
			}else{
				$dl->printSong('<div class="form">
                    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
                    <p id="bruh">'.$dl->getLocalizedString("nothingFound").'</p>
                    <form class="form__inner" method="post" action="">
                         <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
                    </form>
               		</div>', 'mod');
			die();
			}
			$query = $db->prepare("INSERT INTO modactions  (type, value, value2, value3, timestamp, account) 
													VALUES ('15',:userID, :reason, :bou, :timestamp,:account)");
	$query->execute([':userID' => $userID, ':timestamp' => time(), ':reason' => $reason, ':bou' => $bou, ':account' => $accountID]);
	} else {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<p id="bruh">'.$dl->getLocalizedString("noPermission").'</p>
    <form class="form__inner" method="post" action="../dashboard">
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
die();
	}
} else {
$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
	<h2>'.$dl->getLocalizedString("banDesc").'</h2>
    <form class="form__inner" method="post" action="">
        <div class="field"><input type="text" name="userID" placeholder="'.$dl->getLocalizedString("banUserID").'"></div>
        <div class="field"><input type="text" name="banReason" placeholder="'.$dl->getLocalizedString("banReason").'"></div>
		', 'mod');
		Captcha::displayCaptcha();
        echo '
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("ban").'</button>
    </form>
</div>';
}
?>
