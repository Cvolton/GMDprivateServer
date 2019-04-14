<!DOCTYPE HTML>
<html>
	<head>
		<title>Reported Levels</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">
			<table><tr><th>LevelID</th><th>Reported</th></tr>
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
	echo "<tr><td>".$id."</td><td>".$count." time".($count == 1 ? "" : "s")."</td></tr>";
}
?>
			</table>
		</div>
	</body>
</html>