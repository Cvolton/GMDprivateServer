<?php
session_start();
include '../incl/dashboardLib.php';
include '../'.$dbPath.'incl/lib/connection.php';
include '../'.$dbPath.'incl/lib/exploitPatch.php';
include '../'.$dbPath.'incl/lib/mainLib.php';
$id = ExploitPatch::number($_GET["id"]);
if(!empty($id) AND $_SESSION["accountID"] != 0) {
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