<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$dl->title($dl->getLocalizedString("dailyTable"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
$query = $db->prepare("SELECT * FROM dailyfeatures WHERE timestamp < :time ORDER BY feaID DESC LIMIT 10 OFFSET $page");
$query->execute([':time' => time()]);
$result = $query->fetchAll();
$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE timestamp < :time");
$query->execute([':time' => time()]);
$dailycount = $query->fetchColumn();
$x = $dailycount - $page;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
} 
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
foreach($result as &$daily){
	$typeArray = ['Daily', 'Weekly'];
  	$type = $typeArray[$daily["type"]];
    $query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
	$query->execute([':levelID' => $daily["levelID"]]);
	$level = $query->fetch();
	$dtt = $dl->convertToDate($daily['timestamp'], true);
	if(!empty($level)) {
		$dailyl = '<p class="profilepic"><i class="fa-solid fa-circle-play"></i> '.$type.'</p>';
		$dt = '<p class="profilepic"><i class="fa-regular fa-clock"></i> '.$dtt.'</p>';
		$levels .= $dl->generateLevelsCard($level, $modcheck, $dailyl.$dt);
	} else $levels .= '<div class=" form-control new-form-control dmbox list" style="margin: 0px; height: max-content; padding: 10px 0px 10px 10px !important;"><div class="messenger"><p>'.$dl->getLocalizedString("deletedLevel").'</p></div></div>';
}
$pagel = '<div class="form new-form">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("dailyTable").'</h1>
	<div class="form-control new-form-control">
		'.$levels.'
	</div>
</div>';
$pagecount = ceil($dailycount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "stats");
?>