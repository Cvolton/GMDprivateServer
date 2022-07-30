<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("levelid").'</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("rate").'</th><th>'.$dl->getLocalizedString("suggestFeatured").'</th><th>'.$dl->getLocalizedString("time").'</th></tr>';
$query = $db->prepare("SELECT * FROM suggest ORDER BY ID DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
foreach($result as &$action){
	$suggestid = $action["suggestLevelId"];
	$suggestby = $gs->getAccountName($action["suggestBy"]);
	$diff = $action["suggestDifficulty"];
	$stars = $action["suggestStars"];
	if($action["suggestAuto"] != 0) {
		$diff = "Auto";
	} elseif($action["suggestDemon"] != 0) {
		$diff = "Demon";
	} else {
		switch($diff) {
			case 10:
				$diff = "Easy";
				break;
			case 20:
				$diff = "Normal";
				break;
			case 30:
				$diff = "Hard";
				break;	
			case 40:
				$diff = "Harder";
				break;
			case 50:
				$diff = "Insane";
				break;
		}
	}
if($stars < 5) {
		$star = 1;
	} elseif($stars > 4) {
		$star = 2;
	} else {
		$star = 0;
	}
	$suggestStars = $diff.', '.$stars.' '.$dl->getLocalizedString("starsLevel$star");
	$suggestFeatured = $action["suggestFeatured"];
	if($suggestFeatured == 0) {
		$suggestFeatured = $dl->getLocalizedString("isAdminNo");
	} else {
		$suggestFeatured = $dl->getLocalizedString("isAdminYes");
	}
	$suggestTime = $dl->convertToDate($action["timestamp"]);
	$table .= "<tr><th scope='row'>".$x."</th><td>".$suggestid."</td><td>".$suggestby."</td><td>".$suggestStars."</td><td>".$suggestFeatured."</td><td>".$suggestTime."</td></tr>";
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
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>');
?>