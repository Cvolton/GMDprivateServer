<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$GJPCheck = new GJPCheck();
$accountID = explode("(", explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
$gjp = explode("(", explode(";", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0];
$type = explode("(", explode(";", htmlspecialchars($_POST["type"],ENT_QUOTES))[0])[0];
	$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$account = $result[0];
	if($type == 0){
		$usrlist = $account["friends"];
	}else if($type==1){
		$usrlist = $account["blocked"];
	}
	if($usrlist == ""){
		echo "-2";
	}
	else
	{
		$usrsarray = explode(',',$usrlist);
		$usrs = count($usrsarray);
	}
	for ($x = 0; $x < $usrs; $x++) {
				$currentfriend = $usrsarray[$x];
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