<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp2check = isset($_POST['gjp2']) ? $_POST['gjp2'] : $_POST['gjp'];
$gjp = ExploitPatch::remove($gjp2check);
$stars = ExploitPatch::remove($_POST["stars"]);
$feature = ExploitPatch::remove($_POST["feature"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$accountID = GJPCheck::getAccountIDOrDie();
$difficulty = $gs->getDiffFromStars($stars);
if($gs->checkPermission($accountID, "actionRateStars")) {
	$gs->featureLevel($accountID, $levelID, $feature);
	$gs->verifyCoinsLevel($accountID, $levelID, 1);
	$gs->rateLevel($accountID, $levelID, $stars, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"], $feature);
	$query = $db->prepare("DELETE FROM suggest WHERE suggestLevelId = ?");
	$query->execute([$levelID]);
	echo 1;
} elseif($gs->checkPermission($accountID, "actionSuggestRating")) {
	$currentTimestamp = time();
	$gs->suggestLevel($accountID, $levelID, $difficulty["diff"], $stars, $feature, $difficulty["auto"], $difficulty["demon"]);
	$query = $db->prepare("INSERT INTO modactions (type, value, value3, account, timestamp) VALUES ('41', :value, :value3, :id, :timestamp)");
	$query->execute([':value' => $stars, ':value3' => $levelID, ':id' => $accountID, ':timestamp' => $currentTimestamp]);
	echo 1;
} else echo -2;
?>
