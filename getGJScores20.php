<?php
include "connection.php";
$levelsstring = "";
$songsstring  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
if($type == "top"){
	$query = "SELECT * FROM users ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	for ($x = 0; $x < 99; $x++) {
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
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:0:4:".$user["demons"].":7:".$extid;
}
}
?>	