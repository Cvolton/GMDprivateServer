<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/mainLib.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/generateHash.php";
require_once "../lib/cron.php";
$gs = new mainLib();
$gh = new generateHash();
$type = !empty($_POST["type"]) ? $_POST["type"] : (!empty($_POST["weekly"]) ? $_POST["weekly"] : 0);
$current = time();
switch($type) {
	case 0:
	case 1:
		$dailyTable = 'dailyfeatures';
		$dailyTime = 'timestamp';
		$isEvent = false;
		$query = $db->prepare("SELECT * FROM dailyfeatures WHERE timestamp < :current AND type = :type ORDER BY timestamp DESC LIMIT 1");
		$query->execute([':current' => $current, ':type' => $type]);
		break;
	case 2:
		$dailyTable = 'events';
		$dailyTime = 'duration';
		$isEvent = true;
		$query = $db->prepare("SELECT * FROM events WHERE timestamp < :current AND duration >= :current ORDER BY duration ASC LIMIT 1");
		$query->execute([':current' => $current]);
		break;
}

$daily = $query->fetch();
if($query->rowCount() == 0) exit("-1");
$dailyID = $daily['feaID'] + ($type * 100000);
$timeleft = $daily[$dailyTime] - $current;
if(!$daily['webhookSent']) {
	$gs->sendDailyWebhook($daily['levelID'], $type);
	$sent = $db->prepare('UPDATE '.$dailyTable.' SET webhookSent = 1 WHERE feaID = :feaID');
	$sent->execute([':feaID' => $daily['feaID']]);
	if($automaticCron) Cron::updateCreatorPoints($accountID, false);
}
$stringToAdd = '';
if($isEvent) {
	$chk = XORCipher::cipher(ExploitPatch::url_base64_decode(substr(ExploitPatch::charclean($_POST["chk"]), 5)), 59182);
	$string = ExploitPatch::url_base64_encode(XORCipher::cipher('Sa1nt:'.$chk.':'.($daily['feaID'] + 19).':3:'.$daily['rewards'], 59182));
	$timeleft = 10;
	$hash = $gh->genSolo4($string);
	$stringToAdd = '|Sa1nt'.$string.'|'.$hash;
}
echo $dailyID ."|". $timeleft.$stringToAdd;
?>