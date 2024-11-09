<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("gauntletTable"));
$dl->printFooter('../');
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = $levels = "";
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
$x = 1;
$packtable = "";
$query = $db->prepare("SELECT * FROM gauntlets ORDER BY ID ASC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'browse');
	die();
} 
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
foreach($result as &$pack) {
	$lvlarray = [$pack["level1"], $pack["level2"], $pack["level3"], $pack["level4"], $pack["level5"]];
	$lvltable = "";
	foreach($lvlarray as &$lvl) {
		$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$action = $query->fetch();
		if(!$action) continue;
		$lvltable .= $dl->generateLevelsCard($action, $modcheck);
	}
	$packtable .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
		<div class="profile packcard">
			<div class="packname">
				<h1>'.$gs->getGauntletName($pack["ID"]).' Gauntlet</h1>
			</div>
			<div class="form-control new-form-control gauntletlevels">
				'.$lvltable.'
			</div>
			<div class="commentsdiv" style="margin: 0px 5px">
				<h2 class="comments">ID: '.$pack["ID"].'</h2>
				'.($pack["timestamp"] != 0 ? '<h2 class="comments">'.$dl->getLocalizedString('date').': '.$dl->convertToDate($pack["timestamp"], true).'</h2>' : '').'
			</div>
		</div>
	</div>';
	$x++;
}
$pagecount = ceil($dailycount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage('<div class="form new-form"><h1>'.$dl->getLocalizedString('gauntletTable').'</h1>
	<div class="form-control clan-form-control">
		'.$packtable.'
	</div>
</div>'.$bottomrow, 'browse');
?>