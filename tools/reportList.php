<table border="1"><tr><th>LevelID</th><th>Reported</th></tr>
<?php
//error_reporting(0);
include "../connection.php";
$array = array();
$query = $db->prepare("SELECT * FROM reports");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$report){
	if(!in_array($report["levelID"], $array)){
		$query = $db->prepare("SELECT * FROM reports WHERE levelID = :levelID");
		$query->execute([':levelID' => $report["levelID"]]);
		$count = $query->rowCount();
		echo "<tr><td>".$report["levelID"]."</td><td>".$count." times</td></tr>";
		$array[] = $report["levelID"];
	}
}
?>
</table>