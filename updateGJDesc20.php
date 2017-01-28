<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$levelDesc = htmlspecialchars($_POST["levelDesc"],ENT_QUOTES);
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
if($_POST["udid"]){
	$id = htmlspecialchars($_POST["udid"],ENT_QUOTES);
	$registered = 0;
}else{
	$id = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
	$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
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