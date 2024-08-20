<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs")){
	$author = mb_substr(ExploitPatch::rucharclean($_POST["author"]), 0, 23);
	$name = mb_substr(ExploitPatch::rucharclean($_POST["name"]), 0, 30);
	$sid = ExploitPatch::number($_POST["ID"]);
	if(isset($_POST['sfx']) AND !empty($name) AND !empty($sid)) {
		$query = $db->prepare("UPDATE sfxs SET name = :n WHERE ID = :id");
		$query->execute([':n' => $name, ':id' => $sid]);
		$query = $db->prepare("INSERT INTO modactions (type, value2, value3, timestamp, account) VALUES ('27', :n, :id, :timestamp, :account)");
		$query->execute([':n' => $name, ':id' => $sid, ':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		die(json_encode(['success' => true]));
	}
	if(!empty($author) AND !empty($name) AND !empty($sid)) {
		$query = $db->prepare("UPDATE songs SET name = :n, authorName = :a WHERE ID = :id");
		$query->execute([':n' => $name, ':a' => $author, ':id' => $sid]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('19', :a, :n, :id, :timestamp, :account)");
		$query->execute([':n' => $name, ':a' => $author, ':id' => $sid, ':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		die(json_encode(['success' => true]));
	} else die(json_encode(['success' => false, 'error' => '-2']));
} else die(json_encode(['success' => false, 'error' => '-1']));
?>