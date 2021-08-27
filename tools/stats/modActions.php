<h1>Actions Count</h1>
<table border="1">
<tr><th>Moderator</th><th>Count</th><th>Levels rated</th><th>Last time online</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
$accounts = implode(",",$gs->getAccountsWithPermission("toolModactions"));
if($accounts == ""){
	exit("Error: No accounts with the 'toolModactions' permission have been found");
}
$query = $db->prepare("SELECT accounts.accountID, accounts.userName, users.lastPlayed FROM accounts INNER JOIN users ON users.extID = accounts.accountID WHERE accountID IN ($accounts) ORDER BY userName ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$mod){
	$time = date("d/m/Y G:i:s", $mod['lastPlayed']);
	//TODO: optimize the count queries
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$actionscount = $query->fetchColumn();
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id AND type = '1'");
	$query->execute([':id' => $mod["accountID"]]);
	$lvlcount = $query->fetchColumn();
	echo "<tr><td>${mod["userName"]}</td><td>${actionscount}</td><td>${lvlcount}</td><td>${time}</td></tr>";
}
?>
</table>
<h1>Actions Log</h1>
<table border="1"><tr><th>Moderator</th><th>Action</th><th>Value</th><th>Value2</th><th>LevelID</th><th>Time</th></tr>
<?php
$query = $db->prepare("SELECT modactions.*, accounts.userName FROM modactions INNER JOIN accounts ON modactions.account = accounts.accountID ORDER BY ID DESC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$action){
	//detecting mod
	/*$account = $action["account"];
	$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :id");
	$query->execute([':id'=>$account]);
	$account = $query->fetchColumn();*/
	//detecting action
	$value = $action["value"];
	$value2 = $action["value2"];
	$account = $action["userName"];
	switch($action["type"]){
		case 1:
			$actionname = "Rated a level";
			break;
		case 2:
			$actionname = "Featured change";
			break;
		case 3:
			$actionname = "Coins verification state";
			break;
		case 4:
			$actionname = "Epic change";
			break;
		case 5:
			$actionname = "Set as daily feature";
			if(is_numeric($value2)){
				$value2 = date("d/m/Y G:i:s", $value2);
			}
			break;
		case 6:
			$actionname = "Deleted a level";
			break;
		case 7:
			$actionname = "Creator change";
			break;
		case 8:
			$actionname = "Renamed a level";
			break;
		case 9:
			$actionname = "Changed level password";
			break;
		case 10:
			$actionname = "Changed demon difficulty";
			break;
		case 11:
			$actionname = "Shared CP";
			break;
		case 12:
			$actionname = "Changed level publicity";
			break;
		case 13:
			$actionname = "Changed level description";
			break;
		case 15:
			$actionname = "Un/banned a user";
			break;
		case 16:
			$actionname = "Song ID change";
			break;
		default:
			$actionname = $action["type"];
			break;
		}
	if($action["type"] == 2 OR $action["type"] == 3 OR $action["type"] == 4 OR $action["type"] == 15){
		if($action["value"] == 1){
			$value = "True";
		}else{
			$value = "False";
		}
	}
	if($action["type"] == 5 OR $action["type"] == 6){
		$value = "";
	}
	$time = date("d/m/Y G:i:s", $action["timestamp"]);
	if($action["type"] == 5 AND $action["value2"] > time()){
		echo "<tr><td>".$account."</td><td>".$actionname."</td><td>".$value."</td><td>".$value2."</td><td>future</td><td>".$time."</td></tr>";
	}else{
		echo "<tr><td>".$account."</td><td>".$actionname."</td><td>".$value."</td><td>".$value2."</td><td>".$action["value3"]."</td><td>".$time."</td></tr>";
	}
	
}
?>
</table>