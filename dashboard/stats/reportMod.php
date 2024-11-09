<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("reportMod"));
$dl->printFooter('../');
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
if($modcheck) {
$reported = '';
$query = $db->prepare("SELECT levels.*, count(*) AS reportsCount FROM reports INNER JOIN levels ON reports.levelID = levels.levelID GROUP BY levels.levelID ORDER BY reportsCount DESC");
$query->execute();
$result = $query->fetchAll();
$x = 1;
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
foreach($result as &$level){
	$reports = $level["reportsCount"];
	$repstr = (string)$reports; // bruh
	$report = $repstr[strlen($repstr)-1];
	if($report == 1) $action = 0; elseif(($report < 5 AND $report != 0) AND !($reports > 9 AND $reports < 20)) $action = 1; else $action = "s";
	$reportsText = $reports.' '.$dl->getLocalizedString("time".$action);
	$levels = $dl->generateLevelsCard($level, $modcheck);
	$reported .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile">
			<div>
    			<div class="accnamedesc sugnamedesc">
        			<div class="profcard1">
        				<h1 class="dlh1 profh1 suggest">'.sprintf($dl->getLocalizedString("reportedName"), $level["levelName"], $reportsText).'</h1>
        			</div>
    			</div>
    			<div class="form-control new-form-control suggested">
					'.$levels.'
				</div>
    		</div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form new-form">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("reportMod").'</h1>
	<div class="form-control new-form-control">
		'.$reported.'
	</div>
</div>';
$dl->printPage($pagel, true, "mod");
} else $dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
?>