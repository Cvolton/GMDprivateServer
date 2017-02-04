<h1>Actions Count</h1>
<table border="1">
<tr><th>Moderator</th><th>Count</th><th>Levels rated</th><th>Last time online</th></tr>
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
	$time = date("d/m/Y G:i", $result2["lastPlayed"]);
	$query = $db->prepare("SELECT * FROM modactions WHERE account = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$actionscount = $query->rowCount();
	$query = $db->prepare("SELECT * FROM modactions WHERE account = :id AND type = '1'");
	$query->execute([':id' => $mod["accountID"]]);
	$lvlcount = $query->rowCount();
	echo "<tr><td>".$mod["userName"]."</td><td>".$actionscount."</td><td>".$lvlcount."</td><td>".$time."</td></tr>";
}
?>
</table>
<h1>Actions Log</h1>
<table border="1"><tr><th>Moderator</th><th>Action</th><th>Value</th><th>Value2</th><th>LevelID</th><th>Time</th></tr>
<?php
$query = $db->prepare("SELECT * FROM modactions ORDER BY ID DESC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$action){
	//detecting mod
	$account = $action["account"];
	$query = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
	$query->execute([':id'=>$account]);
	$result2 = $query->fetchAll();
	$account = $result2[0]["userName"];
	//detecting action
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
		}
	$value = $action["value"];
	if($action["type"] == 2 OR $action["type"] == 3 OR $action["type"] == 4){
		if($action["value"] == 1){
			$value = "True";
		}else{
			$value = "False";
		}
	}
	if($action["type"] == 5 OR $action["type"] == 6){
		$value = "";
	}
	$time = date("d/m/Y G:i", $action["timestamp"]);
	echo "<tr><td>".$account."</td><td>".$actionname."</td><td>".$value."</td><td>".$action["value2"]."</td><td>".$action["value3"]."</td><td>".$time."</td></tr>";
}
?>
</table>