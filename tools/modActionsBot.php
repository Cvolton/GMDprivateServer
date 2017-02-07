Mod actions:
`|            Name | Actions count | Levels count | Last time online |`
`|-----------------|---------------|--------------|------------------|`
<?php
//error_reporting(0);
include "../connection.php";
$query = $db->prepare("SELECT * FROM accounts WHERE isAdmin = 1");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$mod){
	$query = $db->prepare("SELECT * FROM users WHERE extID = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$result2 = $query->fetchAll();
	$result2 = $result2[0];
	$time = date("d/m/Y H:i", $result2["lastPlayed"]);
	$query = $db->prepare("SELECT * FROM modactions WHERE account = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$actionscount = $query->rowCount();
	$query = $db->prepare("SELECT * FROM modactions WHERE account = :id AND type = '1'");
	$query->execute([':id' => $mod["accountID"]]);
	$lvlcount = $query->rowCount();
	echo "`| ".str_pad($mod["userName"], 15, " ", STR_PAD_LEFT)." | ".str_pad($actionscount, 13, " ", STR_PAD_LEFT)." | ".str_pad($lvlcount, 12, " ", STR_PAD_LEFT)." | ".$time." |`\r\n";
}
?>
