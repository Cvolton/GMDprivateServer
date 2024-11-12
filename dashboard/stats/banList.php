<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("banList"));
$dl->printFooter('../');
if(!$gs->checkPermission($_SESSION["accountID"], "dashboardModTools")) exit($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod'));
if(!empty($_POST['banID'])) {
	$banID = ExploitPatch::number($_POST['banID']);
	if(!empty($_POST['unban'])) $gs->unbanPerson($banID, $_SESSION['accountID']);
	else {
		$reason = trim(ExploitPatch::rucharclean($_POST['reason']));
		$expires = (new DateTime($_POST['expires']))->getTimestamp();
		if(time() < $expires) $gs->changeBan($banID, $_SESSION['accountID'], $reason, $expires);
	}
}
$query = $db->prepare('SELECT * FROM bans WHERE isActive != 0 ORDER BY timestamp DESC');
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'mod');
	die();
} 
foreach($result as &$action) {
	$person = htmlspecialchars($action['person']);
	switch($action['personType']) {
		case 0:
			$personUsername = $gs->getAccountName($person);
			$personText = '<button type="button" onclick="a(\'profile/'.$personUsername.'\', true, true, \'POST\')" style="margin: 0; display: contents; cursor: pointer;"><h2 class="profilenick acclistnick">'.$personUsername.'</h2></button>';
			break;
		case 1:
			$personUsername = $gs->getUserName($person);
			$personText = '<h2 class="profilenick acclistnick">'.$personUsername.'</h2>';
			break;
		case 2:
			$personText = '<h2 class="profilenick acclistnick">'.$person.'</h2>';
			break;
	}
	$personTypes = ['accountID', 'userID', 'IP'];
	$personTypeText = $dl->getLocalizedString($personTypes[$action['personType']]);
	$banTypes = ['playerTop', 'creatorTop', 'levelUploading', 'commentBan', 'account'];
	$banTypeText = $dl->getLocalizedString($banTypes[$action['banType']]);
	$reason = !empty($action['reason']) ? htmlspecialchars(base64_decode($action['reason'])) : '<i>'.$dl->getLocalizedString('noReason').'</i>';
	$expires = $dl->convertToDate($action['expires'], true);
	if($action['modID'] != 0) {
		$modUsername = $gs->getAccountName($action['modID']);
		$modUsernameButton = '<button type="button" onclick="a(\'profile/'.$modUsername.'\', true, true, \'POST\')" style="margin:0" class="accbtn">'.$modUsername.'</button>';
	} else $modUsernameButton = $dl->getLocalizedString('system');
	$stats = '<p class="profilepic"><i class="fa-solid fa-user"></i> '.$modUsernameButton.'</p>
	<p class="profilepic"><i class="fa-regular fa-user"></i> '.$personTypeText.'</p>
	<p class="profilepic"><i class="fa-solid fa-gavel"></i> '.$banTypeText.'</p>
	<p class="profilepic"><i class="fa-solid fa-clock"></i> '.$expires.'</p>';
	$manage = '<a style="margin-left:5px;width:max-content;color:white;padding:8px;font-size:13px" class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-pencil"></i></a><div onclick="event.stopPropagation()" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;will-change: transform;">
		 <form class="form__inner" method="post" name="banForm'.$action['banID'].'">
			<div class="field">
				<input type="text" name="reason" value="'.htmlspecialchars(base64_decode($action['reason'])).'" placeholder="'.$dl->getLocalizedString("banReason").'">
			</div>
			<div class="field">
				<input type="datetime-local" name="expires" value="'.date('Y-m-d\TH:i:s', $action['expires']).'" min="'.(new DateTime())->format('Y-m-d\TH:i:s').'" placeholder="'.$dl->getLocalizedString("expires").'">
			</div>
			<div class="banbuttons">
				<input type="hidden" name="changeBan" id="changeBan'.$action['banID'].'" value="0"></input>
				<input type="hidden" name="unban" id="unban'.$action['banID'].'" value="0"></input>
				<input type="hidden" name="banID" value="'.$action['banID'].'"></input>
				<button type="button" onclick="{
					document.getElementById(\'changeBan'.$action['banID'].'\').value = 1; // Yes, i know, that this is shit. It doesnt work with <script> for some reason. 
					document.getElementById(\'unban'.$action['banID'].'\').value = 0;
					a(\'stats/banList.php\', true, true, \'POST\', false, \'banForm'.$action['banID'].'\');
				}" class="btn-song">'.$dl->getLocalizedString("change").'</button>
				<button style="width: 80%;" type="button" onclick="{
					document.getElementById(\'changeBan'.$action['banID'].'\').value = 0;
					document.getElementById(\'unban'.$action['banID'].'\').value = 1;
					a(\'stats/banList.php\', true, true, \'POST\', false, \'banForm'.$action['banID'].'\');
				}" class="btn-song">'.$dl->getLocalizedString("unbanPerson").'</button>
			</div>
		</form>
	</div>';
	$bans .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
		<div class="profile">
			<div class="bantitle">
				<div class="acclistdiv banusernamediv">
					'.$personText.$manage.'
				</div>
				<p class="clandesc">'.$reason.'</p>
			</div>
			<div class="form-control song-info" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div class="acccomments"><h3 class="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("ID").': <b>'.$action['banID'].'</b></h3><h3 class="comments" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$dl->convertToDate($action['timestamp'], true).'</b></h3></div>
		</div>
	</div>';
	$x++;
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("banList").'</h1>
<div class="form-control new-form-control">
		'.$bans.'
	</div></div><form name="searchform" class="form__inner">
</form>';
$dl->printPage($pagel, true, "mod");
?>