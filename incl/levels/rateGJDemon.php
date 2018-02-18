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
if($gs->checkPermission($id, "actionRateDemon") == false){
	exit("-1");
}
$auto = 0;
$demon = 0;
switch($rating){
	case 1:
		$dmn = 3;
		$dmnname = "Easy";
		break;
	case 2:
		$dmn = 4;
		$dmnname = "Medium";
		break;
	case 3:
		$dmn = 0;
		$dmnname = "Hard";
		break;
	case 4:
		$dmn = 5;
		$dmnname = "Insane";
		break;
	case 5:
		$dmn = 6;
		$dmnname = "Extreme";
		break;
}
$timestamp = time();
$query = $db->prepare("UPDATE levels SET starDemonDiff=:demon WHERE levelID=:levelID");	
$query->execute([':demon' => $dmn, ':levelID'=>$levelID]);
$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('10', :value, :levelID, :timestamp, :id)");
$query->execute([':value' => $dmnname, ':timestamp' => $timestamp, ':id' => $id, ':levelID' => $levelID]);
echo $levelID;
?>