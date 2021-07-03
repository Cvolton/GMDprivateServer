<h1>Actions Count</h1>
<table border="1">
<tr><th>Moderator</th><th>Count</th><th>Levels suggested</th><th>Levels rated</th><th>Last time online</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
$accounts = implode(",",$gs->getAccountsWithPermission("toolModactions"));
if($accounts == ""){
	exit("Error: No accounts with the 'toolModactions' permission have been found");
}
$query = $db->prepare("SELECT accountID, userName FROM accounts WHERE accountID IN ($accounts) ORDER BY userName ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$mod){
	$query = $db->prepare("SELECT lastPlayed FROM users WHERE extID = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$time = date("d/m/Y G:i:s", $query->fetchColumn());
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$actionscount = $query->fetchColumn();
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id AND type = '1'");
	$query->execute([':id' => $mod["accountID"]]);
	$lvlcount = $query->fetchColumn();
	$query = $db->prepare("SELECT count(*) FROM suggest WHERE suggestBy = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$suggestcount = $query->fetchColumn();
	$actionscount += $suggestcount;
	echo "<tr><td>".$mod["userName"]."</td><td>".$actionscount."</td><td>".$suggestcount."</td><td>".$lvlcount."</td><td>".$time."</td></tr>";
}
?>
</table>
<h1>Actions Log</h1>
<form action="modActions.php" method="post">
	Search: <input type="text" name="field" placeholder="Enter field">
	<br>Search Type: <select name="type">
		<option value="1">Moderator</option>
		<option value="2">Level ID</option>
	</select>
	<br>Sort By: <select name="order">
		<option value="1">Newest</option>
		<option value="2">Oldest</option>
	</select>
	<input type="submit" value="Search">
</form>
<table border="1"><tr><th>Moderator</th><th>Action</th><th>Value</th><th>Value2</th><th>LevelID</th><th>Time</th></tr>
<?php
require "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
if (!empty($_POST['type'])) {
	$type = $ep->number($_POST['type']);
} else {
	$type = 2;
}
switch ($type) {
	case 1:
		$searchType = "account";
		break;
	case 2:
		$searchType = "value3";
		break;
	default:
		$searchType = "value3";
		break;
}
if (!empty($_POST['order'])) {
	$order = $ep->number($_POST['order']);
} else {
	$order = 1;
}
switch ($order) {
	case 1:
		$searchOrder = "timestamp DESC";
		break;
	case 2:
		$searchOrder = "timestamp ASC";
		break;
	default:
		$searchOrder = "timestamp DESC";
		break;
}
if (!empty($_POST['field'])) {
	$field = $ep->remove($_POST['field']);
} else {
	$field = "";
}
if($field == ""){
	$query = $db->prepare("SELECT * FROM modactions ORDER BY ".$searchOrder." LIMIT 5000");
}else{
	if($type == 1){
		$query = $db->prepare("SELECT * FROM modactions WHERE ".$searchType." = ".$gs->getAccountIDFromName($field)." ORDER BY ".$searchOrder." LIMIT 5000");
	}else{
		$query = $db->prepare("SELECT * FROM modactions WHERE ".$searchType." = ".$field." AND CASE type WHEN 5 THEN value2 < ".time()." ELSE 1 END ORDER BY ".$searchOrder." LIMIT 5000");
	}
}
$query->execute();
$result = $query->fetchAll();
foreach($result as &$action){
	//detecting mod
	$account = $action["account"];
	$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :id");
	$query->execute([':id'=>$account]);
	$account = $query->fetchColumn();
	//detecting action
	$value = $action["value"];
	$value2 = $action["value2"];
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
