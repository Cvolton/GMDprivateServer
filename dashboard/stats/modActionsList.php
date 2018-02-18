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
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("mod").'</th><th>'.$dl->getLocalizedString("action").'</th><th>'.$dl->getLocalizedString("value").'</th><th>'.$dl->getLocalizedString("value2").'</th><th>'.$dl->getLocalizedString("level").'</th><th>'.$dl->getLocalizedString("time").'</th></tr>';

$query = $db->prepare("SELECT * FROM modactions ORDER BY ID DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
foreach($result as &$action){
	//detecting mod
	$account = $action["account"];
	$account = $gs->getAccountName($account);
	//detecting action
	$value = $action["value"];
	$value2 = $action["value2"];
	$value3 = $action["value3"];
	if($action["type"] == 5){
		if(is_numeric($value2)){
			$value2 = date("d/m/Y G:i:s", $value2);
		}
	}
	$actionname = $dl->getLocalizedString("modAction".$action["type"]);
	if($action["type"] == 2 OR $action["type"] == 3 OR $action["type"] == 4){
		if($action["value"] == 1){
			$value = "True";
		}else{
			$value = "False";
		}
	}
	if($action["type"] == 5 OR $action["type"] == 6){
		$value = "";
	}
	if($action["type"] == 13){
		$value = base64_decode($value);
	}
	if(strlen($value) > 18){
		$value = "<details><summary>Spoiler</summary>$value</details>"; //todo: finish
	}
	if(strlen($value2) > 18){
		$value2 = "<details><summary>Spoiler</summary>$value2</details>"; //todo: finish
	}
	$time = date("d/m/Y G:i:s", $action["timestamp"]);
	if($action["type"] == 5 AND $action["value2"] > time()){
		$value3 = "future";
	}
	$table .= "<tr><th scope='row'>".$x."</th><td>".$account."</td><td>".$actionname."</td><td>".$value."</td><td>".$value2."</td><td>".$value3."</td><td>".$time."</td></tr>";
	$x++;
}
$table .= "</table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM modactions");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
?>