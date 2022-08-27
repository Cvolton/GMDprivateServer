<?php
session_start();
require "../../incl/lib/Captcha.php";
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/exploitPatch.php";
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../incl/dashboardLib.php";
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("addQuest"));
$dl->printFooter('../');
if($gs->checkPermission($_SESSION["accountID"], "toolQuestsCreate")) {
if(!empty($_POST["type"]) AND !empty($_POST["amount"]) AND !empty($_POST["reward"]) AND !empty($_POST["names"])){
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>');
	die();
	}
	$type = ExploitPatch::number($_POST["type"]);
	$amount = ExploitPatch::number($_POST["amount"]);
    $reward = ExploitPatch::number($_POST["reward"]);
    $name = ExploitPatch::remove($_POST["names"]);
	$accountID = $_SESSION["accountID"];
		if(!is_numeric($type) OR !is_numeric($amount) OR !is_numeric($reward) OR $type > 3){
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("invalidPost").'</p>
				<button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>');
			die();
		}
		$query = $db->prepare("INSERT INTO quests (type, amount, reward, name) VALUES (:type,:amount,:reward,:name)");
		$query->execute([':type' => $type, ':amount' => $amount, ':reward' => $reward, ':name' => $name]);
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value2, value3, value4) VALUES ('25',:value,:timestamp,:account,:amount,:reward,:name)");
		$query->execute([':value' => $type, ':timestamp' => time(), ':account' => $accountID, ':amount' => $amount, ':reward' => $reward, ':name' => $name]);
		$success = $dl->getLocalizedString("questsSuccess").' <b>'. $name. '</b>!';
		if($db->lastInsertId() < 3) {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("addQuest").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$success.'</p>
			<p>'.$dl->getLocalizedString("fewMoreQuests").'</p>
			<button type="submit" class="btn-primary">'.$dl->getLocalizedString("oneMoreQuest?").'</button>
			</form>
		</div>');
		} else {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("addQuest").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$success.'</p>
			<button type="submit" class="btn-primary">'.$dl->getLocalizedString("oneMoreQuest?").'</button>
			</form>
		</div>');
		}
	} else {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("addQuest").'</h1>
    <form class="form__inner" method="post" action="">
	<p>'.$dl->getLocalizedString("addQuestDesc").'</p>
	 <div class="field" id="selecthihi">
	 <input class="quest" type="text" name="names" placeholder="'.$dl->getLocalizedString("questName").'"></div>
	 <div class="field" id="selecthihi">
		<select name="type">
			<option value="1">'.$dl->getLocalizedString("orbs").'</option>
			<option value="2">'.$dl->getLocalizedString("coins").'</option>
			<option value="3">'.$dl->getLocalizedString("stars").'</option>
		</select></div>
        <div class="field" id="selecthihi">
		<input class="number" type="number" name="amount" placeholder="'.$dl->getLocalizedString("questAmount").'">
		<input class="number" type="number" name="reward" placeholder="'.$dl->getLocalizedString("questReward").'">
		</div>
		');
		Captcha::displayCaptcha();
        echo '
        <button  type="submit" class="btn-song">'.$dl->getLocalizedString("questCreate").'</button>
    </form>
</div>';
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>');
}
?>