<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$str = ExploitPatch::remove($_POST["str"]);
$page = ExploitPatch::remove($_POST["page"]);
$userstring = "";
$usrpagea = $page*10;
$query = "SELECT userName, userID, coins, userCoins, icon, color1, color2, color3, iconType, special, extID, stars, creatorPoints, demons, diamonds, moons FROM users WHERE userID = :str OR userName LIKE CONCAT('%', :str, '%') ORDER BY stars DESC LIMIT 10 OFFSET $usrpagea";
$query = $db->prepare($query);
$query->execute([':str' => $str]);
$result = $query->fetchAll();
if(count($result) < 1){
	exit("-1");
}
$countquery = "SELECT count(*) FROM users WHERE userName LIKE CONCAT('%', :str, '%')";
$countquery = $db->prepare($countquery);
$countquery->execute([':str' => $str]);
$usercount = $countquery->fetchColumn();
foreach($result as &$user){
	$userstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":51:".$user["color3"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["extID"].":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":46:".$user["diamonds"].":52:".$user["moons"]."|";
}
$userstring = substr($userstring, 0, -1);
echo $userstring;
echo "#".$usercount.":".$usrpagea.":10";
?>