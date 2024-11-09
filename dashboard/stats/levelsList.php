<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("levels"));
$dl->printFooter('../');
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
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
$searchValue = trim(ExploitPatch::rucharclean($_GET["search"]));
if(!empty($searchValue)) {
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM levels WHERE unlisted = 0 AND ".(is_numeric($searchValue) ? 'levelID' : 'levelName')." LIKE '%".$searchValue."%' ORDER BY uploadDate DESC LIMIT 10 OFFSET $page");
} else $query = $db->prepare("SELECT * FROM levels WHERE unlisted = 0 ORDER BY uploadDate DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
if(empty($result)) die($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>', 'browse'));
foreach($result as &$action) $levels .= $dl->generateLevelsCard($action, $modcheck);
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("levels").'</h1>
<div class="form-control new-form-control">
		'.$levels.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$searchValue.'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
/*
	bottom row
*/
//getting count
if(!empty($searchValue)) $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted =  0 AND ".(is_numeric($searchValue) ? 'levelID' : 'levelName')." LIKE '%".$searchValue."%'");
else $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted = 0");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "browse");
?>