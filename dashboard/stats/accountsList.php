<?php
session_start();
if($_SESSION["accountID"] != 71) exit("kish");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
error_reporting(0);
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("accounts"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = $members = "";
if(!isset($_GET["search"]) OR empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$query = $db->prepare("SELECT * FROM accounts INNER JOIN users WHERE isActive = 1  AND accounts.accountID = users.extID ORDER BY accountID ASC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("emptyPage").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>');
		die();
	} 
} else {
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM accounts INNER JOIN users WHERE accounts.userName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' AND isActive = 1 AND accounts.accountID = users.extID ORDER BY accountID ASC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p>'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/accountsList.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>');
		die();
	} 
}
$x = $page + 1;
foreach($result as &$action){
	$clan = $own = '';
	$accountID = $action["accountID"].' <text style="font-weight: 100;">|</text> '.$gs->getUserID($action["accountID"]);
  	if($action["accountID"] == $gs->getUserID($action["accountID"])) $accountID = $action["accountID"];
	$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID =:accid");
	$query->execute([':accid' => $accountID]);
	$resultPls = $query->fetch();
	if(!$resultPls) $resultRole = $dl->getLocalizedString("player");
	else {
		$resultRole = $resultPls["roleID"];
		if(empty($resultRole)){
			$resultRole = $dl->getLocalizedString("player");
		} else {
			switch($resultRole) {
				case 1:
					$resultRole = $dl->getLocalizedString("admin");
					break;
				case 2:
					$resultRole = $dl->getLocalizedString("elder");
					break;
				case 3:
					$resultRole = $dl->getLocalizedString("moder");
					break;
				default:
					$query = $db->prepare("SELECT roleName FROM roles WHERE roleID = :id");
					$query->execute([':id' => $resultRole]);
					$resultRole = $query->fetch()["roleName"];
					break;
			}
		}
	}
	if($action["clan"] != 0) {
		$claninfo = $gs->getClanInfo($action["clan"]);
		if($claninfo["clanOwner"] == $action["accountID"]) $own = '<i style="color:#ffff91" class="fa-solid fa-crown"></i>';
		$clan = '<span style="display:contents;cursor:pointer"><h2 class="music" style="width: max-content;margin-left: 5px;grid-gap:5px;color:#'.$claninfo["color"].'">'.$claninfo["clan"].$own.'</h2></span>';
	}
	if($action["stars"] == 0) $st = ''; else $st = '<p class="profilepic">'.$action["stars"].' <i class="fa-solid fa-star"></i></p>';
    if($action["diamonds"] == 0) $dm = ''; else $dm = ' <p class="profilepic">'.$action["diamonds"].' <i class="fa-solid fa-gem"></i></p>';
    if($action["coins"] == 0) $gc = ''; else $gc = '<p class="profilepic">'.$action["coins"].' <i class="fa-solid fa-coins" style="color:#ffffbb"></i></p>';
    if($action["userCoins"] == 0) $uc = ''; else $uc = '<p class="profilepic">'.$action["userCoins"].' <i class="fa-solid fa-coins"></i></p>';
    if($action["demons"] == 0) $dn = ''; else $dn = '<p class="profilepic">'.$action["demons"].' <i class="fa-solid fa-dragon"></i></p>';
    if($action["creatorPoints"] == 0) $cp = ''; else $cp = '<p class="profilepic">'.$action["creatorPoints"].' <i class="fa-solid fa-screwdriver-wrench"></i></p>';
    $stats = $st.$dm.$gc.$uc.$dn.$cp;
    if(empty($stats)) $stats = '<p style="font-size:25px;color:#212529">'.$dl->getLocalizedString("empty").'</p>';
	$registerDate = date("d.m.Y", $action["registerDate"]);
	$members .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'GET\')"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
				<h2 style="color:rgb('.$gs->getAccountCommentColor($action["accountID"]).');margin: 0px;font-size: 27px;margin-left:5px;display: flex;align-items: center;" class="profilenick">'.$action["userName"].' '.$clan.'</h2><h2 style="margin:0px;width: 100%;text-align: right;">'.$resultRole.'</h2>
			</div></button></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("accountID").': <b>'.$accountID.'</b></h3><h3 id="comments" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("registerDate").': <b>'.$registerDate.'</b></h3></div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form" style="position:relative;padding-bottom: 20px;max-width:60vw;width: 60vw;height:70vh;margin-top:10px;margin-bottom:20px;border-radius:45px;overflow:auto;overflow-x:hidden;max-height:80vh;justify-content:flex-start">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("accounts").'</h1>
<div class="form-control" style="display: inherit;border-radius: 45px;margin-top: 15px;flex-wrap: wrap;padding: 0px 15px 15px 15px;overflow-y: auto;min-width: 100%;justify-content: space-between;height: 100%;margin-bottom: 0px;align-items: start;align-content:start;">
		'.$members.'
	</div></div><form method="get" name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
/*
	bottom row
*/
//getting count
if(empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM accounts INNER JOIN users WHERE isActive = 1 AND accounts.accountID = users.extID");
else $query = $db->prepare("SELECT count(*) FROM accounts INNER JOIN users WHERE accounts.userName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' AND isActive = 1 AND accounts.accountID = users.extID");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow, true, "browse");
?>