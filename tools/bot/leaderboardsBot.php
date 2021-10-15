<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
$type = strtolower(ExploitPatch::remove($_GET["type"]));
$page = ExploitPatch::remove($_GET["page"]);
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
	switch($type){
		case "stars":
			$thing = "stars";
			break;
		case "coins":
			$thing = "coins";
			break;
		case "diamonds":
			$thing = "diamonds";
			break;
		case "usrcoins":
			$typename = "User Coins";
			$thing = "userCoins";
			break;
		case "demons":
			$thing = "demons";
			break;
		case "cp":
			$thing = "creatorPoints";
			break;
		case "orbs":
			$thing = "orbs";
			break;
		case "levels":
			$typename = "Completed Levels";
			$thing = "completedLvls";
			break;
		case "friends":
			$thing = "friendsCount";
	}
	$query = "SELECT $thing , userName, extID FROM users WHERE isBanned = '0' ORDER BY $thing DESC LIMIT 10 OFFSET $page";
	if($type == "friends"){
		$query = "SELECT userName, friendsCount, accountID FROM accounts ORDER BY friendsCount DESC LIMIT 10 OFFSET $page";
	}
	$query = $db->prepare($query);
	$query->execute([':page' => $page]);
	$result = $query->fetchAll();
	echo "`#    |        Username | ".str_pad($typename, 16, " ", STR_PAD_LEFT)." | Linked? |`\r\n";
	echo "`-----|-----------------|------------------|---------|`\r\n";
	$xi = $page;
	foreach($result as &$user){
		$query = $db->prepare("SELECT discordID FROM accounts WHERE accountID = :extID");
		if($type == "friends"){
			$query->execute([':extID' => $user["accountID"]]);
		}else{
			$query->execute([':extID' => $user["extID"]]);
		}
		if($query->rowCount() == 0){
			$link = "N/A";
		}else{
			if($query->fetchColumn() == 0){
				$link = "No";
			}else{
				$link = "Yes";
			}
		}
		$xi++;
		$xyz = str_pad($xi, 4, " ", STR_PAD_RIGHT);
		//$date = date("d/m/Y H:i", $user["lastPlayed"]);
		echo "`$xyz | ".str_pad($user["userName"], 15, " ", STR_PAD_LEFT)." | ".str_pad($user[$thing], 16, " ", STR_PAD_LEFT)." | " . str_pad($link, 7, " ", STR_PAD_LEFT) . " |`\r\n";
	}
}else{
	echo "**Command usage: *!top <type> <page>*\r\nValid types are: Stars, Diamonds, Coins, Usrcoins, Demons, CP, Orbs, Levels, Friends**";
}
?>