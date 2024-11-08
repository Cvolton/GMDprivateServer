<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
$dl = new dashboardLib();
$levelID = ExploitPatch::number($_POST["level"]);
$stars = ExploitPatch::number($_POST["rateStars"]) ?: 0;
$featured = ExploitPatch::number($_POST["featured"]) ?: 0;
if(empty($levelID) || $stars > 10 || $stars < 0) header('Location: '.$_SERVER['HTTP_REFERER']);
$difficulty = $gs->getDiffFromStars($stars);
if($gs->checkPermission($_SESSION["accountID"], "actionRateStars")) {
  	$gs->featureLevel($_SESSION["accountID"], $levelID, $featured);
  	$gs->verifyCoinsLevel($_SESSION["accountID"], $levelID, 1);
  	$gs->rateLevel($_SESSION["accountID"], $levelID, $stars, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"]);
} elseif($gs->checkPermission($_SESSION["accountID"], "actionSuggestRating")) $gs->suggestLevel($_SESSION["accountID"], $levelID, $difficulty["diff"], $stars, $featured, $difficulty["auto"], $difficulty["demon"]);
header('Location: '.$_SERVER['HTTP_REFERER']);
?>