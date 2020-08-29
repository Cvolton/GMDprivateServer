<?php
chdir(dirname(__FILE__));
//error_reporting(0);
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php"; //this is connection.php too
$gs = new mainLib();
$gjp = $ep->remove($_POST["gjp"]);
$accountID = $ep->remove($_POST["accountID"]);
if($accountID != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		if ($gs->getMaxValuePermission($accountID,"actionRequestMod") == 1) { // checks if they have mod
		$permState = $gs->getMaxValuePermission($accountID,"modBadgeLevel"); // checks mod badge level so it knows what to show					   
		if ($permState >= 2){ // if the mod badge level is higher than 2, it will still show elder mod message
			exit("2");
		}
		echo $permState; 
	}
}else{
		echo -1; 
	}
}else{
	echo -1;
}
?>
