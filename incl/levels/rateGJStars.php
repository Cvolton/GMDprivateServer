<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp = ExploitPatch::remove($_POST["gjp"]);
$stars = ExploitPatch::remove($_POST["stars"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$accountID = GJPCheck::getAccountIDOrDie();
$permState = $gs->checkPermission($accountID, "actionRateStars");
if($permState){
	$difficulty = $gs->getDiffFromStars($stars);
	$gs->rateLevel($accountID, $levelID, 0, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"]);
}
echo 1;