<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("vaultCodesTitle"));
$dl->printFooter('../');
$allVaultCodes = $vaultCodeName = $vaultCodeRewards = $vaultCodeUses = $vaultCodeDuration = '';
if(isset($_GET['rewardID']) && !isset($_POST['rewardID'])) $_POST['rewardID'] = $_GET['rewardID'];
if(!$gs->checkPermission($_SESSION["accountID"], "dashboardVaultCodesManage")) exit($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
	<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod'));
if(isset($_POST['vaultCodeName']) && isset($_POST['vaultCodeRewards'])) {
	if(!Captcha::validateCaptcha()) exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
		<button type="button" onclick="a(\'levels/vaultCodes.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'mod'));
	$vaultCodeName = base64_encode(trim(ExploitPatch::rucharclean($_POST['vaultCodeName'])));
	$vaultCodeRewards = ExploitPatch::numbercolon($_POST['vaultCodeRewards']);
	$vaultCodeUses = $_POST['vaultCodeUses'] > 0 ? ExploitPatch::number($_POST['vaultCodeUses']) : '-1';
	$vaultCodeDuration = !empty($_POST['vaultCodeDuration']) ? (new DateTime($_POST['vaultCodeDuration']))->getTimestamp() : 0;
	if(empty($_POST['rewardID'])) {
		$checkName = $db->prepare('SELECT count(*) FROM vaultcodes WHERE code LIKE :code');
		$checkName->execute([':code' => $vaultCodeName]);
		$checkName = $checkName->fetchColumn();
		if($checkName) exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("vaultCodeExists").'</p>
			<button type="button" onclick="a(\'levels/vaultCodes.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
		$insertCode = $db->prepare('INSERT INTO vaultcodes (code, rewards, duration, uses, timestamp) VALUES (:code, :rewards, :duration, :uses, :timestamp)');
		$insertCode->execute([':code' => $vaultCodeName, ':rewards' => $vaultCodeRewards, ':duration' => $vaultCodeDuration, ':uses' => $vaultCodeUses, ':timestamp' => time()]);
		$rewardID = $db->lastInsertId();
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value4, value5, value6, timestamp, account) VALUES ('42', :value, :value2, :value4, :value5, :value6, :timestamp, :accountID)");
		$query->execute([':value' => $vaultCodeName, ':value2' => $vaultCodeRewards, ':value4' => $vaultCodeDuration, ':value5' => $vaultCodeUses, ':value6' => $rewardID, ':timestamp' => time(), ':accountID' => $_SESSION['accountID']]);
		$rewardID = $vaultCodeName = $vaultCodeRewards = $vaultCodeUses = $vaultCodeDuration = '';
	} else {
		$rewardID = ExploitPatch::number($_POST['rewardID']);
		$checkName = $db->prepare('SELECT count(*) FROM vaultcodes WHERE code LIKE :code AND rewardID != :rewardID');
		$checkName->execute([':code' => $vaultCodeName, ':rewardID' => $rewardID]);
		$checkName = $checkName->fetchColumn();
		if($checkName) exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("vaultCodeExists").'</p>
			<button type="button" onclick="a(\'levels/vaultCodes.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
		$insertCode = $db->prepare('UPDATE vaultcodes SET code = :code, rewards = :rewards, duration = :duration, uses = :uses WHERE rewardID = :rewardID');
		$insertCode->execute([':code' => $vaultCodeName, ':rewards' => $vaultCodeRewards, ':duration' => $vaultCodeDuration, ':uses' => $vaultCodeUses, ':rewardID' => $rewardID]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value4, value5, value6, timestamp, account) VALUES ('43', :value, :value2, :value4, :value5, :value6, :timestamp, :accountID)");
		$query->execute([':value' => $vaultCodeName, ':value2' => $vaultCodeRewards, ':value4' => $vaultCodeDuration, ':value5' => $vaultCodeUses, ':value6' => $rewardID, ':timestamp' => time(), ':accountID' => $_SESSION['accountID']]);
	}
}
if(!empty($_POST['rewardID'])) {
	$rewardID = ExploitPatch::number($_POST['rewardID']);
	$getVaultCode = $db->prepare('SELECT * FROM vaultcodes WHERE rewardID = :rewardID');
	$getVaultCode->execute([':rewardID' => $rewardID]);
	$getVaultCode = $getVaultCode->fetch();
	if($getVaultCode) {
		$vaultCodeName = htmlspecialchars(base64_decode($getVaultCode['code']));
		$vaultCodeUses = $getVaultCode['uses'];
		$vaultCodeRewards = $getVaultCode['rewards'];
		$vaultCodeDuration = !empty($getVaultCode['duration']) ? date('Y-m-d\TH:i:s', $getVaultCode['duration']) : '';
	}
}
$rewardTypes = $gs->getRewardTypes();
$vaultCodes = $db->prepare("SELECT * FROM vaultcodes ORDER BY rewardID ASC");
$vaultCodes->execute();
$vaultCodes = $vaultCodes->fetchAll();
foreach($vaultCodes as &$vaultCode) {
	$allVaultCodes .= '<button type="submit" onclick="vaultCode('.$vaultCode["rewardID"].')" class="btn-primary itembtn" id="button'.$vaultCode["rewardID"].'">
		<h2 class="subjectnotyou" id="name'.$vaultCode["rewardID"].'"><text id="vcname'.$vaultCode["rewardID"].'">'.base64_decode($vaultCode["code"]).'</text> <i style="opacity:0;transition:0.2s; margin-right: 10px; color: white; font-size: 13px;" id="spin'.$vaultCode["rewardID"].'" class="fa-solid fa-spinner fa-spin"></i></h2>
		<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;" id="stats'.$vaultCode["rewardID"].'">
			<span class="no-warp" title="'.$dl->getLocalizedString('expires').'"><i class="fa-solid fa-clock"></i> '.$dl->convertToDate($vaultCode["duration"], true).'</span> • 
			<span class="no-warp" title="'.$dl->getLocalizedString('date').'"><i class="fa-regular fa-clock"></i> '.$dl->convertToDate($vaultCode["timestamp"], true).'</span>
		</h2>
	</button>';
}
$rewardTypesOptions = '<option id="vault_code_type_option0" value="0">'.$dl->getLocalizedString('vaultCodePickOption').'</option>';
foreach($rewardTypes AS $rewardType => $rewardText) {
	if(empty($rewardText)) continue;
	$rewardTypesOptions .= '<option id="vault_code_type_option'.$rewardType.'" value="'.$rewardType.'">'.$rewardText.'</option>';
}
$dl->printSong('<div class="form-control itemsbox chatdiv">
	<div class="itemoverflow cards-overflow">
		<div class="itemslist">
		<button type="submit" onclick="vaultCode(0)" class="btn-primary itembtn">
				<h2 class="subjectnotyou">'.$dl->getLocalizedString("vaultCodesCreate").'</h2>
				<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;">'.$dl->getLocalizedString("createNewVaultCode").'</h2>
			</button>'.$allVaultCodes.'
		</div>
	</div>
	<div class="form cards-form" style="position: relative;">
		<h1>'.$dl->getLocalizedString((!empty($rewardID) ? 'vaultCodesEditTitle' : 'vaultCodesTitle')).'</h1>
		<form class="form__inner form__create" method="post" action="" name="vaultCodesForm">
			<p>'.$dl->getLocalizedString((!empty($rewardID) ? 'vaultCodesEditDesc' : 'vaultCodesDesc')).'</p>
			<input id="vaultCodeRewardID" name="rewardID" '.(!empty($rewardID) ? 'value="'.$rewardID.'"' : '').' type="hidden">
			<div class="field">
				<input id="vaultCodeName" value="'.$vaultCodeName.'" name="vaultCodeName" type="string" placeholder="'.$dl->getLocalizedString("vaultCodeName").'">
			</div>
			<button class="btn-primary" type="button" onclick="showRewards()">'.$dl->getLocalizedString('editRewards').'</button>
			<div class="rewards-div" id="rewards-div">
				<div class="h1-with-close">
					<button class="only-icon-button" type="button" onclick="addReward()"><i class="fa-solid fa-plus"></i></button>
					<h1>'.$dl->getLocalizedString('rewards').'</h1>
					<button class="only-icon-button" type="button" onclick="showRewards()"><i class="fa-solid fa-xmark"></i></button>
				</div>
				<div class="field" style="grid-gap: 5px; display: flex;">
					<select name="vaultCodeType" id="vaultCodeType" style="margin: 0px;">
						'.$rewardTypesOptions.'
					</select>
					<input name="vaultCodeReward" id="vaultCodeReward" type="number" placeholder="'.$dl->getLocalizedString('reward').'">
				</div>
			</div>
			<div class="field" style="grid-gap: 5px;">
				<input id="vaultCodeUses" value="'.$vaultCodeUses.'" name="vaultCodeUses" type="number" placeholder="'.$dl->getLocalizedString('vaultCodeUses').'">
				<input type="datetime-local" value="'.$vaultCodeDuration.'" name="vaultCodeDuration" min="'.(new DateTime())->format('Y-m-d\TH:i:s').'" title="'.$dl->getLocalizedString("expires").'">
			</div>
			<input type="hidden" name="vaultCodeRewards" id="vaultCodeRewards"></input>
			'.Captcha::displayCaptcha(true).'
			<button type="button" onclick="submitReward()" class="btn-primary" id="vaultCodesSubmit">'.$dl->getLocalizedString("vaultCodesCreate").'</button>
		</form>
		<form id="vaultCodesCustomForm" name="vaultCodesCustomForm">
			<input id="rewardID" name="rewardID" type="hidden">
		</form>
	</div>
</div>
<script>
'.(!empty($rewardID) ? 'document.getElementById("button'.$rewardID.'").scrollIntoView();' : '').'
var rewardsCount = 1;
function vaultCode(rewardID) {
	document.getElementById("rewardID").value = rewardID;
	a(\'levels/vaultCodes.php\', true, true, \'POST\', false, \'vaultCodesCustomForm\');
}
function showRewards() {
	document.getElementById("rewards-div").classList.toggle("show");
}
function addReward(type = 0, reward = "") {
	rewardsCount++;
	div = document.createElement("div");
	div.classList = "field";
	div.id = "rewardField" + rewardsCount;
	div.style = "grid-gap: 5px; display: flex;";
	div.innerHTML = `<select value=\'0\' id=\'vaultCodeType` + rewardsCount + `\' name=\'vaultCodeType\' style=\'margin: 0px;\'>
			'.$rewardTypesOptions.'
		</select>
		<input id=\'vaultCodeReward` + rewardsCount + `\' name=\'vaultCodeReward\' type=\'number\' value=\'` + reward + `\' placeholder=\''.$dl->getLocalizedString('reward').'\'>
		<button class=\'only-icon-button\' type=\'button\' onclick=\'deleteReward(` + rewardsCount + `)\'><i class=\'fa-solid fa-trash\'></i></button>`;
	document.getElementById("rewards-div").appendChild(div);
	document.getElementById("vaultCodeType" + rewardsCount).value = type;
}
function deleteReward(reward) {
	document.getElementById("rewardField" + reward).remove();
}
function submitReward() {
	var rewardTypes = document.querySelectorAll("[name=vaultCodeType]");
	var rewards = document.querySelectorAll("[name=vaultCodeReward]");
	if(rewardTypes.length != rewards.length) return;
	var i = 0;
	var rewardsArray = [];
	for(i = 0; i < rewards.length; i++) {
		rewardType = rewardTypes[i].value;
		reward = rewards[i].value;
		if(rewardType == 0 || reward.trim().length == 0) continue;
		rewardsArray.push(rewardType + "," + reward); 
	}
	rewardsText = rewardsArray.join(",");
	document.getElementById("vaultCodeRewards").value = rewardsText;
	a(\'levels/vaultCodes.php\', true, true, \'POST\', false, \'vaultCodesForm\');
}
function recreateRewards(rewards) {
	rewardsArray = rewards.split(",");
	if(rewardsArray.length % 2 != 0) return;
	var i = 0;
	for(i = 0; i < rewardsArray.length;) {
		if(i + 1 >= rewardsArray.length) break;
		if(i == 0) {
			document.getElementById("vaultCodeType").value = rewardsArray[i];
			document.getElementById("vaultCodeReward").value = rewardsArray[i + 1];
		} else addReward(rewardsArray[i], rewardsArray[i + 1]);
		i = i + 2; // If i add i + 2 to for(), it will create fucking memory leak in browser???
	}
}
'.(!empty($vaultCodeRewards) ? 'recreateRewards("'.$vaultCodeRewards.'");' : '').'
</script>', 'mod');
?>