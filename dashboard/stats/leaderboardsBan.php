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
if(!empty($_POST["userID"])) {
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
		$userID = ExploitPatch::remove($_POST["userID"]);
      	$reason = ExploitPatch::remove($_POST["banReason"]);
      	$type = ExploitPatch::remove($_POST["type"]);
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
	        <button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
    </form>
</div>', 'mod');
			die();
		}	
		switch($type) {
				case 'playerTop':
					$type = 'isBanned';
					break;
				case 'creatorTop':
					$type = 'isCreatorBanned';
					break;
			}
			$query = $db->prepare("SELECT $type FROM users WHERE extID=:id AND $type = 1");
			$query->execute([':id' => $userID]);
			$banned = $query->fetchColumn();
			if($banned != 0) {
				$ban = $db->prepare("UPDATE users SET $type = 0, banReason = 'none' WHERE extID = :id");
				$ban->execute([':id' => $userID]);
				$success = $dl->getLocalizedString("player"). ' <b>' .$nickname.'</b> '.$dl->getLocalizedString("accid").' <b>'.$userID.'</b> '.$dl->getLocalizedString("unbanned");
              	$bou = 0;
			} else {
				$ban = $db->prepare("UPDATE users SET $type = 1,  banReason = :ban WHERE extID = :id");
				$ban->execute([':id' => $userID, ':ban' => $reason]);
				$success = $dl->getLocalizedString("player"). ' <b>' .$nickname.'</b> '.$dl->getLocalizedString("accid").' <b>'.$userID.'</b> '.$dl->getLocalizedString("banned");
              	$bou = 1;
			}
			if($ban->rowCount() != 0){
				$dl->printSong('<div class="form">
                    <h1>'.$dl->getLocalizedString("banUserPlace").'</h1>
                    <p id="bruh">'.$success.'</p>
                      <form class="form__inner" method="post" action="">
                          <button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("banYourSelfBtn!").'</button>
                      </form>
              		</div>', 'mod');
			}else{
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
													VALUES ('15',:userID, :reason, :bou, :type, :timestamp,:account)");
	$query->execute([':userID' => $userID, ':timestamp' => time(), ':reason' => $reason, ':bou' => $bou, ':account' => $accountID, ':type' => $type]);
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
        <div class="field" style="display:flex"><input type="text" name="userID" id="p1" placeholder="'.$dl->getLocalizedString("banUserID").'">
		<select style="width:75%" name="type">
			<option value="playerTop">'.$dl->getLocalizedString('playerTop').'</option>
			<option value="creatorTop">'.$dl->getLocalizedString('creatorTop').'</option>
		</select></div>
        <div class="field"><input type="text" name="banReason" placeholder="'.$dl->getLocalizedString("banReason").'"></div>
		', 'mod');
		Captcha::displayCaptcha();
        echo '
        <button type="button" onclick="a(\'stats/leaderboardsBan.php\', true, true, \'POST\')" class="btn-primary btn-block" id="submit" disabled>'.$dl->getLocalizedString("ban").'</button>
    </form>
</div>
<script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const btn = document.getElementById("submit");
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
</script>';
}
?>
