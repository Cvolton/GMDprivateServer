<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
$accID = $_SESSION["accountID"];
$songid = ExploitPatch::remove($_GET["ID"]);
if($accID == 0){
	die("voidi v akk geniy");
} else {
	if($songid == 0){
		die("hacker");
	}
	$query = $db->prepare("SELECT ID, authorName, name FROM songs WHERE reuploadID = ".$accID." AND ID = ".$songid."");
	$query->execute();
	$rowCount = $query->fetch();
	if(empty($rowCount)) {
		die("ahahahha loooooh");
	} else {
			$author = $rowCount["authorName"];
			$name = $rowCount["name"];
		$query = $db->prepare("DELETE FROM songs WHERE  reuploadID = ".$accID." AND ID = ".$songid."");
		$query->execute();
		if(file_exists("../songs/".$songid.".mp3")) unlink("../songs/".$songid.".mp3");
		header('Location: manageSongs.php?author='.$author.'&name='.$name.'');
	}
}
?>