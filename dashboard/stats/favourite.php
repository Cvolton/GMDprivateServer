<?php
session_start();
require '../incl/dashboardLib.php';
require '../'.$dbPath.'incl/lib/connection.php';
require '../'.$dbPath.'incl/lib/exploitPatch.php';
require '../'.$dbPath.'incl/lib/mainLib.php';
$id = ExploitPatch::number($_GET["id"]);
$check = $db->prepare('SELECT * FROM songs WHERE ID = :ID');
$check->execute([':ID' => $id]);
$check = $check->fetchColumn();
if(!empty($id) AND $_SESSION["accountID"] != 0 AND $check AND $check['isDisabled'] == 0) {
	$favourites = $db->prepare("SELECT * FROM favsongs WHERE songID = :id AND accountID = :aid");
	$favourites->execute([':id' => $id, ':aid' => $_SESSION["accountID"]]);
	$favourites = $favourites->fetch();
	if(!empty($favourites)) {
		$favourites = $db->prepare("DELETE FROM favsongs WHERE songID = :id AND accountID = :aid");
		$favourites->execute([':id' => $id, ':aid' => $_SESSION["accountID"]]);
		exit("1");
	} else {
		$favourites = $db->prepare("INSERT INTO favsongs (songID, accountID, timestamp) VALUES (:id, :aid, :time)");
		$favourites->execute([':id' => $id, ':aid' => $_SESSION["accountID"], ':time' => time()]);
		exit("1");
	}
} else exit("-1");
?>