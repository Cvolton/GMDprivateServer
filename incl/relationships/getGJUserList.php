<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
include_once "../lib/mainLib.php";
$gs = new mainLib();
if(!isset($_POST["type"]) OR !is_numeric($_POST["type"])){
	exit("-1");
}
$accountID = GJPCheck::getAccountIDOrDie();
$type = ExploitPatch::remove($_POST["type"]);
$people = "";
$peoplestring = "";
$new = array();
if($type == 0){
	$query = "SELECT person1,isNew1,person2,isNew2 FROM friendships WHERE person1 = :accountID OR person2 = :accountID";
}else if($type==1){
	$query = "SELECT person1,person2 FROM blocks WHERE person1 = :accountID";
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
		if($friendship["person1"] == $accountID){
			$person = $friendship["person2"];
			$isnew = $friendship["isNew2"];
		}
		$new[$person] = $isnew;
		$people .= $person . ",";
	}
	$people = substr($people, 0,-1);
	$query = $db->prepare("SELECT userName, userID, icon, color1, color2, iconType, special, extID, clan FROM users WHERE extID IN ($people) ORDER BY userName ASC");
	$query->execute();
	$result = $query->fetchAll();
	foreach($result as &$user) {
		$user["userName"] = $gs->makeClanUsername($user);
		$user['extID'] = is_numeric($user['extID']) ? $user['extID'] : 0;
		$peoplestring .= "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["extID"].":18:0:41:".$new[$user["extID"]]."|";
	}
	$peoplestring = substr($peoplestring, 0, -1);
	$query = $db->prepare("UPDATE friendships SET isNew1 = '0' WHERE person2 = :me");
	$query->execute([':me' => $accountID]);
	$query = $db->prepare("UPDATE friendships SET isNew2 = '0' WHERE person1 = :me");
	$query->execute([':me' => $accountID]);
	if($peoplestring == ""){
		exit("-1");
	}
	echo $peoplestring;
}
?>