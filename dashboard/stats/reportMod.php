<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("reportMod"));
$dl->printFooter('../');
if(!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0){
	header("Location: ../login/login.php");
	exit();
}
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$table = '<table class="table table-inverse">
			<thead>
				<tr>
					<th>#</th>
					<th>'.$dl->getLocalizedString("ID").'</th>
					<th>'.$dl->getLocalizedString("name").'</th>
                    <th>'.$dl->getLocalizedString("author").'</th>
					<th>'.$dl->getLocalizedString("reportCount").'</th>
				</tr>
			</thead>
			<tbody>';

$query = $db->prepare("SELECT levels.levelID, levels.extID, levels.levelName, count(*) AS reportsCount FROM reports INNER JOIN levels ON reports.levelID = levels.levelID GROUP BY levels.levelID ORDER BY reportsCount DESC");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'mod');
	die();
} 
foreach($result as &$report){
	$levelName = htmlspecialchars($report['levelName'], ENT_QUOTES);
  	$author =  '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$gs->getAccountName($report["extID"]).'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID" value="'.$report["extID"].'">'.$gs->getAccountName($report["extID"]).'</button></form>';
	if($report['reportsCount'] == 1) $reports = $report['reportsCount'].' '.$dl->getLocalizedString("time0");
	elseif($report['reportsCount'] < 5) $reports = $report['reportsCount'].' '.$dl->getLocalizedString("time1");
	else $reports = $report['reportsCount'].' '.$dl->getLocalizedString("times");
	$table .= "<tr><td>$x</td><td>${report['levelID']}</td><td>$levelName</td><td>$author</td><td>$reports</td></tr>";
	$x++;
}
$table .= "</tbody></table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM levels WHERE extID=:extID AND unlisted=1");
$query->execute([':extID' => $_SESSION["accountID"]]);
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "mod");