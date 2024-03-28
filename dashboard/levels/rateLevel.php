<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
error_reporting(E_ALL);
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$stars = ExploitPatch::number($_POST["rateStars"]);
if($stars > 10 OR $stars < 1) {
 	header('Location: ../stats/levelsList.php');
	die();
}
$lvlid = ExploitPatch::number($_POST["level"]);
$featured = ExploitPatch::number($_POST["featured"]);
if(empty($stars) OR empty($lvlid)) {
 	header('Location: ../stats/levelsList.php');
	die();
}
if($stars != 10) $demon = 0; else $demon = 1;
if($stars != 1) $auto = 0; else $auto = 1;
$difficulty = $gs->getDiffFromStars($stars);
$difficulty = $difficulty["diff"];
if($featured > 1) {
	$epic = $featured - 1;
	$featured = 0;
}
if($gs->checkPermission($_SESSION["accountID"], "actionRateStars")){
  		$gs->rateLevel($_SESSION["accountID"], $lvlid, $stars, $difficulty, $auto, $demon);
  		if($featured > 1) {	
			$query = $db->prepare("UPDATE levels SET starEpic = :epic WHERE levelID = :levelID");
			$query->execute([':levelID' => $lvlid, ':epic' => $epic]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => $epic, ':timestamp' => time(), ':id' => $_SESSION["accountID"], ':levelID' => $lvlid]);
		} elseif($featured == 1) $gs->featureLevel($_SESSION["accountID"], $lvlid, $featured);
  		$gs->verifyCoinsLevel($_SESSION["accountID"], $lvlid, 1);
  		header('Location: ../stats/levelsList.php');
} elseif($gs->checkPermission($_SESSION["accountID"], "actionSuggestRating")) {
        $gs->suggestLevel($_SESSION["accountID"], $lvlid, $difficulty, $stars, $featured, $auto, $demon);
        header('Location: ../stats/levelsList.php');
} else {
	die(-1);
}
?>