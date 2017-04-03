<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
//Getting DailyID
$current = time();
$query=$db->prepare("SELECT feaID, timestamp FROM dailyfeatures WHERE timestamp < :current ORDER BY timestamp DESC LIMIT 1");
$query->execute([':current' => $current]);
$result = $query->fetchAll();
$result = $result[0];
$dailyID = $result["feaID"];
//Time left
$midnight = strtotime("tomorrow 00:00:00");
$timeleft = $midnight - $current;
//output
echo $dailyID ."|". $timeleft;
?>
