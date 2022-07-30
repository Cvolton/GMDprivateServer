<?php
session_start();
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
error_reporting(E_ERROR | E_PARSE);
if(!empty($_POST["userID"])) {
	if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
		$userName = $gs->getAccountName($_SESSION["accountID"]);
		$userID = ExploitPatch::remove($_POST["userID"]);
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
</div>');
			die();
		}
			$query = $db->prepare("UPDATE users SET isBanned = 1, isCreatorBanned = 1 WHERE extID = :id");
			$query->execute([':id' => $userID]);
			$success = $dl->getLocalizedString("player"). ' <b>' .$nickname.'</b> '.$dl->getLocalizedString("accid").' <b>'.$userID.'</b> '.$dl->getLocalizedString("banned");
			if($query->rowCount() != 0){
				$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
	<p id="bruh">'.$success.'</p>
    <form class="form__inner" method="post" action="">
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
    </form>
</div>');
			}else{
				$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<p id="bruh">'.$dl->getLocalizedString("nothingFound").'</p>
    <form class="form__inner" method="post" action="">
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>');
			die();
			}
			$query = $db->prepare("INSERT INTO modactions  (type, value, value2, timestamp, account) 
													VALUES ('15',:userID, '1',  :timestamp,:account)");
	$query->execute([':userID' => $userID, ':timestamp' => time(), ':account' => $accountID]);}
	 else {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<p id="bruh">'.$dl->getLocalizedString("noPermission").'</p>
    <form class="form__inner" method="post" action="../dashboard">
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>');
die();
	}
} else {
$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
	<h2>'.$dl->getLocalizedString("banDesc").'</h2>
    <form class="form__inner" method="post" action="">
        <div class="field"><input type="text" name="userID" placeholder="'.$dl->getLocalizedString("banUserID").'"></div>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("ban").'</button>
    </form>
</div>');
}
?>
<link rel="stylesheet" href="../incl/cvolton.css">
