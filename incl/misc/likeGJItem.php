<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
include "../../config/rateLimits.php";
$ep = new exploitPatch();
$gs = new mainLib();
$type = $_POST["type"] + 2;
$ip = $gs->getIP();
$itemID = $ep->remove($_POST["itemID"]);
$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type=:type AND value=:itemID AND value2=:ip");
$query6->execute([':type' => $type, ':itemID' => $itemID, ':ip' => $ip]);
if($query6->fetchColumn() > 2){
	exit("-1");
}
if ($likesDone != 0) { //Rate Limit
	$query = $db->prepare("SELECT count(*) FROM actions WHERE type = 16 AND value = 'Liked Something' AND timestamp > :timestamp");
	$query->execute([':timestamp' => time() - $likesDuration]);
	if ($query->fetchColumn() >= $likesDone) {
		$query = $db->prepare("SELECT count(*) FROM actions WHERE type = 16 AND value = 'Liking Disabled' AND timestamp > :timestamp");
		$query->execute([':timestamp' => time() - $disableLikeTime]);
		if ($query->fetchColumn() == 0) {
			$query = $db->prepare("INSERT INTO actions (type, value, timestamp) VALUES (16, 'Liking Disabled', :timestamp)");
			$query->execute([':timestamp' => time()]);
		}
		exit("-1");
	} 
}
$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
											(:type,:itemID, :time, :ip)");
$query6->execute([':type' => $type, ':itemID' => $itemID, ':time' => time(), ':ip' => $ip]);
switch($_POST["type"]){
	case 1:
		$table = "levels";
		$column = "levelID";
		break;
	case 2:
		$table = "comments";
		$column = "commentID";
		break;
	case 3:
		$table = "acccomments";
		$column = "commentID";
		break;
}
$query=$db->prepare("SELECT likes FROM $table WHERE $column = :itemID LIMIT 1");
$query->execute([':itemID' => $itemID]);
$likes = $query->fetchColumn();
if($_POST["like"]==1){
	$likes++;
}else{
	$likes--;
}
$query2=$db->prepare("UPDATE $table SET likes = :likes WHERE $column = :itemID");
$query2->execute([':itemID' => $itemID, ':likes' => $likes]);
$query = $db->prepare("INSERT INTO actions (type, value, timestamp) VALUES (16, 'Liked Something', :timestamp)");
$query->execute([':timestamp' => time()]);
echo "1";
?>