<h1>Daily Levels</h1>
<table border="1"><tr><th>#</th><th>ID</th><th>Name</th><th>Creator</th><th>Time</tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$x = 1;
$query = $db->prepare("SELECT dailyfeatures.feaID, dailyfeatures.levelID, dailyfeatures.timestamp, levels.levelName, users.userName FROM dailyfeatures INNER JOIN levels ON dailyfeatures.levelID = levels.levelID INNER JOIN users ON levels.userID = users.userID  WHERE timestamp < :time ORDER BY feaID DESC");
$query->execute([':time' => time()]);
$result = $query->fetchAll();
foreach($result as &$daily){
	//basic daily info
	$feaID = $daily["feaID"];
	$levelID = $daily["levelID"];
	$time = $daily["timestamp"];
	$levelName = $daily["levelName"];
	$creator = $daily["userName"];
	echo "<tr><td>$feaID</td><td>$levelID</td>";
	//level name
	/*$query = $db->prepare("SELECT levelName, userID FROM levels WHERE levelID = :level");
	$query->execute([':level' => $levelID]);
	$level = $query->fetch();
	$levelName = $level["levelName"];
	$userID = $level["userID"];*/
	echo "<td>$levelName</td>";
	//creator name
	/*$query = $db->prepare("SELECT userName FROM users WHERE userID = :userID");
	$query->execute([':userID' => $userID]);
	$creator = $query->fetchColumn();*/
	echo "<td>$creator</td>";
	//timestamp
	$time = date("d/m/Y H:i", $time);
	echo "<td>$time</td></tr>";
}
?>
</table>