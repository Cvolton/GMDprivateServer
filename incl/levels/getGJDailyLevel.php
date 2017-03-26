<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
//Getting DailyID
$query=$db->prepare("SELECT * FROM dailyfeatures ORDER BY timestamp DESC LIMIT 1");
$query->execute(array($levelID));
$result = $query->fetchAll();
$result = $result[0];
$dailyID = $result["feaID"];
//Time left
$midnight = strtotime("tomorrow 00:00:00");
$current = time();
$timeleft = $midnight - $current;
//quests
echo $dailyID ."|". $timeleft;
?>
