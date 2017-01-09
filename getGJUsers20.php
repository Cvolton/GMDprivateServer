<?php
include "connection.php";
$str = explode("(", explode(";", htmlspecialchars($_POST["str"], ENT_QUOTES))[0])[0];
	$page = explode("(", explode(";", htmlspecialchars($_POST["page"],ENT_QUOTES))[0])[0];
	$usrpagea = $page*10;
	$usrpageaend = $usrpagea +9;
	$query = "SELECT * FROM users WHERE userName LIKE '".$str."%' ORDER BY stars DESC LIMIT ".$usrpagea.",".$usrpageaend."";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$usercount = $query->rowCount();
	for ($x = 0; $x < $usercount; $x++) {
	$usrpage = 0;
	$user = $result[$usrpage+$x];
		if($x != 0){
		echo "|";
	}
	$xi = $x + 1;
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["extID"].":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"]."";
	if (array_key_exists(8,$result)){
		echo "#9999:".$usrpagea.":10";
	}else{
		$totalusrcount = $usrpagea+$levelcount;
		echo "#".$totalusrcount.":".$usrpagea.":10";
	}
	}
?>