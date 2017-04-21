<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$mainLib = new mainLib();
$ep = new exploitPatch();
//here im getting all the data
$levelDesc = $ep->remove($_POST["levelDesc"]);
$levelID = $ep->remove($_POST["levelID"]);
if($_POST["udid"]){
	$id = $ep->remove($_POST["udid"]);
	if(is_numeric($id)){
		exit("-1");
	}
}else{
	$id = $ep->remove($_POST["accountID"]);
	$gjp = $ep->remove($_POST["gjp"]);
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult != 1){
		exit("-1");
	}
}
$userID = $mainLib->getUserID($id, $userName);
//query
$query = $db->prepare("UPDATE levels SET levelDesc=:levelDesc WHERE levelID=:levelID AND userID=:userID");
$GJPCheck = new GJPCheck();
$query->execute([':levelID' => $levelID, ':userID' => $userID, ':levelDesc' => $levelDesc]);
echo 1;
?>