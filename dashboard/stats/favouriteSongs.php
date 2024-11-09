<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("favouriteSongs"));
$dl->printFooter('../');
if(!isset($_SESSION["accountID"]) || $_SESSION["accountID"] == 0) die($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="./login/login.php">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noLogin?").'</p>
		<button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'account'));
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0) {
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
$dailytable = $songs = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$query = $db->prepare("SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC LIMIT 10 OFFSET $page");
$query->execute([':id' => $_SESSION["accountID"]]);
$result = $query->fetchAll();
if(empty($result)) {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>', 'account');
	die();
} 
foreach($result as &$action) $songs .= $dl->generateSongCard($action);
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("favouriteSongs").'</h1>
<div class="form-control new-form-control songs">
		'.$songs.'
	</div></div>';
$query = $db->prepare("SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC");
$query->execute([':id' => $_SESSION["accountID"]]);
$result = $query->fetchAll();
$pagecount = ceil(count($result) / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow, true, "account");
?>