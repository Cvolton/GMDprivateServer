<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = explode("(", explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$isSender = explode("(", explode(";", htmlspecialchars($_POST["isSender"],ENT_QUOTES))[0])[0];
$accountID = explode("(", explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
$targetAccountID = explode("(", explode(";", htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES))[0])[0];
//REMOVING THE REQUEST
if($isSender == 1){
		$query = $db->prepare("DELETE from friendreqs WHERE accountID='$accountID' AND toAccountID='$targetAccountID' LIMIT 1");
}else{
		$query = $db->prepare("DELETE from friendreqs WHERE toAccountID='$accountID' AND accountID='$targetAccountID' LIMIT 1");
}
$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$accountID);
if($gjpresult == 1){
	$query->execute();
	//RESPONSE SO IT DOESNT SAY "FAILED"
	echo "1";
}else{
	//OR YOU KNOW WHAT LETS MAKE IT SAY "FAILED"
	echo "-1";
}
?>