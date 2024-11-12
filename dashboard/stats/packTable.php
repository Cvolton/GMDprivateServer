<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("packTable"));
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
$query = $db->prepare("SELECT * FROM mappacks ORDER BY ID ASC LIMIT 10 OFFSET $page");
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
foreach($result as &$pack){
	$lvlarray = explode(",", $pack["levels"]);
	$lvltable = "";
  	$color = $pack['rgbcolors'];
    $starspack = $pack["stars"];
    if($pack["stars"] == 0) $starspack = '<span style="color:grey">0</span>';
  	$coinspack = $pack["coins"];
    if($pack["coins"] == 0) $coinspack = '<span style="color:grey">0</span>';
	$pst = '<p class="profilepic"><i class="fa-solid fa-star" style="color:#ffff88"></i> '.$starspack.'</p>';
	$pcc =  '<p class="profilepic"><i class="fa-solid fa-coins"></i> '.$coinspack.'</p>';
	$diffarray = ['Auto', 'Easy', 'Normal', 'Hard', 'Harder', 'Insane', 'Demon'];
	$pd = '<p class="profilepic"><i class="fa-solid fa-face-smile-beam"></i> '.$diffarray[$pack['difficulty']].'</p>';
	$packall = $pst.$pd.$pcc;
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
				<h1 style="color:rgb('.$pack["rgbcolors"].')">'.$pack["name"].'</h1>
			</div>
			<div class="form-control longfc song-info">
        		'.$packall.'
			</div>
			<div class="form-control new-form-control packlevels">
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
$dl->printPage('<div class="form new-form"><h1>'.$dl->getLocalizedString('packTable').'</h1>
	<div class="form-control clan-form-control">
		'.$packtable.'
	</div>
</div>'.$bottomrow, 'browse');
?>