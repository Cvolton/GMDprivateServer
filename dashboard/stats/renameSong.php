<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs")){
	$author = ExploitPatch::remove($_GET["author"]);
	$name = ExploitPatch::remove($_GET["name"]);
	$sid = ExploitPatch::remove($_GET["ID"]);
	if(!empty($author) AND !empty($name) AND !empty($sid)) {
		$query = $db->prepare("UPDATE songs SET name=".$name.", authorName=".$author." WHERE ID=".$sid."");
		$query->execute();
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('19', ".$author.", ".$name.", ".$sid." , :timestamp, :account)");
		$query->execute([':timestamp' => time(), ':account' => $_SESSION["accountID"]]);
		header('Location: songList.php?author='.$author.'&name='.$name.'');
	} else {
		die(-1);
	}
} else {
	die(-1);
}
?>