<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$gjp = $ep->remove($_POST["gjp"]);
$id = $ep->remove($_POST["accountID"]);
if($id != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query = $db->prepare("SELECT isAdmin FROM accounts WHERE accountID = :id");
		$query->execute([':id' => $id]);
		$isAdmin = $query->fetchColumn();
		if($isAdmin==1){
			echo 1;
		}else{
			echo -1;
		}
	}else{echo -1;}
}else{echo -1;}
?>