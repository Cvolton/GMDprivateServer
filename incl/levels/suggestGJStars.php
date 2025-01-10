<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$stars = ExploitPatch::remove($_POST["stars"]);
$feature = ExploitPatch::remove($_POST["feature"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$accountID = GJPCheck::getAccountIDOrDie();
$difficulty = $gs->getDiffFromStars($stars);
if($gs->checkPermission($accountID, "actionRateStars")) {
	$gs->featureLevel($accountID, $levelID, $feature);
	$gs->verifyCoinsLevel($accountID, $levelID, 1);
	$gs->rateLevel($accountID, $levelID, $stars, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"]);
	exit('1');
} elseif($gs->checkPermission($accountID, "actionSuggestRating")) {
	$gs->suggestLevel($accountID, $levelID, $difficulty["diff"], $stars, $feature, $difficulty["auto"], $difficulty["demon"]);
	exit('1');
} else exit('-2');
?>