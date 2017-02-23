<?php
include "connection.php";
require_once "incl/GJPCheck.php";
$GJPCheck = new GJPCheck();
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$gdw = htmlspecialchars($_POST["gdw"],ENT_QUOTES);
if($type == 0){
	$query = "SELECT * FROM friendships WHERE person1 = :accountID OR person2 = :accountID";
}else if($type==1){
	$query = "SELECT * FROM blocks WHERE person1 = :accountID";
}
$query = $db->prepare($query);
$query->execute([':accountID' => $accountID]);
$result = $query->fetchAll();
if($query->rowCount() == 0){
	echo "-2";
}
else
{
	foreach ($result as &$friendship) {
		$person = $friendship["person1"];
		$isnew = $friendship["isNew1"];
		$p = 1;
		if($friendship["person1"] == $accountID){
			$person = $friendship["person2"];
			$isnew = $friendship["isNew2"];
			$p = 2;
		}
		$query = "SELECT * FROM users WHERE extID = :person";
		$query = $db->prepare($query);
		$query->execute([':person' => $person]);
		$result2 = $query->fetchAll();
		$user = $result2[0];
		$gjpresult = $GJPCheck->check($gjp,$accountID);
		if($gjpresult == 1){
			echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$person.":18:0:41:".$isnew."|";
			$query = "UPDATE friendships SET isNew".$p." = '0' WHERE ID = :ID";
			$query = $db->prepare($query);
			$query->execute([':ID' => $friendship["ID"]]);
		}else{echo "-1";}
	}
}
?>
