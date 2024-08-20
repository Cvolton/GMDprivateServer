<?php
session_start();
include '../incl/dashboardLib.php';
include '../'.$dbPath.'incl/lib/connection.php';
include '../'.$dbPath.'incl/lib/exploitPatch.php';
include '../'.$dbPath.'incl/lib/mainLib.php';
$id = ExploitPatch::number($_GET["id"]);
$gs = new mainLib();
if(!empty($id)) {
	if(!empty($_GET["role"]) AND !empty($_GET["acc"]) AND $gs->checkPermission($_SESSION["accountID"], 'dashboardAddMod')) {
		$priority = $gs->getMaxValuePermission($_SESSION["accountID"], 'priority');
		$role = $_GET['role'] != '-1' ? ExploitPatch::number($_GET["role"]) : '-1';
		$check = $db->prepare('SELECT priority FROM roles WHERE roleID = :role');
		$check->execute([':role' => $role]);
		$check = $check->fetchColumn();
		$mod = ExploitPatch::number($_GET["acc"]);
		$mod2 = $gs->getAccountName($mod);
		if($_SESSION['accountID'] == $mod) die('-1');
		if($role != "-1") {
			if($check >= $priority) die("-1");
			$change = $db->prepare("UPDATE roleassign SET roleID = :r WHERE assignID = :i");
			$change = $change->execute([':r' => $role, ':i' => $id]);
		} else {
			$change = $db->prepare("DELETE FROM roleassign WHERE assignID = :i");
			$change = $change->execute([':i' => $id]);
		}
		if($change) echo "1"; else die("-1");
		$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3) VALUES ('24', :value, :timestamp, :account, :value2, :value3)");
		$query->execute([':value' => $mod2, ':timestamp' => time(), ':account' => $_SESSION["accountID"], ':value2' => $mod, ':value3' => $role]);
	} else {
		$pck = $db->prepare("SELECT * FROM roleassign WHERE assignID = :id");
		$pck->execute([':id' => $id]);
		$map = $pck->fetch();
		echo $map["assignID"].' | '.$map["roleID"].' | '.$map["accountID"]." | ".$gs->getAccountName($map["accountID"]);
	}
}
?>