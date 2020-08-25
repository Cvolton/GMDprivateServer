<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp = $ep->remove($_POST["gjp"]);
$id = $ep->remove($_POST["accountID"]);
if($id != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		if ($gs->getMaxValuePermission($id,"actionRequestMod") == 1) { // checks if they have mod
		$permState = $gs->getMaxValuePermission($id,"modBadgeLevel"); // checks mod badge level so it knows what to show
		if ($permState == 0) {
			exit(-1); //fix infinite req loop
		}
		if ($permState != 1 || $permState != 0){ // if the mod badge level is higher than 2, it will still show elder mod badge
			echo 2;
			exit();
		}
		echo $permState; }
	}else{
		echo -1; 
	}
}else{
	echo -1;
}
?>
