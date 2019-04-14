<h1>MAP PACKS</h1>
<table border="1"><tr><th>#</th><th>ID</th><th>Map Pack</th><th>Stars</th><th>Coins</th><th>Levels</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$x = 1;
$query = $db->prepare("SELECT * FROM mappacks ORDER BY ID ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$pack){
	$lvlarray = explode(",", $pack["levels"]);
	echo "<tr><td>$x</td><td>".$pack["ID"]."</td><td>".htmlspecialchars($pack["name"],ENT_QUOTES)."</td><td>".$pack["stars"]."</td><td>".$pack["coins"]."</td><td>";
	$x++;
	foreach($lvlarray as &$lvl){
		echo $lvl . " - ";
		$query = $db->prepare("SELECT levelName FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$levelName = $query->fetchColumn();
		echo $levelName . ", ";
	}
	echo "</td></tr>";
}
/*
	GAUNTLETS
*/
?>
</table>