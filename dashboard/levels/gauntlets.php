<?php
session_start();
include '../incl/dashboardLib.php';
include '../'.$dbPath.'incl/lib/connection.php';
include '../'.$dbPath.'incl/lib/exploitPatch.php';
include '../'.$dbPath.'incl/lib/mainLib.php';
$id = ExploitPatch::number($_GET["id"]);
$gs = new mainLib();
if(!empty($id)) {
	if(!empty($_GET["l1"]) AND !empty($_GET["l2"]) AND !empty($_GET["l3"]) AND !empty($_GET["l4"]) AND !empty($_GET["l5"]) AND $gs->checkPermission($_SESSION["accountID"], 'dashboardLevelPackCreate')) {
		if(!$gs->getLevelName($_GET["l1"]) OR !$gs->getLevelName($_GET["l2"]) OR !$gs->getLevelName($_GET["l3"]) OR !$gs->getLevelName($_GET["l4"]) OR !$gs->getLevelName($_GET["l5"])) die("-1");
		$change = $db->prepare("UPDATE gauntlets SET level1 = :l1, level2 = :l2, level3 = :l3, level4 = :l4, level5 = :l5 WHERE ID = :i");
		$change->execute([':i' => $id, ':l1' => ExploitPatch::number($_GET["l1"]), ':l2' => ExploitPatch::number($_GET["l2"]), ':l3' => ExploitPatch::number($_GET["l3"]), ':l4' => ExploitPatch::number($_GET["l4"]), ':l5' => ExploitPatch::number($_GET["l5"])]);
		$levels = ExploitPatch::remove($_GET['l1']) . ',' . ExploitPatch::remove($_GET['l2']) . ',' . ExploitPatch::remove($_GET['l3']). ',' . ExploitPatch::remove($_GET['l4']). ',' . ExploitPatch::remove($_GET['l5']);
		$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account) VALUES ('22',:value,:timestamp,:account)");
		$query->execute([':value' => $levels, ':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		echo 1;
	} else {
	  $pck = $db->prepare("SELECT * FROM gauntlets WHERE ID = :id");
	  $pck->execute([':id' => $id]);
	  $map = $pck->fetch();
	  echo $map["ID"].' | '.$map["level1"].' | '.$map["level2"].' | '.$map["level3"].' | '.$map["level4"].' | '.$map["level5"].' | '.$gs->getGauntletName($id)." Gauntlet";
	}
}
?>