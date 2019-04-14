<!DOCTYPE HTML>
<html>
	<head>
		<title>New Session</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">
			<table><tr><th>#</th><th>Map Pack</th><th>Stars</th><th>Coins</th><th>Levels</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$x = 1;
$query = $db->prepare("SELECT * FROM mappacks ORDER BY ID ASC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$pack){
	$lvlarray = explode(",", $pack["levels"]);
	echo "<tr><td>$x</td><td>".htmlspecialchars($pack["name"],ENT_QUOTES)."</td><td>".$pack["stars"]."</td><td>".$pack["coins"]."</td><td>";
	$x++;
	$tmp = "";
	foreach($lvlarray as &$lvl){
		echo $lvl . " - ";
		$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$result2 = $query->fetchAll();
		$tmp .= $result2[0]["levelName"] . ", ";
	}
	echo substr($tmp, 0, -2);
	echo "</td></tr>";
}
?>
			</table>
		</div>
	</body>
</html>