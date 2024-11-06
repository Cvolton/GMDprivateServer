<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
$sid = ExploitPatch::number($_POST["ID"]);
$audioType = isset($_POST['sfx']) ? 'sfxs' : 'songs';
$check = $db->prepare('SELECT reuploadID FROM '.$audioType.' WHERE ID = :ID');
$check->execute([':ID' => $sid]);
$check = $check->fetchColumn();
if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs") || ($_SESSION["accountID"] != 0 && $_SESSION["accountID"] == $check)) {
	$author = mb_substr(ExploitPatch::rucharclean($_POST["author"]), 0, 23);
	$name = mb_substr(ExploitPatch::rucharclean($_POST["name"]), 0, 30);
	if($audioType == 'sfxs' AND !empty($name) AND !empty($sid)) {
		$query = $db->prepare("UPDATE sfxs SET name = :n WHERE ID = :id");
		$query->execute([':n' => $name, ':id' => $sid]);
		$query = $db->prepare("INSERT INTO modactions (type, value2, value3, timestamp, account) VALUES ('27', :n, :id, :timestamp, :account)");
		$query->execute([':n' => $name, ':id' => $sid, ':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		die(json_encode(['success' => true]));
	} elseif(!empty($author) AND !empty($name) AND !empty($sid)) {
		$query = $db->prepare("UPDATE songs SET name = :n, authorName = :a WHERE ID = :id");
		$query->execute([':n' => $name, ':a' => $author, ':id' => $sid]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('19', :a, :n, :id, :timestamp, :account)");
		$query->execute([':n' => $name, ':a' => $author, ':id' => $sid, ':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		die(json_encode(['success' => true]));
	} else die(json_encode(['success' => false, 'error' => '-2']));
} else die(json_encode(['success' => false, 'error' => '-1']));
?>