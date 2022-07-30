<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
$accID = $_SESSION["accountID"];
$songid = $_GET["ID"];
if($accID == 0){
	die("voidi v akk geniy");
} else {
	if($songid == 0){
		die("hacker");
	}
	$query = $db->prepare("SELECT ID FROM songs WHERE reuploadID = ".$accID." AND ID = ".$songid."");
	$query->execute();
	$rowCount = $query->fetchAll();
	if(count($rowCount) == 0) {
		die("ahahahha loooooh");
	} else {
		$query = $db->prepare("DELETE FROM songs WHERE  reuploadID = ".$accID." AND ID = ".$songid."");
		$query->execute();
		unlink("../songs/".$songid.".mp3");
		header('Location: ' . $_SERVER["HTTP_REFERER"]);
	}
}
?>