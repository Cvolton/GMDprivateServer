<?php
include "connection.php";
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
if($type == "top" OR $type == "creators"){
	if($type == "top"){
	$query = "SELECT * FROM users ORDER BY stars DESC";
	}
	if($type == "creators"){
	$query = "SELECT * FROM users ORDER BY creatorPoints DESC";
	}
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$people = $query->rowCount();
	for ($x = 0; $x < $people; $x++) {
	if($x != 0){
		echo "|";
	}
	$user = $result[$x];
	if(is_numeric($user["extID"])){
		$extid = $user["extID"];
	}else{
		$extid = 0;
	}
$xi = $x + 1;
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"].":7:".$extid;
}
}
if($type == "friends"){
	$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$account = $result[0];
	$friendlist = $account["friends"];
	$whereor = str_replace(",", " OR extID = ", $friendlist);
	$query = "SELECT * FROM users WHERE extID = ".$accountID." OR extID = ".$whereor . " ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$people = $query->rowCount();
	for ($x = 0; $x < $people; $x++) {
	if($x != 0){
		echo "|";
	}
	$user = $result[$x];
	if(is_numeric($user["extID"])){
		$extid = $user["extID"];
	}else{
		$extid = 0;
	}
	$xi = $x + 1;
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"].":7:".$extid;
}
}
?>		