<table border="1"><tr><th>LevelID</th><th>Level Name</th><th>Reported</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$array = array();
$query = $db->prepare("SELECT levels.levelID, levels.levelName, count(*) AS reportsCount FROM reports INNER JOIN levels ON reports.levelID = levels.levelID GROUP BY levels.levelID ORDER BY reportsCount DESC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$report){
	$levelName = htmlspecialchars($report['levelName'], ENT_QUOTES);
	echo "<tr><td>${report['levelID']}</td><td>$levelName</td><td>${report['reportsCount']} times</td></tr>";
}
?>
</table>