<!DOCTYPE HTML>
<html>
	<head>
		<title>Mod Actions</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">
<?php

include "../../incl/lib/connection.php";

$types_ = array('1' => "Rated a level",
				'2' => "Featured change",
				'3' => "Coins verification state",
				'4' => "Epic change",
				'5' => "Set as daily feature",
				'6' => "Deleted a level",
				'7' => "Creator change",
				'8' => "Renamed a level",
				'9' => "Changed level password",
				'10' => "Changed demon difficulty",
				'11' => "Shared CP",
				'12' => "Changed level publicity",
				'13' => "Changed level description",
				'14' => "Changed level CP reward");

$query = $db->prepare("SELECT * FROM modactions ORDER BY ID DESC");
$query->execute();
$result = $query->fetchAll();

$exMods = array();
$currentMods = array();

foreach ($result as $action)
{
	$id = $action['account'];
	
	if (!array_key_exists($id, $exMods))
	{
		$queryName = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
		$queryName->execute([':id' => $id]);
		$exMods[$id] = $queryName->fetchAll()[0];
		$exMods[$id]['rateCount'] = 0;
		$exMods[$id]['actionCount'] = 0;
	}
	else
	{
		$exMods[$id]['actionCount']++;
		
		if ($action['type'] == 1)
		{
			$exMods[$id]['rateCount']++;
		}
	}
}

$query = $db->prepare("SELECT * FROM accounts WHERE isAdmin = 1");
$query->execute();
$result2 = $query->fetchAll();

foreach ($result2 as $account)
{
	$id = $account['accountID'];
	
	if (array_key_exists($id, $exMods))
	{
		$currentMods[$id] = $exMods[$id];
		unset($exMods[$id]);
	}
	else
	{
		$queryName = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
		$queryName->execute([':id' => $id]);
		$currentMods[$id] = $queryName->fetchAll()[0];
	}
}

echo '<h1>Admins</h1><table><tr><th>Username</th><th>AccountID</th><th>Actions</th><th>Rated Levels</th></tr>';

foreach ($currentMods as $mod)
{
	if ($mod['isHeadAdmin'] == 1)
	{
		echo "<tr><td>".$mod['userName']."</td><td>".$mod['accountID']."</td><td>".$mod['actionCount']."</td><td>".$mod['rateCount']."</td></tr>";
	}
}

echo '</table><h1>Moderators</h1><table><tr><th>Username</th><th>AccountID</th><th>Actions</th><th>Rated Levels</th></tr>';

foreach ($currentMods as $mod)
{
	if ($mod['isHeadAdmin'] == 0)
	{
		echo "<tr><td>".$mod['userName']."</td><td>".$mod['accountID']."</td><td>".$mod['actionCount']."</td><td>".$mod['rateCount']."</td></tr>";
	}
}

echo '</table><h1>Ex-Moderators</h1><table><tr><th>Username</th><th>AccountID</th><th>Actions</th><th>Rated Levels</th></tr>';

foreach ($exMods as $mod)
{
	if ($mod['rateCount'] != 0 AND !empty($mod['userName']))
	{
		echo "<tr><td>".$mod['userName']."</td><td>".$mod['accountID']."</td><td>".$mod['actionCount']."</td><td>".$mod['rateCount']."</td></tr>";
	}
}

echo '</table><h1>Actions</h1><table><tr><th>Username</th><th>Type</th><th>LevelID</th><th>Value</th><th>Value2</th><th>Time</th></tr>';

foreach ($result as $action)
{
	$username = array_key_exists($action['account'], $exMods) ? $exMods[$action['account']]['userName'] : $currentMods[$action['account']]['userName'];
	$type = $types_[$action['type']];
	$levelid = $action["value3"];
	$value1 = $action["value"];
	$value2 = $action["value2"];
	$time = date("d/m/Y G:i:s", $action["timestamp"]);
	
	echo "<tr><td>$username</td><td>$type</td><td>$levelid</td><td>$value1</td><td>$value2</td><td>$time</td></tr>";
}

?>			
			</table>
		</div>
	</body>
</html>