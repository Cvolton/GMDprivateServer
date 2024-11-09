<?php
session_start();
require "../incl/dashboardLib.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."incl/lib/automod.php";
$dl = new dashboardLib();
$gs = new mainLib();
$dl->title($dl->getLocalizedString("automodTitle"));
$dl->printFooter('../');
if(!$gs->checkPermission($_SESSION["accountID"], "dashboardManageAutomod")) {
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
		</form>
	</div>', 'mod'));
}
if($_POST['resolve'] == 1) {
	$actionID = ExploitPatch::number($_POST['actionID']);
	$action = Automod::getAutomodActionByID($actionID);
	if($action && !$action['resolved']) Automod::changeAutomodAction($actionID, 1);
}
if(isset($_POST['disableType'])) {
	$disableType = ExploitPatch::number($_POST['disableType']);
	$expires = (new DateTime($_POST['expires']))->getTimestamp();
	switch(true) {
		case isset($_POST['levels']):
			$isDisable = $_POST['levels'] == 1;
			if($expires > time() || !$isDisable) Automod::changeLevelsAutomodState($disableType, $isDisable, $expires);
			break;
		case isset($_POST['accounts']):
			$isDisable = $_POST['accounts'] == 1;
			if($expires > time() || !$isDisable) Automod::changeAccountsAutomodState($disableType, $isDisable, $expires);
			break;
	}
}
$actions = Automod::getAutomodActions();
$actionTypes = Automod::getAutomodTypes();
$actionsDiv = '';
foreach($actions AS &$actionValue) {
	$actionType = $actionTypes[$actionValue['type']];
	$actionButtons = $actionDesc = $spammerUsername = '';
	switch($actionType) {
		case 1:
			$actionTitle = $dl->getLocalizedString('possibleLevelsSpamming');
			$actionButtonsText = $dl->getLocalizedString('disableLevelsUploading');
			$openTabFunction = 'openLevelsDisableTab(0, '.$actionValue['ID'].')';
			break;
		case 2:
			$actionTitle = $dl->getLocalizedString('possibleAccountsSpamming');
			$actionButtonsText = $dl->getLocalizedString('disableAccountsRegistering');
			$openTabFunction = 'openAccountsDisableTab(0, '.$actionValue['ID'].')';
			break;
		case 3:
			$actionTitle = $dl->getLocalizedString('possibleCommentsSpamming');
			$actionButtonsText = $dl->getLocalizedString('disableCommenting');
			$actionDesc = '<div class="attribute-divs">
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarCommentsCount').'">
					<i class="fa-solid fa-comments"></i> '.$actionValue['value1'].'
				</div>
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarityValueOfAllComments').'">
					<i class="fa-solid fa-equals"></i> '.$actionValue['value2'].' / '.$actionValue['value3'].'
				</div>
			</div>';
			$openTabFunction = 'openLevelsDisableTab(1, '.$actionValue['ID'].')';
			break;
		case 4:
			$actionTitle = $dl->getLocalizedString('possibleCommentsSpammer');
			$actionButtonsText = $dl->getLocalizedString('banCommenting');
			$spammerUsername = $gs->getUserName($actionValue['value4']);
			$actionDesc = '<div class="attribute-divs">
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarCommentsCount').'">
					<i class="fa-solid fa-comments"></i> '.$actionValue['value1'].'
				</div>
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarityValueOfAllComments').'">
					<i class="fa-solid fa-equals"></i> '.$actionValue['value2'].' / '.$actionValue['value3'].'
				</div>
				<div class="attribute-div attribute-button" title="'.$dl->getLocalizedString('spammerUsername').'" onclick="a(\'profile/'.$spammerUsername.'\', true, true)">
					<i class="fa-solid fa-user-secret"></i> '.$spammerUsername.'
				</div>
			</div>';
			$openTabFunction = 'a(\'account/banPerson.php?person='.urlencode($actionValue['value4']).'&personType=1&banType=3\', true, true, \'GET\')';
			break;
		case 5:
			$actionTitle = $dl->getLocalizedString('possibleAccountPostsSpamming');
			$actionButtonsText = $dl->getLocalizedString('disablePosting');
			$actionDesc = '<div class="attribute-divs">
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarPostsCount').'">
					<i class="fa-solid fa-comments"></i> '.$actionValue['value1'].'
				</div>
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarityValueOfAllPosts').'">
					<i class="fa-solid fa-equals"></i> '.$actionValue['value2'].' / '.$actionValue['value3'].'
				</div>
			</div>';
			$openTabFunction = 'openAccountsDisableTab(1, '.$actionValue['ID'].')';
			break;
		case 6:
			$actionTitle = $dl->getLocalizedString('possibleAccountPostsSpammer');
			$actionButtonsText = $dl->getLocalizedString('banCommenting');
			$spammerUsername = $gs->getUserName($actionValue['value4']);
			$actionDesc = '<div class="attribute-divs">
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarPostsCount').'">
					<i class="fa-solid fa-comments"></i> '.$actionValue['value1'].'
				</div>
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarityValueOfAllPosts').'">
					<i class="fa-solid fa-equals"></i> '.$actionValue['value2'].' / '.$actionValue['value3'].'
				</div>
				<div class="attribute-div attribute-button" title="'.$dl->getLocalizedString('spammerUsername').'" onclick="a(\'profile/'.$spammerUsername.'\', true, true)">
					<i class="fa-solid fa-user-secret"></i> '.$spammerUsername.'
				</div>
			</div>';
			$openTabFunction = 'a(\'account/banPerson.php?person='.urlencode($actionValue['value4']).'&personType=1&banType=3\', true, true, \'GET\')';
			break;
		case 7:
			$actionTitle = $dl->getLocalizedString('possibleRepliesSpamming');
			$actionButtonsText = $dl->getLocalizedString('disablePosting');
			$actionDesc = '<div class="attribute-divs">
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarRepliesCount').'">
					<i class="fa-solid fa-comments"></i> '.$actionValue['value1'].'
				</div>
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarityValueOfAllReplies').'">
					<i class="fa-solid fa-equals"></i> '.$actionValue['value2'].' / '.$actionValue['value3'].'
				</div>
			</div>';
			$openTabFunction = 'openAccountsDisableTab(1, '.$actionValue['ID'].')';
			break;
		case 8:
			$actionTitle = $dl->getLocalizedString('possibleRepliesSpammer');
			$actionButtonsText = $dl->getLocalizedString('banCommenting');
			$spammerUsername = $gs->getAccountName($actionValue['value4']);
			$actionDesc = '<div class="attribute-divs">
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarRepliesCount').'">
					<i class="fa-solid fa-comments"></i> '.$actionValue['value1'].'
				</div>
				<div class="attribute-div" title="'.$dl->getLocalizedString('similarityValueOfAllReplies').'">
					<i class="fa-solid fa-equals"></i> '.$actionValue['value2'].' / '.$actionValue['value3'].'
				</div>
				<div class="attribute-div attribute-button" title="'.$dl->getLocalizedString('spammerUsername').'" onclick="a(\'profile/'.$spammerUsername.'\', true, true)">
					<i class="fa-solid fa-user-secret"></i> '.$spammerUsername.'
				</div>
			</div>';
			$openTabFunction = 'a(\'account/banPerson.php?person='.urlencode($actionValue['value4']).'&personType=0&banType=3\', true, true, \'GET\')';
			break;
		default:
			$actionTitle = $dl->getLocalizedString('unknownWarning');
			$actionButtons = '<button style="height: max-content;" class="btn-rendel btn-block" type="button" disabled>'.$dl->getLocalizedString('unknownWarning').'</button>';
			$actionDesc = '<div class="attribute-divs">
				<div class="attribute-div" title="Value 1">
					<i class="fa-solid fa-1"></i> '.$actionValue['value1'].'
				</div>
				<div class="attribute-div" title="Value 2">
					<i class="fa-solid fa-2"></i> '.$actionValue['value2'].'
				</div>
				<div class="attribute-div" title="Value 3">
					<i class="fa-solid fa-3"></i> '.$actionValue['value3'].'
				</div>
			</div>
			<div style="margin-top: 10px;" class="attribute-divs">
				<div class="attribute-div" title="Value 4">
					<i class="fa-solid fa-4"></i> '.$actionValue['value4'].'
				</div>
				<div class="attribute-div" title="Value 5">
					<i class="fa-solid fa-5"></i> '.$actionValue['value5'].'
				</div>
				<div class="attribute-div" title="Value 6">
					<i class="fa-solid fa-6"></i> '.$actionValue['value6'].'
				</div>
			</div>';
			break;
	}
	if(empty($actionDesc)) {
		if(empty($actionValue['value1'])) $actionCompare = '∞';
		else $actionCompare = ceil($actionValue['value2'] / $actionValue['value1'] * 10) / 10;
		$actionDesc = '<div class="attribute-divs">
			<div class="attribute-div" title="'.$dl->getLocalizedString('before').'">
				<i class="fa-solid fa-clock-rotate-left"></i> '.$actionValue['value1'].'
			</div>
			<div class="attribute-div" title="'.$dl->getLocalizedString('after').'">
				<i class="fa-solid fa-clock"></i> '.$actionValue['value2'].'
			</div>
			<div class="attribute-div" title="'.$dl->getLocalizedString('compare').'">
				<i class="fa-solid fa-chart-line"></i> x'.$actionCompare.'
			</div>
		</div>';
	}
	if(empty($actionButtons)) {
		if($actionValue['resolved']) $actionButtons = '<button style="height: max-content;" class="btn-rendel btn-block" type="button" disabled>'.$dl->getLocalizedString('resolvedWarning').'</button>';
		else $actionButtons = '<button class="btn-rendel btn-success" type="button" onclick="a(\'automod\', true, false, \'POST\', false, \'actionResolve'.$actionValue['ID'].'\')">'.$dl->getLocalizedString('resolveWarning').'</button>
			<form name="actionResolve'.$actionValue['ID'].'" style="display: none">
				<input type="hidden" name="actionID" value="'.$actionValue['ID'].'"></input>
				<input type="hidden" name="resolve" value="1"></input>
				<input type="hidden" name="actionType" value="'.$actionType.'"></input>
			</form>
			<button class="btn-rendel btn-size" type="button" onclick="'.$openTabFunction.'">'.$actionButtonsText.'</button>';
	}
	$actionsDiv .= '<div class="profile"> 
		<div class="acclistdiv banusernamediv">
			<h2 class="profilenick acclistnick" style="margin: 0px;">'.$actionTitle.'</h2>
		</div>
		<div class="clandesc no-scroll">
			<p>'.$actionDesc.'</p>
		</div>
		<div class="btns">
			'.$actionButtons.'
		</div>
	</div>';
}
if(empty($actionsDiv)) $actionsDiv = '<div class="empty-section">
	<i class="fa-solid fa-triangle-exclamation"></i>
	<p>'.$dl->getLocalizedString('noWarnings').'</p>
</div>';
$levelsCount = Automod::getLevelsCountPerDay();
if(empty($levelsCount['yesterday'])) $levelsCountCompare = '∞';
else $levelsCountCompare = ceil(($levelsCount['today'] / $levelsCount['yesterday']) * 1000) / 10 .'%';
$levelsDisableTimes = Automod::getLevelsDisableStates();
$levelsUploadingState = empty($levelsDisableTimes[0]) ? 'enabled' : 'disabled';
$levelsCommentingState = empty($levelsDisableTimes[1]) ? 'enabled' : 'disabled';
$levelsLeaderboardSubmitsState = empty($levelsDisableTimes[2]) ? 'enabled' : 'disabled';
$accountsCount = Automod::getAccountsCountPerDay();
if(empty($accountsCount['yesterday'])) $accountsCountCompare = '∞';
else $accountsCountCompare = ceil(($accountsCount['today'] / $accountsCount['yesterday']) * 1000) / 10 .'%';
$accountsDisableTimes = Automod::getAccountsDisableStates();
$accountRegisteringState = empty($accountsDisableTimes[0]) ? 'enabled' : 'disabled';
$accountPostingState = empty($accountsDisableTimes[1]) ? 'enabled' : 'disabled';
$accountStatsUpdatingState = empty($accountsDisableTimes[2]) ? 'enabled' : 'disabled';
$accountMessagingState = empty($accountsDisableTimes[3]) ? 'enabled' : 'disabled';
$dl->printPage('<div class="form new-form automod-form">
	<h1>'.$dl->getLocalizedString("automodTitle").'</h1>
	<div class="automod-boxes">
		<div class="form-control new-form-control">
			'.$actionsDiv.'
		</div>
		<div class="form-control new-form-control">
			<div class="profile"> 
				<div class="acclistdiv banusernamediv">
					<h2 class="profilenick acclistnick" style="margin: 0px;">'.$dl->getLocalizedString('levels').'</h2>
				</div>
				<div class="clandesc no-scroll attributes">
					<div class="attribute-divs">
						<div class="attribute-div" title="'.$dl->getLocalizedString('yesterday').'">
							<i class="fa-solid fa-clock-rotate-left"></i> '.$levelsCount['yesterday'].'
						</div>
						<div class="attribute-div" title="'.$dl->getLocalizedString('today').'">
							<i class="fa-solid fa-clock"></i> '.$levelsCount['today'].'
						</div>
						<div class="attribute-div" title="'.$dl->getLocalizedString('compare').'">
							<i class="fa-solid fa-chart-line"></i> '.$levelsCountCompare.'
						</div>
					</div>
					<div class="attribute-divs text">
						<div class="attribute-div">
							<i class="fa-solid fa-gamepad"></i> <text>'.$dl->getLocalizedString('uploading').'</text>
						</div>
						<div class="attribute-div attribute-button '.$levelsUploadingState.'" onclick="openLevelsDisableTab(0)">
							<text>'.$dl->getLocalizedString($levelsUploadingState).'</text>
						</div>
					</div>
					<div class="attribute-divs text">
						<div class="attribute-div">
							<i class="fa-solid fa-comments"></i> <text>'.$dl->getLocalizedString('commenting').'</text>
						</div>
						<div class="attribute-div attribute-button '.$levelsCommentingState.'" onclick="openLevelsDisableTab(1)">
							<text>'.$dl->getLocalizedString($levelsCommentingState).'</text>
						</div>
					</div>
					<div class="attribute-divs text">
						<div class="attribute-div">
							<i class="fa-solid fa-ranking-star"></i> <text>'.$dl->getLocalizedString('leaderboardSubmits').'</text>
						</div>
						<div class="attribute-div attribute-button '.$levelsLeaderboardSubmitsState.'" onclick="openLevelsDisableTab(2)">
							<text>'.$dl->getLocalizedString($levelsLeaderboardSubmitsState).'</text>
						</div>
					</div>
				</div>
				<div class="btns">
					<button class="invisible" type="button" id="dropdownLevels" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"></button>
					<button onclick="openLevelsDisableTab(0)" class="btn-rendel" type="button">'.$dl->getLocalizedString('manageLevels').'</button>
					<div id="dropdownLevelsDiv" onclick="event.stopPropagation()" class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownLevels"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;will-change: transform;">
					<form class="form__inner" method="post" name="levelsForm">
						<div class="field">
							<select name="disableType" id="levelsDisableType">
								<option value="0">'.$dl->getLocalizedString('disableLevelsUploading').'</option>
								<option value="1">'.$dl->getLocalizedString('disableLevelsCommenting').'</option>
								<option value="2">'.$dl->getLocalizedString('disableLevelsLeaderboardSubmits').'</option>
							</select>
						</div>
						<div class="field">
							<input id="levelsDatetimeInput" type="datetime-local" value="'.$levelsDisableTimes[0].'" name="expires" min="'.(new DateTime())->format('Y-m-d\TH:i:s').'" placeholder="'.$dl->getLocalizedString("expires").'">
						</div>
						<input type="hidden" id="levelsResolveInput" name="resolve" value="0"></input>
						<input type="hidden" id="levelsActionIDInput" name="actionID" value="0"></input>
						<div class="banbuttons">
							<input type="hidden" name="levels" value="1" id="levelsIsDisable"></input>
							<button type="button" class="btn-song" onclick="disableLevels(1)" >'.$dl->getLocalizedString("disable").'</button>
							<button type="button" style="width: 80%" class="btn-song" onclick="disableLevels(0)" >'.$dl->getLocalizedString("enable").'</button>
						</div>
					</form>
				</div>
				</div>
			</div>
			
			<div class="profile"> 
				<div class="acclistdiv banusernamediv">
					<h2 class="profilenick acclistnick" style="margin: 0px;">'.$dl->getLocalizedString('accounts').'</h2>
				</div>
				<div class="clandesc no-scroll attributes">
					<div class="attribute-divs">
						<div class="attribute-div" title="'.$dl->getLocalizedString('yesterday').'">
							<i class="fa-solid fa-clock-rotate-left"></i> '.$accountsCount['yesterday'].'
						</div>
						<div class="attribute-div" title="'.$dl->getLocalizedString('today').'">
							<i class="fa-solid fa-clock"></i> '.$accountsCount['today'].'
						</div>
						<div class="attribute-div" title="'.$dl->getLocalizedString('compare').'">
							<i class="fa-solid fa-chart-line"></i> '.$accountsCountCompare.'
						</div>
					</div>
					<div class="attribute-divs text">
						<div class="attribute-div">
							<i class="fa-solid fa-user-plus"></i> <text>'.$dl->getLocalizedString('registering').'</text>
						</div>
						<div class="attribute-div attribute-button '.$accountRegisteringState.'" onclick="openAccountsDisableTab(0)">
							<text>'.$dl->getLocalizedString($accountRegisteringState).'</text>
						</div>
					</div>
					<div class="attribute-divs text">
						<div class="attribute-div">
							<i class="fa-solid fa-comment-dots"></i> <text>'.$dl->getLocalizedString('accountPosting').'</text>
						</div>
						<div class="attribute-div attribute-button '.$accountPostingState.'" onclick="openAccountsDisableTab(1)">
							<text>'.$dl->getLocalizedString($accountPostingState).'</text>
						</div>
					</div>
					<div class="attribute-divs text">
						<div class="attribute-div">
							<i class="fa-solid fa-star"></i> <text>'.$dl->getLocalizedString('updatingProfileStats').'</text>
						</div>
						<div class="attribute-div attribute-button '.$accountStatsUpdatingState.'" onclick="openAccountsDisableTab(2)">
							<text>'.$dl->getLocalizedString($accountStatsUpdatingState).'</text>
						</div>
					</div>
					<div class="attribute-divs text">
						<div class="attribute-div">
							<i class="fa-solid fa-message"></i> <text>'.$dl->getLocalizedString('messaging').'</text>
						</div>
						<div class="attribute-div attribute-button '.$accountMessagingState.'" onclick="openAccountsDisableTab(3)">
							<text>'.$dl->getLocalizedString($accountMessagingState).'</text>
						</div>
					</div>
				</div>
				<div class="btns">
					<button class="invisible" type="button" id="dropdownAccounts" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"></button>
					<button onclick="openAccountsDisableTab(0)" class="btn-rendel" type="button">'.$dl->getLocalizedString('manageAccounts').'</button>
					<div id="dropdownAccountsDiv" onclick="event.stopPropagation()" class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownAccounts"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;will-change: transform;">
					<form class="form__inner" method="post" name="accountsForm">
						<div class="field">
							<select name="disableType" id="accountsDisableType">
								<option value="0">'.$dl->getLocalizedString('disableAccountsRegistering').'</option>
								<option value="1">'.$dl->getLocalizedString('disableAccountPosting').'</option>
								<option value="2">'.$dl->getLocalizedString('disableUpdatingProfileStats').'</option>
								<option value="3">'.$dl->getLocalizedString('disableMessaging').'</option>
							</select>
						</div>
						<div class="field">
							<input id="accountsDatetimeInput" type="datetime-local" value="'.$accountsDisableTimes[0].'" name="expires" min="'.(new DateTime())->format('Y-m-d\TH:i:s').'" placeholder="'.$dl->getLocalizedString("expires").'">
						</div>
						<input type="hidden" id="accountsResolveInput" name="resolve" value="0"></input>
						<input type="hidden" id="accountsActionIDInput" name="actionID" value="0"></input>
						<div class="banbuttons">
							<input type="hidden" name="accounts" value="1" id="accountsIsDisable"></input>
							<button type="button" class="btn-song" onclick="disableAccounts(1)" >'.$dl->getLocalizedString("disable").'</button>
							<button type="button" style="width: 80%" class="btn-song" onclick="disableAccounts(0)" >'.$dl->getLocalizedString("enable").'</button>
						</div>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	levelsDisableTimes = ["'.$levelsDisableTimes[0].'", "'.$levelsDisableTimes[1].'", "'.$levelsDisableTimes[2].'"];
	accountsDisableTimes = ["'.$accountsDisableTimes[0].'", "'.$accountsDisableTimes[1].'", "'.$accountsDisableTimes[2].'", "'.$accountsDisableTimes[3].'"];
	document.getElementById("levelsDisableType").addEventListener("change", event => {
		document.getElementById("levelsDatetimeInput").value = levelsDisableTimes[event.target.value];
	});
	function disableLevels(isDisable) {
		document.getElementById("levelsIsDisable").value = isDisable;
		a(\'automod\', true, false, \'POST\', false, \'levelsForm\');
	}
	function openLevelsDisableTab(disableType, actionID = 0) {
		document.getElementById("levelsDisableType").value = disableType;
		document.getElementById("levelsDatetimeInput").value = levelsDisableTimes[disableType];
		handleLevelsActionIDs(disableType, actionID);
		if(!document.getElementById("dropdownLevelsDiv").classList.contains("show")) document.getElementById("dropdownLevels").click();
		event.stopPropagation();
	}
	function handleLevelsActionIDs(disableType, actionID) {
		document.getElementById("levelsActionIDInput").value = actionID;
		document.getElementById("levelsResolveInput").value = actionID == 0 ? 0 : 1;
	}
	document.getElementById("accountsDisableType").addEventListener("change", event => {
		document.getElementById("accountsDatetimeInput").value = accountsDisableTimes[event.target.value];
	});
	function disableAccounts(isDisable) {
		document.getElementById("accountsIsDisable").value = isDisable;
		a(\'automod\', true, false, \'POST\', false, \'accountsForm\');
	}
	function openAccountsDisableTab(disableType, actionID = 0) {
		document.getElementById("accountsDisableType").value = disableType;
		document.getElementById("accountsDatetimeInput").value = accountsDisableTimes[disableType];
		handleAccountsActionIDs(disableType, actionID);
		if(!document.getElementById("dropdownAccountsDiv").classList.contains("show")) document.getElementById("dropdownAccounts").click();
		event.stopPropagation();
	}
	function handleAccountsActionIDs(disableType, actionID) {
		document.getElementById("accountsActionIDInput").value = actionID;
		document.getElementById("accountsResolveInput").value = actionID == 0 ? 0 : 1;
	}
</script>', 'mod');
?>