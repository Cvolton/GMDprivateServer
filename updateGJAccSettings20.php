<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
//here im getting all the data
$mS = explode("(", explode(";", htmlspecialchars($_POST["mS"],ENT_QUOTES))[0])[0];
$frS = explode("(", explode(";", htmlspecialchars($_POST["frS"],ENT_QUOTES))[0])[0];
$youtubeurl = explode("(", explode(";", htmlspecialchars($_POST["yt"],ENT_QUOTES))[0])[0];
$gjp = explode("(", explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$accountID = explode("(", explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
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