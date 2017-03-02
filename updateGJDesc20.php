<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$levelDesc = $ep->remove($_POST["levelDesc"]);
$levelID = $ep->remove($_POST["levelID"]);
if($_POST["udid"]){
	$id = $ep->remove($_POST["udid"]);
	$registered = 0;
}else{
	$id = $ep->remove($_POST["accountID"]);
	$gjp = $ep->remove($_POST["gjp"]);
	$registered = 1;
}
$query = $db->prepare("SELECT userID FROM users WHERE extID = :id");
$query->execute([':id'=>$id]);
$userID = $query->fetchAll();
$userID = $userID[0];
$userID = $userID["userID"];
//query
$query = $db->prepare("UPDATE levels SET levelDesc=:levelDesc WHERE levelID=:levelID AND userID=:userID");
$GJPCheck = new GJPCheck();
if($registered == 1){
	$gjpresult = $GJPCheck->check($gjp,$id);
}else{
	$gjpresult = 1;
}
if($gjpresult == 1){
	$query->execute([':levelID' => $levelID, ':userID' => $userID, ':levelDesc' => $levelDesc]);
	echo 1;
}else{
	echo -1;
}
?>