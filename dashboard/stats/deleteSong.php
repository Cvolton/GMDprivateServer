<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$accID = $_SESSION["accountID"];
$songid = ExploitPatch::remove($_GET["ID"]);
if($accID == 0) die(json_encode(['success' => false, 'error' => 0]));
else {
	if($songid == 0) die(json_encode(['success' => false, 'error' => -1]));
	$query = $db->prepare("SELECT count(*) FROM songs WHERE reuploadID = :id AND ID = :sid");
	$query->execute([':id' => $accID, ':sid' => $songid]);
	$rowCount = $query->fetchColumn();
	if($rowCount == 0) die(json_encode(['success' => false, 'error' => -2]));
	else {
		$query = $db->prepare("DELETE FROM songs WHERE reuploadID = :id AND ID = :sid");
		$query->execute([':id' => $accID, ':sid' => $songid]);
		if(file_exists("../songs/".$songid.".mp3")) unlink("../songs/".$songid.".mp3");
		die(json_encode(['success' => true]));
	}
}
?>