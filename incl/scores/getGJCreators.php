<?php
chdir(dirname(__FILE__));
error_reporting(0);
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$accountID = ExploitPatch::remove($_POST["accountID"]);
$type = ExploitPatch::remove($_POST["type"]);
$query = "SELECT * FROM users WHERE isCreatorBanned = '0' ORDER BY creatorPoints DESC LIMIT 100";
$query = $db->prepare($query);
$query->execute();
$result = $query->fetchAll();
foreach($result as &$user){
	$xi++;
	$extid = is_numeric($user['extID']) ? $user['extID'] : 0;
	$pplstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"]."|";
}
$pplstring = substr($pplstring, 0, -1);
echo $pplstring;
?>
