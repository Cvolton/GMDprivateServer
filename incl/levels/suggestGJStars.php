<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp = $ep->remove($_POST["gjp"]);
$stars = $ep->remove($_POST["stars"]);
$feature = $ep->remove($_POST["feature"]);
$levelID = $ep->remove($_POST["levelID"]);
$accountID = $ep->remove($_POST["accountID"]);
if($accountID != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$difficulty = $gs->getDiffFromStars($stars);
		$permRate = $gs->checkPermission($accountID, "actionRateStars");
		$permSuggest = $gs->checkPermission($accountID, "actionRequestMod");
		if($permRate){
			$gs->rateLevel($accountID, $levelID, $stars, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"]);
			$gs->featureLevel($accountID, $levelID, $feature);
			$gs->verifyCoinsLevel($accountID, $levelID, 1);
			echo 1;
		}else if(!$permRate && $permSuggest){
			$gs->suggestLevel($accountID, $levelID, $difficulty["diff"], $stars, $feature, $difficulty["auto"], $difficulty["demon"]);
			echo 1;
		}else{
			echo -1;
		}
	}else{
		echo -1;
	}
}else{
	echo -1;
}
?>
