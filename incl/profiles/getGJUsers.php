<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$str = $ep->remove($_POST["str"]);
$page = $ep->remove($_POST["page"]);
$usrpagea = $page*10;
$query = "SELECT * FROM users WHERE userName LIKE CONCAT('%', :str, '%') ORDER BY stars DESC LIMIT 10 OFFSET $usrpagea";
$query = $db->prepare($query);
$query->execute([':str' => $str]);
$result = $query->fetchAll();
$countquery = "SELECT count(*) FROM users WHERE userName LIKE CONCAT('%', :str, '%')";
$countquery = $db->prepare($countquery);
$countquery->execute([':str' => $str]);
$usercount = $countquery->fetchAll()[0][0];
foreach($result as &$user){
	$userstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$user["extID"].":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"]."|";
}
$userstring = substr($userstring, 0, -1);
echo $userstring;
echo "#".$usercount.":".$usrpagea.":10";
?>