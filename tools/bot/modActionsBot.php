Mod actions:
`|            Name | Actions count | Levels count | Last time online | Linked? |`
`|-----------------|---------------|--------------|------------------|---------|`
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT roleID FROM roles WHERE toolModactions = 1 ORDER BY priority DESC");
$query->execute();
$result = $query->fetchAll();
$accountlist = array();
foreach($result as &$role){
	$query = $db->prepare("SELECT accountID FROM roleassign WHERE roleID = :roleID");
	$query->execute([':roleID' => $role["roleID"]]);
	$accounts = $query->fetchAll();
	foreach($accounts as &$user){
		$accountlist[] = $user["accountID"];
	}
}
$accountlist = implode(",", $accountlist);
$query = $db->prepare("SELECT accountID,userName,discordID FROM accounts WHERE accountID IN($accountlist)");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$mod){
	if($mod["discordID"] == 0){
		$link = "No";
	}else{
		$link = "Yes";
	}
	$query = $db->prepare("SELECT lastPlayed FROM users WHERE extID = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$time = date("d/m/Y H:i", $query->fetchColumn());
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$actionscount = $query->fetchColumn();
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id AND type = '1'");
	$query->execute([':id' => $mod["accountID"]]);
	$lvlcount = $query->fetchColumn();
	echo "`| ".str_pad($mod["userName"], 15, " ", STR_PAD_LEFT)." | ".str_pad($actionscount, 13, " ", STR_PAD_LEFT)." | ".str_pad($lvlcount, 12, " ", STR_PAD_LEFT)." | ".$time." | ". str_pad($link, 7, " ", STR_PAD_LEFT)." |`\r\n";
}
?>
