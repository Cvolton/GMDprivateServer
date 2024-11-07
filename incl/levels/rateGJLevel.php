<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$rating = ExploitPatch::number($_POST["rating"]);
$levelID = ExploitPatch::numbercolon($_POST["levelID"]);
$accountID = $gs->getIDFromPost();
$permState = $gs->checkPermission($accountID, "actionRateStars");
if($permState) {
	$difficulty = $gs->getDiffFromRating($rating);
	$gs->changeDifficulty($accountID, $levelID, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"]);
}
echo 1;