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
$allVaultCodes = $vaultCodeName = $vaultCodeType = $vaultCodeReward = $vaultCodeUses = $vaultCodeDuration = '';
if(!$gs->checkPermission($_SESSION["accountID"], "dashboardVaultCodesManage")) exit($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
	<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod'));
if(isset($_POST['vaultCodeName']) && isset($_POST['vaultCodeType']) && isset($_POST['vaultCodeReward'])) {
	if(!Captcha::validateCaptcha()) exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
		<button type="button" onclick="a(\'levels/vaultCodes.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'mod'));
	$vaultCodeName = base64_encode(trim(ExploitPatch::rucharclean($_POST['vaultCodeName'])));
	$vaultCodeType = ExploitPatch::number($_POST['vaultCodeType']);
	$vaultCodeReward = ExploitPatch::number($_POST['vaultCodeReward']) ?: 7;
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
		$insertCode = $db->prepare('INSERT INTO vaultcodes (code, type, reward, duration, uses, timestamp) VALUES (:code, :type, :reward, :duration, :uses, :timestamp)');
		$insertCode->execute([':code' => $vaultCodeName, ':type' => $vaultCodeType, ':reward' => $vaultCodeReward, ':duration' => $vaultCodeDuration, ':uses' => $vaultCodeUses, ':timestamp' => time()]);
		$rewardID = $db->lastInsertId();
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, value4, value5, value6, timestamp, account) VALUES ('42', :value, :value2, :value3, :value4, :value5, :value6, :timestamp, :accountID)");
		$query->execute([':value' => $vaultCodeName, ':value2' => $vaultCodeType, ':value3' => $vaultCodeReward, ':value4' => $vaultCodeDuration, ':value5' => $vaultCodeUses, ':value6' => $rewardID, ':timestamp' => time(), ':accountID' => $_SESSION['accountID']]);
		$rewardID = $vaultCodeName = $vaultCodeType = $vaultCodeReward = $vaultCodeUses = $vaultCodeDuration = '';
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
		$insertCode = $db->prepare('UPDATE vaultcodes SET code = :code, type = :type, reward = :reward, duration = :duration, uses = :uses WHERE rewardID = :rewardID');
		$insertCode->execute([':code' => $vaultCodeName, ':type' => $vaultCodeType, ':reward' => $vaultCodeReward, ':duration' => $vaultCodeDuration, ':uses' => $vaultCodeUses, ':rewardID' => $rewardID]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, value4, value5, value6, timestamp, account) VALUES ('43', :value, :value2, :value3, :value4, :value5, :value6, :timestamp, :accountID)");
		$query->execute([':value' => $vaultCodeName, ':value2' => $vaultCodeType, ':value3' => $vaultCodeReward, ':value4' => $vaultCodeDuration, ':value5' => $vaultCodeUses, ':value6' => $rewardID, ':timestamp' => time(), ':accountID' => $_SESSION['accountID']]);
	}
}
if(!empty($_POST['rewardID'])) {
	$rewardID = ExploitPatch::number($_POST['rewardID']);
	$getVaultCode = $db->prepare('SELECT * FROM vaultcodes WHERE rewardID = :rewardID');
	$getVaultCode->execute([':rewardID' => $rewardID]);
	$getVaultCode = $getVaultCode->fetch();
	if($getVaultCode) {
		$vaultCodeName = htmlspecialchars(base64_decode($getVaultCode['code']));
		$vaultCodeType = $getVaultCode['type'];
		$vaultCodeReward = $getVaultCode['reward'];
		$vaultCodeUses = $getVaultCode['uses'];
		$vaultCodeDuration = !empty($getVaultCode['duration']) ? date('Y-m-d\TH:i:s', $getVaultCode['duration']) : '';
	}
}
$rewardTypes = ['Nothing', 'Fire Shard', 'Ice Shard', 'Poison Shard', 'Shadow Shard', 'Lava Shard', 'Demon Key', 'Orbs', 'Diamond', 'Nothing', 'Earth Shard', 'Blood Shard', 'Metal Shard', 'Light Shard', 'Soul Shard', 'Gold Key'];
$vaultCodes = $db->prepare("SELECT * FROM vaultcodes ORDER BY rewardID ASC");
$vaultCodes->execute();
$vaultCodes = $vaultCodes->fetchAll();
foreach($vaultCodes as &$vaultCode) {
	$allVaultCodes .= '<button type="submit" onclick="vaultCode('.$vaultCode["rewardID"].')" class="btn-primary itembtn" id="button'.$vaultCode["rewardID"].'">
		<h2 class="subjectnotyou" id="name'.$vaultCode["rewardID"].'"><text id="vcname'.$vaultCode["rewardID"].'">'.base64_decode($vaultCode["code"]).'</text> <i style="opacity:0;transition:0.2s; margin-right: 10px; color: white; font-size: 13px;" id="spin'.$vaultCode["rewardID"].'" class="fa-solid fa-spinner fa-spin"></i></h2>
		<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;" id="stats'.$vaultCode["rewardID"].'">
			<span class="no-warp" title="'.$dl->getLocalizedString('type').'"><i class="fa-solid fa-circle-dot"></i> '.$rewardTypes[$vaultCode["type"]].'</span> • 
			<span class="no-warp" title="'.$dl->getLocalizedString('reward').'"><i class="fa-solid fa-award"></i> '.$vaultCode["reward"].'</span> • 
			<span class="no-warp" title="'.$dl->getLocalizedString('expires').'"><i class="fa-solid fa-clock"></i> '.$dl->convertToDate($vaultCode["duration"], true).'</span> • 
			<span class="no-warp" title="'.$dl->getLocalizedString('date').'"><i class="fa-regular fa-clock"></i> '.$dl->convertToDate($vaultCode["timestamp"], true).'</span>
		</h2>
	</button>';
}
$rewardTypesOptions = '<option id="vault_code_type_option0" value="0">'.$dl->getLocalizedString('vaultCodePickOption').'</option>';
for($x = 1; $x < count($rewardTypes); $x++) {
	$rewardTypesOptions .= '<option id="vault_code_type_option'.$x.'" value="'.$x.'">'.$rewardTypes[$x].'</option>';
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
	<div class="form cards-form">
		<h1>'.$dl->getLocalizedString((!empty($rewardID) ? 'vaultCodesEditTitle' : 'vaultCodesTitle')).'</h1>
		<form class="form__inner form__create" method="post" action="" name="vaultCodesForm">
			<p>'.$dl->getLocalizedString((!empty($rewardID) ? 'vaultCodesEditDesc' : 'vaultCodesDesc')).'</p>
			<input id="vaultCodeRewardID" name="rewardID" '.(!empty($rewardID) ? 'value="'.$rewardID.'"' : '').' type="hidden">
			<div class="field">
				<input id="vaultCodeName" value="'.$vaultCodeName.'" name="vaultCodeName" type="string" placeholder="'.$dl->getLocalizedString("vaultCodeName").'">
			</div>
			<div class="field" style="grid-gap: 5px;">
				<select name="vaultCodeType" value="'.$vaultCodeType.'" id="vaultCodeType" style="margin: 0px;">
					'.$rewardTypesOptions.'
				</select>
				<input id="vaultCodeReward" value="'.$vaultCodeReward.'" name="vaultCodeReward" type="number" placeholder="'.$dl->getLocalizedString('reward').'">
			</div>
			<div class="field" style="grid-gap: 5px;">
				<input id="vaultCodeUses" value="'.$vaultCodeUses.'" name="vaultCodeUses" type="number" placeholder="'.$dl->getLocalizedString('vaultCodeUses').'">
				<input type="datetime-local" value="'.$vaultCodeDuration.'" name="vaultCodeDuration" min="'.(new DateTime())->format('Y-m-d\TH:i:s').'" title="'.$dl->getLocalizedString("expires").'">
			</div>
			'.Captcha::displayCaptcha(true).'
			<button type="button" onclick="a(\'levels/vaultCodes.php\', true, true, \'POST\', false, \'vaultCodesForm\')" class="btn-primary btn-block" id="vaultCodesSubmit" disabled>'.$dl->getLocalizedString("vaultCodesCreate").'</button>
		</form>
		<form id="vaultCodesCustomForm" name="vaultCodesCustomForm">
			<input id="rewardID" name="rewardID" type="hidden">
		</form>
	</div>
</div>
<script>
'.(!empty($rewardID) ? 'document.getElementById("button'.$rewardID.'").scrollIntoView();' : '').'
'.(!empty($vaultCodeType) ? 'document.getElementById("vaultCodeType").value = "'.$vaultCodeType.'";' : '').'
function vaultCode(rewardID) {
	document.getElementById("rewardID").value = rewardID;
	a(\'levels/vaultCodes.php\', true, true, \'POST\', false, \'vaultCodesCustomForm\');
}
$(document).on("keyup keypress change keydown",function() {
   const vaultCodeName = document.getElementById("vaultCodeName");
   const vaultCodeType = document.getElementById("vaultCodeType");
   const vaultCodeReward = document.getElementById("vaultCodeReward");
   const vaultCodesSubmit = document.getElementById("vaultCodesSubmit");
   if(!vaultCodeName.value.trim().length || vaultCodeType.value == 0 || !vaultCodeReward.value.trim().length) {
		vaultCodesSubmit.disabled = true;
		vaultCodesSubmit.classList.add("btn-block");
		vaultCodesSubmit.classList.remove("btn-song");
	} else {
		vaultCodesSubmit.removeAttribute("disabled");
		vaultCodesSubmit.classList.remove("btn-block");
		vaultCodesSubmit.classList.remove("btn-size");
		vaultCodesSubmit.classList.add("btn-song");
	}
});
</script>', 'mod');
?>