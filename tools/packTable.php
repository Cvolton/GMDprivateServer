<h1>MAP PACKS</h1>
<table border="1"><tr><th>#</th><th>Map Pack</th><th>Stars</th><th>Coins</th><th>Levels</th></tr>
<?php
//error_reporting(0);
include "../connection.php";
$query = $db->prepare("SELECT * FROM mappacks ORDER BY ID ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$pack){
	$lvlarray = explode(",", $pack["levels"]);
	echo "<tr><td>".$pack["ID"]."</td><td>".$pack["name"]."</td><td>".$pack["stars"]."</td><td>".$pack["coins"]."</td><td>";
	foreach($lvlarray as &$lvl){
		echo $lvl . " - ";
		$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$result2 = $query->fetchAll();
		echo $result2[0]["levelName"] . ", ";
	}
	echo "</td></tr>";
}
/*
	GAUNTLETS
*/
?>
</table>
<h1>GAUNTLETS</h1>
<table border="1"><tr><th>#</th><th>Level 1</th><th>Level 2</th><th>Level 3</th><th>Level 4</th><th>Level 5</th></tr>
<?php
//error_reporting(0);
include "../connection.php";
$query = $db->prepare("SELECT * FROM gauntlets ORDER BY ID ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$gauntlet){
	echo "<tr><td>".$gauntlet["ID"]."</td>";
	for ($x = 1; $x < 6; $x++) {
		echo "<td>";
		$lvl = $gauntlet["level".$x];
		echo $lvl . " - ";
		$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$result2 = $query->fetchAll();
		echo $result2[0]["levelName"] . "</td>";
	}
	echo "</tr>";
}
/*
	GAUNTLETS
*/
?>
</table>