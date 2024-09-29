<?php
session_start();
require '../incl/dashboardLib.php';
require '../'.$dbPath.'incl/lib/connection.php';
require '../'.$dbPath.'incl/lib/exploitPatch.php';
require '../'.$dbPath.'incl/lib/mainLib.php';
require '../'.$dbPath.'incl/lib/Captcha.php';
$id = ExploitPatch::number($_GET["id"]);
$gs = new mainLib();
if(!empty($id)) {
	if(!empty($_GET["l1"]) AND !empty($_GET["l2"]) AND !empty($_GET["l3"]) AND !empty($_GET["l4"]) AND !empty($_GET["l5"]) AND $gs->checkPermission($_SESSION["accountID"], 'dashboardGauntletCreate')) {
		if(!Captcha::validateCaptcha()) {
			exit(json_encode(['success' => false]));
		}
		if(!$gs->getLevelName($_GET["l1"]) OR !$gs->getLevelName($_GET["l2"]) OR !$gs->getLevelName($_GET["l3"]) OR !$gs->getLevelName($_GET["l4"]) OR !$gs->getLevelName($_GET["l5"]) OR !is_numeric($_GET['gid'])) {
			exit(json_encode(['success' => false]));
		}
		$gauntletLevels = [ExploitPatch::number($_GET["l1"]), ExploitPatch::number($_GET["l2"]), ExploitPatch::number($_GET["l3"]), ExploitPatch::number($_GET["l4"]), ExploitPatch::number($_GET["l5"])];
		if(array_unique($gauntletLevels) != $gauntletLevels) {
			exit(json_encode(['success' => false]));
		}
		$gid = ExploitPatch::number($_GET['gid']);
		$gauntletData = $db->prepare('SELECT * FROM gauntlets WHERE ID = :gid');
		$gauntletData->execute([':gid' => $id]);
		$gauntletData = $gauntletData->fetch();
		$change = $db->prepare("UPDATE gauntlets SET ID = :gid, level1 = :l1, level2 = :l2, level3 = :l3, level4 = :l4, level5 = :l5 WHERE ID = :i");
		$change->execute([':i' => $id, ':gid' => $gid,':l1' => $gauntletLevels[0], ':l2' => $gauntletLevels[1], ':l3' => $gauntletLevels[2], ':l4' => $gauntletLevels[3], ':l5' => $gauntletLevels[4]]);
		$levels = $gauntletLevels[0].','.$gauntletLevels[1].','.$gauntletLevels[2].','.$gauntletLevels[3].','.$gauntletLevels[4];
		$query = $db->prepare("INSERT INTO modactions  (type, value, value3, timestamp, account) VALUES ('22',:value, :value3, :timestamp,:account)");
		$query->execute([':value' => $levels, ':value3' => $gid, ':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		$gs->sendLogsGauntletChangeWebhook($gid, $_SESSION['accountID'], $gauntletData);
		echo json_encode(['success' => true, 'name' => $gs->getGauntletName($gid)." Gauntlet"]);
	} else {
	  $pck = $db->prepare("SELECT * FROM gauntlets WHERE ID = :id");
	  $pck->execute([':id' => $id]);
	  $map = $pck->fetch();
	  echo json_encode(['success' => true, 'ID' => $map['ID'], 'l1' => $map['level1'], 'l2' => $map['level2'], 'l3' => $map['level3'], 'l4' => $map['level4'], 'l5' => $map['level5'], 'name' => $gs->getGauntletName($id)." Gauntlet"]);
	}
}
?>