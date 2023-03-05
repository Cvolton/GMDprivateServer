<?php
session_start();
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
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("registerDate").'</th><th>'.$dl->getLocalizedString("isAdmin").'</th><th>'.$dl->getLocalizedString("lastSeen").'</th></tr>';
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = "";
if(!isset($_GET["search"]) OR empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$query = $db->prepare("SELECT * FROM accounts WHERE isActive = 1 ORDER BY accountID ASC LIMIT 10 OFFSET $page");
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
	$query = $db->prepare("SELECT * FROM accounts WHERE userName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' AND isActive = 1 ORDER BY accountID ASC LIMIT 10 OFFSET $page");
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
	$isAdmin = $action["isAdmin"];
	$accountID = $action["accountID"].' <text style="color:gray">|</text> '.$gs->getUserID($action["accountID"]);
  	if($action["accountID"] == $gs->getUserID($action["accountID"])) $accountID = $action["accountID"];
  	$username = '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID" value="'.$action["accountID"].'">'.$action["userName"].'</button></form>';
  	$query = $db->prepare("SELECT lastPlayed FROM users WHERE extID=:id");
  	$query->execute([':id' => $action["accountID"]]);
  	$lastseen = $query->fetch();
  	$lastPlayed = $dl->convertToDate($lastseen["lastPlayed"]);
  	if($lastseen["lastPlayed"] == 0 OR empty($lastseen)) $lastPlayed = '<div style="color:gray">'.$dl->getLocalizedString("never").'</div>';
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
			$resultRole = '<div style="color:rgb('.$gs->getAccountCommentColor($action["accountID"]).')">'.$resultRole.'</div>';
		}
	}
	$registerDate = date("d.m.Y", $action["registerDate"]);
	$table .= "<tr><th scope='row'>".$x."</th><td>".$username."</td><td>".$accountID."</td><td>".$registerDate."</td><td>".$resultRole."</td><td>".$lastPlayed."</td></tr>";
	$x++;
}
$table .= '</table><form method="get" name="searchform" class="form__inner">
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
if(empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM accounts WHERE isActive = 1 ");
else $query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' AND isActive = 1");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
?>