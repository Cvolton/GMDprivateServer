<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$dl->title($dl->getLocalizedString("suggestLevels"));
$dl->printFooter('../');
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
if(!$modcheck) die($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod'));
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0) {
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
$query = $db->prepare("SELECT * FROM suggest WHERE suggestLevelId > 0 ORDER BY ID DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'mod');
	die();
} 
foreach($result as &$action) {
	$suggestid = $action["suggestLevelId"];
	$suggestby =  $gs->getAccountName($action["suggestBy"]);
	$stars = $action["suggestStars"];
	if($stars < 5) $star = 1; elseif($stars > 4) $star = 2; else $star = 0;
	$suggestStars = $stars.' '.$dl->getLocalizedString("starsLevel$star");
	$suggestFeatured = $action["suggestFeatured"];
	$suggestTime = $dl->convertToDate($action["timestamp"], true);
	$feat = ['', 'Featured, ', 'Epic, '];
	$level = $db->prepare("SELECT * FROM levels WHERE levelID = :id");
	$level->execute([':id' => $action["suggestLevelId"]]);
	$level = $level->fetch();
	if(!empty($level)) $levels = $dl->generateLevelsCard($level, $modcheck);
	 else $levels = '<div class="form-control new-form-control dmbox list" style="margin: 0px"><div class="messenger"><p>'.$dl->getLocalizedString("deletedLevel").'</p></div></div>';
	$suggested .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile">
			<div>
    			<div class="accnamedesc sugnamedesc">
        			<div class="profcard1">
        				<h1 class="dlh1 profh1 suggest">'.sprintf($dl->getLocalizedString("suggestedName"), $suggestby, $level["levelName"], $suggestStars, $feat[$suggestFeatured]).'</h1>
        			</div>
    			</div>
    			<div class="form-control new-form-control suggested">
					'.$levels.'
				</div>
    		</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;align-items: center;">'.$dl->getLocalizedString("ID").': <b>'.$action["ID"].'</b></h3><h3 id="comments" class="songidyeah"  style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$suggestTime.'</b></h3></div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form new-form">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("suggestLevels").'</h1>
	<div class="form-control new-form-control">
		'.$suggested.'
	</div>
</div>';
/*
	bottom row
*/
$query = $db->prepare("SELECT count(*) FROM suggest");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "mod");
?>