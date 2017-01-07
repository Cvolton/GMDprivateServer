<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$GJPCheck = new GJPCheck();
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
	$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$account = $result[0];
	$friendlist = $account["friends"];
	$friendsarray = explode(',',$friendlist);
	$friends = count($friendsarray);
	for ($x = 0; $x < $friends; $x++) {
		$currentfriend = $friendsarray[$x];
		$query = "SELECT * FROM users WHERE extID = '$currentfriend'";
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();
		$user = $result[0];
		$gjpresult = $GJPCheck->check($gjp,$accountID);
		if($gjpresult == 1){
			echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$currentfriend.":18:0:41:|";
		}else{echo "-1";}
	}
?>