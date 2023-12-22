<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp2check = isset($_POST['gjp2']) ? $_POST['gjp2'] : $_POST['gjp'];
if(!isset($gjp2check) OR !isset($_POST["rating"]) OR !isset($_POST["levelID"]) OR !isset($_POST["accountID"])){
	exit("-1");
}
$gjp = ExploitPatch::remove($gjp2check);
$rating = ExploitPatch::remove($_POST["rating"]);
$levelID = ExploitPatch::remove($_POST["levelID"]);
$id = GJPCheck::getAccountIDOrDie();
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
