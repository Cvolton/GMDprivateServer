<?php
chdir(dirname(__FILE__));
//error_reporting(0);
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php"; //mainlib is also connection.php
$gs = new mainLib();
$gjp = $ep->remove($_POST["gjp"]);
$id = $ep->remove($_POST["accountID"]);
if($id != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		if ($gs->getMaxValuePermission($id,"actionRequestMod") == 1) { // checks if they have mod
		$permState = $gs->getMaxValuePermission($id,"modBadgeLevel"); // checks mod badge level so it knows what to show
		if ($permState >= 2){ // if the mod badge level is higher than 2, it will still show elder mod message
			exit("2");
		}
		echo $permState; }
	}else{
		echo -1; 
	}
}else{
	echo -1;
}
?>
