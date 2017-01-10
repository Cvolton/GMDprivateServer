<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = explode("|", explode("~", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$id = explode("|", explode("~", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
$query2 = $db->prepare("SELECT * FROM users WHERE extID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();

$query = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
if($id != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute([':id' => $id]);
		$result = $query->fetchAll();
		$accinfo = $result[0];
		if($accinfo["isAdmin"]==1){
			echo 1;
		}else{
			echo -1;
		}
	}else{echo -1;}
}else{echo -1;}
?>