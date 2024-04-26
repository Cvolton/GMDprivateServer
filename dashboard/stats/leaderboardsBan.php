<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("banUserPlace"));
$dl->printFooter('../');
if(!empty($_POST["extID"])) {
	if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
		if(!Captcha::validateCaptcha()) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
		die();
		}
		$userName = $gs->getAccountName($_SESSION["accountID"]);
		$extID = ExploitPatch::number($_POST["extID"]);
      	$reason = ExploitPatch::rucharclean($_POST["banReason"]);
      	$type = ExploitPatch::charclean($_POST["type"]);
      	if(empty($reason)) $reason = 'none';
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
			if(!is_numeric($extID)){
				$nickname = ExploitPatch::remove($_POST["extID"]);
				$extID = $gs->getAccountIDFromName($extID);
			} else $nickname = $gs->getAccountName($extID);
			if($_SESSION["accountID"] == $extID) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<p id="bruh">'.$dl->getLocalizedString("banYourself").'</p>
				<form class="form__inner" method="post" action="">
				<button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
				</form>
			</div>', 'mod');
			die();
		}
		switch($type) {
			case 'playerTop':
				$type = 'isBanned';
				$typeN = 1;
				break;
			case 'creatorTop':
				$type = 'isCreatorBanned';
				$typeN = 2;
				break;
			case 'levelUploading':
				$type = 'isUploadBanned';
				$typeN = 3;
				break;
			case 'commentBan':
				$type = 'isCommentBanned';
				$typeN = 4;
				break;
		}
		$query = $db->prepare("SELECT $type FROM users WHERE extID=:id AND $type = 1");
		$query->execute([':id' => $extID]);
		$banned = $query->fetchColumn();
		if($banned != 0) {
			$ban = $db->prepare("UPDATE users SET $type = 0, banReason = :ban WHERE extID = :id");
			$ban->execute([':id' => $extID, ':ban' => $reason]);
			$success = sprintf($dl->getLocalizedString('successfullyUnbanned'), $nickname, $extID);
            $bou = 0;
		} else {
			$ban = $db->prepare("UPDATE users SET $type = 1,  banReason = :ban WHERE extID = :id");
			$ban->execute([':id' => $extID, ':ban' => $reason]);
			$success = sprintf($dl->getLocalizedString('successfullyBanned'), $nickname, $extID);
            $bou = 1;
		}
		if($ban->rowCount() != 0) {
			$gs->sendBanWebhook($_SESSION["accountID"], $extID, $type);
			$dl->printSong('<div class="form">
                   <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
                     <form class="form__inner" method="post" action="">
					<p>'.$success.'</p>
                       <button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
                     </form>
             		</div>', 'mod');
		} else {
			$dl->printSong('<div class="form">
                   <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
                   <p id="bruh">'.$dl->getLocalizedString("nothingFound").'</p>
                   <form class="form__inner" method="post" action="">
                        <button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
                   </form>
              		</div>', 'mod');
		die();
		}
		$query = $db->prepare("INSERT INTO modactions  (type, value, value2, value3, value4, timestamp, account) 
													VALUES ('15',:extID, :reason, :bou, :type, :timestamp,:account)");
		$query->execute([':extID' => $extID, ':timestamp' => time(), ':reason' => $reason, ':bou' => $bou, ':account' => $accountID, ':type' => $type]);
	} else {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<p id="bruh">'.$dl->getLocalizedString("noPermission").'</p>
    <form class="form__inner" method="post" action=".">
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
die();
	}
} else {
$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
	<h2>'.$dl->getLocalizedString("banDesc").'</h2>
    <form class="form__inner" method="post" action="">
        <div class="field" style="display:flex"><input type="text" name="extID" id="p1" placeholder="'.$dl->getLocalizedString("banUserID").'">
		<select style="width:75%" name="type">
			<option value="playerTop">'.$dl->getLocalizedString('playerTop').'</option>
			<option value="creatorTop">'.$dl->getLocalizedString('creatorTop').'</option>
			<option value="levelUploading">'.$dl->getLocalizedString('levelUploading').'</option>
			<option value="commentBan">'.$dl->getLocalizedString('commentBan').'</option>
		</select></div>
        <div class="field"><input type="text" name="banReason" placeholder="'.$dl->getLocalizedString("banReason").'"></div>
		'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, true, \'POST\')" class="btn-primary btn-block" id="banSubmit" disabled>'.$dl->getLocalizedString("ban").'</button>
    </form>
</div>
<script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const btn = document.getElementById("banSubmit");
   if(!p1.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-primary");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-primary");
	}
});
</script>', 'mod');
}
?>
