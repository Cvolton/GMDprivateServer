<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$mS = htmlspecialchars($_POST["mS"],ENT_QUOTES);
$frS = htmlspecialchars($_POST["frS"],ENT_QUOTES);
$youtubeurl = htmlspecialchars($_POST["yt"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
//query
$query = $db->prepare("UPDATE accounts SET mS='$mS', frS='$frS', youtubeurl='$youtubeurl' WHERE accountID = '$accountID'");
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query->execute();
	echo 1;
}else{
	echo -1;
}
?>