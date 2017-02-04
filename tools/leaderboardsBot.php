<?php
//error_reporting(0);
include "../connection.php";
$type = strtolower(htmlspecialchars($_GET["type"],ENT_QUOTES));
$page = htmlspecialchars($_GET["page"],ENT_QUOTES);
$page = $db->quote($page);
$page = str_replace("'", "", $page);
if($page == ""){
	$page = 0;
}
$page--;
if($page == -1){
	$page = 0;
}
$page = $page * 10;
if($type =="stars" OR $type == "diamonds" OR $type == "usrcoins" OR $type == "coins" OR $type == "demons" OR $type == "cp"){
	if($type == "stars"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY stars DESC LIMIT 10 OFFSET $page";
	}
	if($type == "coins"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY coins DESC LIMIT 10 OFFSET $page";
	}
	if($type == "diamonds"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY diamonds DESC LIMIT 10 OFFSET $page";
	}
	if($type == "usrcoins"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY userCoins DESC LIMIT 10 OFFSET $page";
	}
	if($type == "demons"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY demons DESC LIMIT 10 OFFSET $page";
	}
	if($type == "cp"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY creatorPoints DESC LIMIT 10 OFFSET $page";
	}
	$query = $db->prepare($query);
	$query->execute([':page' => $page]);
	$result = $query->fetchAll();
	$people = $query->rowCount();
	$xy = 1;
	echo "`#    |        Username | Stars | Diamonds | Coins | User coins | Demons |  CP  |`\r\n";
	for ($x = 0; $x < $people; $x++) {
		$user = $result[$x];
		$xi = $x + $xy + $page;
		$xyz = str_pad($xi, 4, " ", STR_PAD_RIGHT);
		echo "`$xyz | ".str_pad($user["userName"], 15, " ", STR_PAD_LEFT)." | ".str_pad($user["stars"], 5, " ", STR_PAD_LEFT)." | ".str_pad($user["diamonds"], 8, " ", STR_PAD_LEFT)." | ".str_pad($user["coins"], 5, " ", STR_PAD_LEFT)." | ".str_pad($user["userCoins"], 10, " ", STR_PAD_LEFT)." | ".str_pad($user["demons"], 6, " ", STR_PAD_LEFT)." | ".str_pad($user["creatorPoints"], 4, " ", STR_PAD_LEFT)." |`\r\n";
	}
}else{
	echo "**Command usage: *!top <type> <page>*\r\nValid types are: Stars, Diamonds, Coins, Usrcoins, Demons, CP**";
}
?>