<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
error_reporting(E_ALL);
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
require "../../incl/lib/exploitPatch.php";
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
if($featured != 1) $featured = 0;
if($gs->checkPermission($_SESSION["accountID"], "actionRateStars")){
  		$gs->rateLevel($_SESSION["accountID"], $lvlid, $stars, $difficulty, $auto, $demon);
  		$gs->featureLevel($_SESSION["accountID"], $lvlid, $featured);
  		$gs->verifyCoinsLevel($_SESSION["accountID"], $lvlid, 1);
		header('Location: ../stats/levelsList.php');
} elseif($gs->checkPermission($_SESSION["accountID"], "actionSuggestRating")) {
        $gs->suggestLevel($_SESSION["accountID"], $lvlid, $difficulty, $stars, $featured, $auto, $demon);
        header('Location: ../stats/levelsList.php');
} else {
	die(-1);
}
?>