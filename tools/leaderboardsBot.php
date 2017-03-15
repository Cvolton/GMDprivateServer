<?php
//error_reporting(0);
include "../connection.php";
require_once "../incl/exploitPatch.php";
$ep = new exploitPatch();
$type = strtolower($ep->remove($_GET["type"]));
$page = $ep->remove($_GET["page"]);
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
if($type =="stars" OR $type == "diamonds" OR $type == "usrcoins" OR $type == "coins" OR $type == "demons" OR $type == "cp" OR $type == "orbs" OR $type == "levels"){
	$typename = $type;
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
		$typename = "User Coins";
	}
	if($type == "demons"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY demons DESC LIMIT 10 OFFSET $page";
	}
	if($type == "cp"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY creatorPoints DESC LIMIT 10 OFFSET $page";
	}
	if($type == "orbs"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY orbs DESC LIMIT 10 OFFSET $page";
	}
	if($type == "levels"){
		$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY completedLvls DESC LIMIT 10 OFFSET $page";
		$typename = "Completed Levels";
	}
	$query = $db->prepare($query);
	$query->execute([':page' => $page]);
	$result = $query->fetchAll();
	$people = $query->rowCount();
	$xy = 1;
	echo "`#    |        Username | ".str_pad($typename, 16, " ", STR_PAD_LEFT)." |`\r\n";
	echo "`-----|-----------------|------------------|`\r\n";
	for ($x = 0; $x < $people; $x++) {
		$user = $result[$x];
		$xi = $x + $xy + $page;
		$xyz = str_pad($xi, 4, " ", STR_PAD_RIGHT);
		$date = date("d/m/Y H:i", $user["lastPlayed"]);
		switch($type){
			case "stars":
				$thing = $user["stars"];
				break;
			case "coins":
				$thing = $user["coins"];
				break;
			case "diamonds":
				$thing = $user["diamonds"];
				break;
			case "usrcoins":
				$thing = $user["userCoins"];
				break;
			case "demons":
				$thing = $user["demons"];
				break;
			case "cp":
				$thing = $user["creatorPoints"];
				break;
			case "orbs":
				$thing = $user["orbs"];
				break;
			case "levels":
				$thing = $user["completedLvls"];
		}
		echo "`$xyz | ".str_pad($user["userName"], 15, " ", STR_PAD_LEFT)." | ".str_pad($thing, 16, " ", STR_PAD_LEFT)." |`\r\n";
	}
}else{
	echo "**Command usage: *!top <type> <page>*\r\nValid types are: Stars, Diamonds, Coins, Usrcoins, Demons, CP, Orbs, Levels**";
}
?>