<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$dl = new dashboardLib();
$gs = new mainLib();
$dl->title($dl->getLocalizedString("manageSongs"));
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
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
$accountID = $_SESSION["accountID"];
if(!isset($_GET["search"])) $_GET["search"] = "";
$srcbtn = "";
if(!empty(trim(ExploitPatch::rucharclean($_GET["search"])))) {
	$q = is_numeric(trim(ExploitPatch::rucharclean($_GET["search"]))) ? "ID LIKE '%".trim(ExploitPatch::rucharclean($_GET["search"]))."%'" : "(name LIKE '%".trim(ExploitPatch::rucharclean($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::rucharclean($_GET["search"]))."%')";
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM songs WHERE reuploadID = $accountID AND $q ORDER BY reuploadTime DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/manageSongs.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', "account");
		die();
	} 
} else {
	$query = $db->prepare("SELECT * FROM songs WHERE reuploadID = $accountID ORDER BY reuploadTime DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
}
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
foreach($result as &$action) {
	$wholiked = $db->prepare("SELECT count(*) FROM favsongs WHERE songID = :id");
	$wholiked->execute([':id' => $songsid]);
	$wholiked = $wholiked->fetchColumn();
	$whoused = $action['levelsCount'];
	$wholiked = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-heart"></i> '.$wholiked.'</p>';
	$whoused = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-gamepad"></i> '.$whoused.'</p>';
	$songs .= $dl->generateSongCard($action, $wholiked.$whoused, false);
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("manageSongs").'</h1>
<div class="form-control new-form-control songs">
		'.$songs.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
if(!empty(trim(ExploitPatch::rucharclean($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM songs WHERE reuploadID=:id AND $q");
else $query = $db->prepare("SELECT count(*) FROM songs WHERE reuploadID = :id");
$query->execute([':id' => $accountID]);
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow, true, "account");
?>