<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
error_reporting(0);
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
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("registerDate").'</th><th>'.$dl->getLocalizedString("isAdmin").'</th></tr>';
$query = $db->prepare("SELECT * FROM accounts ORDER BY accountID ASC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
foreach($result as &$action){
	$username = $action["userName"];
	$isAdmin = $action["isAdmin"];
	$accountID = $action["accountID"];
	$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID =:accid");
	$query->execute([':accid' => $accountID]);
	$resultRole = implode($query->fetch());
	if(empty($resultRole)){
		$resultRole = $dl->getLocalizedString("player");
	} else {
		switch($resultRole) {
			case 11:
				$resultRole = $dl->getLocalizedString("admin");
				break;
			case 22:
				$resultRole = $dl->getLocalizedString("elder");
				break;
			case 33:
				$resultRole = $dl->getLocalizedString("moder");
				break;
		}
	}
	$registerDate = date("d/m/Y", $action["registerDate"]);
	$table .= "<tr><th scope='row'>".$x."</th><td>".$username."</td><td>".$accountID."</td><td>".$registerDate."</td><td>".$resultRole."</td></tr>";
	$x++;
}
$table .= "</table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM accounts");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
?>