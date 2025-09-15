<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/security.php";
require "../".$dbPath."config/misc.php";
require_once "../".$dbPath."incl/lib/Captcha.php";
require_once "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/cron.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->printFooter('../');
$acc = $_SESSION["accountID"];
if(!$gs->checkPermission($acc, 'dashboardForceChangePassNick')) exit($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	<form class="form__inner" method="post" action=".">
	<button type="button" onclick="a(\'\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
	</form>
</div>', 'mod'));
if($_POST["type"] == 0) {
	$type = 'Password'; 
	$inputtype = '<input type="hidden" name="type" value="0">';
}else {
	$type = 'Nick';
	$inputtype = '<input type="hidden" name="type" value="1">';
}
$dl->title($dl->getLocalizedString("force".$type));
if(!empty($_POST["userID"]) AND !empty($_POST[$type])) {
  	if(!Captcha::validateCaptcha()) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'account/forceChange.php\', true, true, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
	}
  if(!empty($_POST["Nick"])) {
    $newnick = str_replace(' ', '', ExploitPatch::charclean($_POST["Nick"]));
    if(!is_numeric($_POST["userID"])) $accID = $gs->getAccountIDFromName($_POST["userID"]); 
    else $accID = ExploitPatch::number($_POST["userID"]);
    $salt = '';
   	$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query->execute([':userName' => $newnick]);
	$count = $query->fetchColumn();
	if($count > 0) {
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("alreadyUsedNick").'</p>
			<button type="button" onclick="a(\'account/forceChange.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
	}
	$getAccountData = $db->prepare("SELECT * FROM accounts WHERE accountID = :accountID");
	$getAccountData->execute([':accountID' => $accID]);
	$getAccountData = $getAccountData->fetch();
    $auth = $gs->randomString(8);
	$query = $db->prepare("UPDATE accounts SET userName = :userName, salt = :salt, auth = :auth WHERE accountID = :accountid");	
	$query->execute([':userName' => $newnick, ':salt' => $salt, ':accountid' => $accID, ':auth' => $auth]);
	$gs->sendLogsAccountChangeWebhook($accID, $acc, $getAccountData);
	$discord = $gs->hasDiscord($accID);
	if($discord) $gs->changeDiscordUsername($discord, $newnick);
	if($automaticCron) Cron::fixUsernames($_SESSION['accountID'], false);
    $query = $db->prepare("INSERT INTO modactions (type, value, value2, timestamp, account) VALUES ('26',:userID, :type, :timestamp,:account)");
	$query->execute([':userID' => $accID, ':timestamp' => time(), ':type' => $type, ':account' => $acc]);
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("changeNickTitle").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.sprintf($dl->getLocalizedString("forceChangedNick"), $newnick).'</p>
        <button type="button" onclick="a(\'account/forceChange.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>', 'mod'));
  } elseif($type == 'Password') {
	$newpass = $_POST["Password"]; 
  	if(is_numeric($_POST["userID"])) {
		$userName = $gs->getAccountName($_POST["userID"]);
      	$accID = $_POST["userID"];
	}
    else {
		$userName = ExploitPatch::remove($_POST["userID"]);
		$accID = $gs->getAccountIDFromName($_POST["userID"]); 
    }
  	$salt = '';
	$passhash = password_hash($newpass, PASSWORD_DEFAULT);
	$gjp2 = GeneratePass::GJP2hash($newpass);
    $auth = $gs->randomString(8);
	$getAccountData = $db->prepare("SELECT * FROM accounts WHERE accountID = :accountID");
	$getAccountData->execute([':accountID' => $accID]);
	$getAccountData = $getAccountData->fetch();
	$query = $db->prepare("UPDATE accounts SET password=:password, gjp2 = :gjp, salt=:salt, auth=:auth WHERE userName=:userName");	
	$query->execute([':password' => $passhash, ':userName' => $userName, ':salt' => $salt, ':gjp' => $gjp2, ':auth' => $auth]);
	$gs->sendLogsAccountChangeWebhook($accID, $acc, $getAccountData);
    $accountID = $gs->getAccountIDFromName($userName);
    $query = $db->prepare("INSERT INTO modactions  (type, value, value2, timestamp, account) VALUES ('26',:userID, :type, :timestamp,:account)");
	$query->execute([':userID' => $accountID, ':timestamp' => time(), ':type' => $type, ':account' => $acc]);
	$saveData = file_get_contents("../".$dbPath."data/accounts/$accountID");
    $dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("changePassTitle").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.sprintf($dl->getLocalizedString("forceChangedPass"), $userName).'</p>
        <button type="button" onclick="a(\'account/forceChange.php\', true, true, \'GET\')"class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
		</div>', 'mod');
	}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("force".$type).'</h1>
	<h2>'.$dl->getLocalizedString("force".$type.'Desc').'</h2>
    <form method="post" action="" style="display: flex;width: 100%;">
  	  	<button type="submit" name="type" value="1" class="btn-rendel" style="margin-right: 5;">'.$dl->getLocalizedString('changeNickTitle').'</button>
    	<button type="submit" name="type" value="0" class="btn-rendel">'.$dl->getLocalizedString('changePassTitle').'</button>
    </form>
    <form class="form__inner" method="post" action="">
		'.$inputtype.'
        <div class="field"><input type="text" name="userID" id="p1" placeholder="'.$dl->getLocalizedString("banUserID").'"></div>
        <div class="field"><input type="'.$type.'" name="'.$type.'" id="p2" placeholder="'.$dl->getLocalizedString("new".$type).'"></div>
		'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'account/forceChange.php\', true, true, \'POST\')" class="btn-primary" id="submit" name="type" value="'.$_POST["type"].'">'.$dl->getLocalizedString("change").'</button>
    </form>
</div>', 'mod');
}
?>