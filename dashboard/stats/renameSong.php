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
	$author = ExploitPatch::remove($_POST["author"]);
	$name = ExploitPatch::remove($_POST["name"]);
	$sid = ExploitPatch::number($_POST["ID"]);
	if(!empty($author) AND !empty($name) AND !empty($sid)) {
		$query = $db->prepare("UPDATE songs SET name='".$name."', authorName='".$author."' WHERE ID=".$sid."");
		$query->execute();
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('19', '".$author."', '".$name."', '".$sid."' , :timestamp, :account)");
		$query->execute([':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		die(json_encode(['success' => true]));
	} else die(json_encode(['success' => false, 'error' => '-2']));
} else die(json_encode(['success' => false, 'error' => '-1']));
?>