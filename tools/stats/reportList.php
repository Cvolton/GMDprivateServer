<table border="1"><tr><th>LevelID</th><th>Reported</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$array = array();
$query = $db->prepare("SELECT levelID FROM reports");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$report){
	if(!empty($array[$report["levelID"]])){
		$array[$report["levelID"]]++;
	}else{
		$array[$report["levelID"]] = 1;
	}
}
arsort($array);
foreach($array as $id => $count){
	echo "<tr><td>".$id."</td><td>".$count." times</td></tr>";
}
?>
</table>