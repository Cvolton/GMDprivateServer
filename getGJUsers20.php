<?php
include "connection.php";
$str = htmlspecialchars($_POST["str"], ENT_QUOTES);
	$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
	$usrpagea = $page*10;
	$query = "SELECT * FROM users WHERE userName LIKE CONCAT('%', :str, '%') ORDER BY stars DESC LIMIT $usrpagea,10";
	$query = $db->prepare($query);
	$query->execute([':str' => $str]);
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