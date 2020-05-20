<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$ep = new exploitPatch();
if(!isset($_POST["gjp"]) OR !isset($_POST["rating"]) OR !isset($_POST["levelID"]) OR !isset($_POST["accountID"])){
	exit("-1");
}
$gjp = $ep->remove($_POST["gjp"]);
$rating = $ep->remove($_POST["rating"]);
$levelID = $ep->remove($_POST["levelID"]);
$id = $ep->remove($_POST["accountID"]);
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$id);
if($gjpresult == 1){
	$gs->voteLevel($id, $levelID, 50, ((int) $rating)*10);
	echo $levelID;
	return;
}
echo "-1";
?>