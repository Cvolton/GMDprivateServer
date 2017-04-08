<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$type = strtolower($ep->remove($_GET["type"]));
$page = $ep->remove($_GET["page"]);
$page = $db->quote($page);
$page = str_replace("'", "", $page);
if($page == ""){
	$page = 0;
}
$page--;
if($page < 0){
	$page = 0;
}
$page = $page * 10;
if($type =="stars" OR $type == "diamonds" OR $type == "usrcoins" OR $type == "coins" OR $type == "demons" OR $type == "cp" OR $type == "orbs" OR $type == "levels" OR $type == "friends"){
	$typename = $type;
	if($type == "usrcoins"){
		$typename = "User Coins";
	}
	if($type == "levels"){
		$typename = "Completed Levels";
	}
	$query = "SELECT $type , userName FROM users WHERE isBanned = '0' ORDER BY $type DESC LIMIT 10 OFFSET $page";
	if($type == "friends"){
		$query = "SELECT userName, friendsCount FROM accounts ORDER BY friendsCount DESC LIMIT 10 OFFSET $page";
	}
	$query = $db->prepare($query);
	$query->execute([':page' => $page]);
	$result = $query->fetchAll();
	echo "`#    |        Username | ".str_pad($typename, 16, " ", STR_PAD_LEFT)." |`\r\n";
	echo "`-----|-----------------|------------------|`\r\n";
	$xi = $page;
	foreach($result as &$user){
		$xi++;
		$xyz = str_pad($xi, 4, " ", STR_PAD_RIGHT);
		//$date = date("d/m/Y H:i", $user["lastPlayed"]);
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
				break;
			case "friends":
				$thing = $user["friendsCount"];
		}
		echo "`$xyz | ".str_pad($user["userName"], 15, " ", STR_PAD_LEFT)." | ".str_pad($thing, 16, " ", STR_PAD_LEFT)." |`\r\n";
	}
}else{
	echo "**Command usage: *!top <type> <page>*\r\nValid types are: Stars, Diamonds, Coins, Usrcoins, Demons, CP, Orbs, Levels, Friends**";
}
?>