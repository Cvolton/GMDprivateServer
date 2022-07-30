<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("stars").'</th></tr>';
$time = time() - 86400;
$query = $db->prepare("SELECT users.userID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND timestamp > :time AND users.isBanned = 0 GROUP BY(users.userID)");
$query->execute([':time' => $time]);
$result = $query->fetchAll();
$x = $page + 1;
foreach($result as &$action){
	$userid = $action["userID"];
	$username = $action["userName"];
	$stars = $action["stars"];
	$table .= "<tr><th scope='row'>".$x."</th><td>".$userid."</td><td>".$username."</td><td>".$stars."</td></tr>";
	$x++;
}
$table .= "</table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM songs");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");

?>