<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
$dl->title($dl->getLocalizedString("modActionsList"));
$dl->printFooter('../');
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
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>');
	die();
} 
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
	if($action["type"] == 15) {
		$value = $gs->getAccountName($value);
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
  	if($action["type"] == 15) {
    	if($value3 == 0) $value3 = '<div style="color:#a9ffa9">'.$dl->getLocalizedString("unban").'</div>';
      	else $value3 = '<div style="color:#ffa9a9">'.$dl->getLocalizedString("isBan").'</div>';
      	if($value2 == 'banned' OR $value2 == 'none') $value2 = '<div style="color:gray">'.$dl->getLocalizedString("noReason").'</div>';
    } 
  	if($action["type"] == 17) { 
      	if($value3 == 1) $star = 0; elseif($value3 < 5) $star = 1; else $star = 2;
      	if($action["value4"] == 1) $coin = 0; elseif($action["value4"] != 0) $coin = 1; else $coin = 2; 
		$value = '<div style="color:rgb('.$action["value7"].');font-weight:700">'.$value.'</div>';
      	$value3 = $value3.' '.$dl->getLocalizedString("starsLevel$star").', '.$action["value4"].' '.$dl->getLocalizedString("coins$coin");
	}
	if(strlen($action["value"]) > 18) $value = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$value</details>";
  	if(strlen($action["value2"]) > 18) $value2 = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$value2</details>";
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