<?php
session_start();
require '../incl/dashboardLib.php';
require '../'.$dbPath.'incl/lib/connection.php';
require '../'.$dbPath.'incl/lib/exploitPatch.php';
require '../'.$dbPath.'incl/lib/mainLib.php';
$id = ExploitPatch::number($_GET["id"]);
$gs = new mainLib();
if(!empty($id)) {
	if(!empty($_GET["name"]) AND !empty($_GET["type"]) AND !empty($_GET["amount"]) AND !empty($_GET["reward"]) AND $gs->checkPermission($_SESSION["accountID"], 'toolQuestsCreate')) {
		$name = ExploitPatch::charclean($_GET["name"]);
		if(!is_numeric($_GET["type"]) OR !is_numeric($_GET["amount"]) OR !is_numeric($_GET["reward"])) die("-1");
		if($_GET["type"] > 3) $type = 3; elseif($_GET["type"] < 1) $type = 1; else $type = ExploitPatch::number($_GET["type"]);
		$amount = ExploitPatch::number($_GET["amount"]);
		$reward = ExploitPatch::number($_GET["reward"]);
		$change = $db->prepare("UPDATE quests SET name = :n, type = :t, amount = :a, reward = :r WHERE ID = :i");
		if($change->execute([':n' => $name, ':t' => $type, ':a' => $amount, ':r' => $reward, ':i' => $id])) echo 1; else die("-1");
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value2, value3, value4) VALUES ('23',:value,:timestamp,:account,:amount,:reward,:name)");
		$query->execute([':value' => $type, ':timestamp' => time(), ':account' => $_SESSION["accountID"], ':amount' => $amount, ':reward' => $reward, ':name' => $name]);
	} else {
		$pck = $db->prepare("SELECT * FROM quests WHERE ID = :id");
		$pck->execute([':id' => $id]);
		$map = $pck->fetch();
		echo $map["ID"].' | '.$map["name"].' | '.$map["type"].' | '.$map["amount"].' | '.$map["reward"];
	}
}
?>