<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/mainLib.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/generateHash.php";
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
}

$daily = $query->fetch();
if($query->rowCount() == 0) exit("-1");
$dailyID = $daily['feaID'] + ($type * 100000);
$timeleft = $daily[$dailyTime] - $current;
if(!$daily['webhookSent']) {
	$gs->sendDailyWebhook($daily['levelID'], $type);
	$sent = $db->prepare('UPDATE '.$dailyTable.' SET webhookSent = 1 WHERE feaID = :feaID');
	$sent->execute([':feaID' => $daily['feaID']]);
}
$stringToAdd = '';
if($isEvent) {
	$string = ExploitPatch::url_base64_encode(XORCipher::cipher('Sa1nt:1:'.$dailyID.':2:'.$check['type'].','.$check['reward'], 59182));
	$hash = $gh->genSolo4($string);
	$stringToAdd = '|Sa1nt'.$string.'|'.$hash;
}
echo $dailyID ."|". $timeleft.$stringToAdd;
?>