<table border="1"><tr><th>LevelID</th><th>Reported</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$array = array();
$query = $db->prepare("SELECT levelID FROM reports");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$report){
	$array[$report["levelID"]]++;
}
arsort($array);
foreach($array as $id => $count){
	echo "<tr><td>".$id."</td><td>".$count." times</td></tr>";
}
?>
</table>