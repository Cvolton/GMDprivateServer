<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
$accID = $_SESSION["accountID"];
$songid = ExploitPatch::remove($_GET["ID"]);
$type = 'songs';
$format = 'mp3';
if(isset($_GET['sfx'])) {
	$type = 'sfxs';
	$format = 'ogg';
}
if($accID == 0) die(json_encode(['success' => false, 'error' => '0']));
else {
	if($songid == 0) die(json_encode(['success' => false, 'error' => '-1']));
	$query = $db->prepare("SELECT reuploadID, isDisabled FROM ".$type." WHERE ID = :sid");
	$query->execute([':sid' => $songid]);
	$song = $query->fetch();
	if(!$song) die(json_encode(['success' => false, 'error' => '-2']));
	else {
		$check = $gs->checkPermission($accID, "dashboardManageSongs") ?: $accID == $song['reuploadID'];
		if(!$check) die(json_encode(['success' => false, 'error' => '-3']));
		if(!isset($_GET['disable'])) {
			$query = $db->prepare("DELETE FROM ".$type." WHERE ID = :sid");
			$query->execute([':sid' => $songid]);
			if(file_exists("../".$type."/".$songid.".".$format)) unlink("../".$type."/".$songid.".".$format);
			if(file_exists("../".$type."/".$songid."_temp.".$format)) unlink("../".$type."/".$songid."_temp.".$format);
		} else {
			$query = $db->prepare("UPDATE ".$type." SET isDisabled = :isDisabled WHERE ID = :sid");
			$query->execute([':sid' => $songid, ':isDisabled' => ($song['isDisabled'] == 0 ? 1 : 0)]);
		}
		die(json_encode(['success' => true]));
	}
}
?>