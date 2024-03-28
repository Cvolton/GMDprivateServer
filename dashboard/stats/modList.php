<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("modActions"));
$dl->printFooter('../');
$modtable = "";
$accounts = implode(",",$gs->getAccountsWithPermission("toolModactions"));
if($accounts == ""){
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
}
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
if(!isset($_GET["search"])) $_GET["search"] = "";
$srcbtn = "";
if(!empty($_GET["search"])) {
	$query = $db->prepare("SELECT * FROM accounts INNER JOIN users WHERE isActive = 1 AND accounts.accountID = users.extID AND accounts.accountID IN ($accounts) AND accounts.userName LIKE '%".ExploitPatch::remove($_GET["search"])."%' ORDER BY accounts.userName ASC");
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
} else $query = $db->prepare("SELECT * FROM accounts INNER JOIN users WHERE isActive = 1 AND accounts.accountID = users.extID AND accounts.accountID IN ($accounts) ORDER BY accounts.userName ASC");
$query->execute();
$result = $query->fetchAll();
$row = 0;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
} 
foreach($result as &$action) {
	$clan = $own = '';
	$query = $db->prepare("SELECT * FROM (SELECT count(*) AS actionCount FROM modactions WHERE account = :id) actionCount JOIN (SELECT count(*) AS levelsRated FROM modactions WHERE account = :id AND type = 1) levelsRated");
	$query->execute([':id' => $action["accountID"]]);
	$counts = $query->fetch();
	$accUserID = $gs->getUserID($action["accountID"]);
	$accountID = $action["accountID"].' <text style="font-weight: 100;">|</text> '.$accUserID;
	if($action["accountID"] == $accUserID) $accountID = $action["accountID"];
	$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID =:accid");
	$query->execute([':accid' => $accountID]);
	$resultPls = $query->fetch();
	if(!$resultPls) $resultRole = $dl->getLocalizedString("player");
	else {
		$resultRole = $resultPls["roleID"];
		if(empty($resultRole)){
			$resultRole = $dl->getLocalizedString("player");
		} else {
			$query = $db->prepare("SELECT roleName FROM roles WHERE roleID = :id");
			$query->execute([':id' => $resultRole]);
			$resultRole = $query->fetch()["roleName"];
		}
	}
	if($action["clan"] != 0) {
		$claninfo = $gs->getClanInfo($action["clan"]);
		if($claninfo["clanOwner"] == $action["accountID"]) $own = '<i style="color:#ffff91" class="fa-solid fa-crown"></i>';
		$clan = '<span style="display:contents;cursor:pointer"><h2 class="music" style="width: max-content;margin-left: 5px;grid-gap:5px;color:#'.$claninfo["color"].'">'.$claninfo["clan"].$own.'</h2></span>';
	}
	if($action["stars"] == 0) $st = ''; else $st = '<p class="profilepic">'.$action["stars"].' <i class="fa-solid fa-star"></i></p>';
    if($action["moons"] == 0) $ms = ''; else $ms = ' <p class="profilepic">'.$action["moons"].' <i class="fa-solid fa-moon"></i></p>';
    if($action["diamonds"] == 0) $dm = ''; else $dm = ' <p class="profilepic">'.$action["diamonds"].' <i class="fa-solid fa-gem"></i></p>';
    if($action["coins"] == 0) $gc = ''; else $gc = '<p class="profilepic">'.$action["coins"].' <i class="fa-solid fa-coins" style="color:#ffffbb"></i></p>';
    if($action["userCoins"] == 0) $uc = ''; else $uc = '<p class="profilepic">'.$action["userCoins"].' <i class="fa-solid fa-coins"></i></p>';
    if($action["demons"] == 0) $dn = ''; else $dn = '<p class="profilepic">'.$action["demons"].' <i class="fa-solid fa-dragon"></i></p>';
    if($action["creatorPoints"] == 0) $cp = ''; else $cp = '<p class="profilepic">'.$action["creatorPoints"].' <i class="fa-solid fa-screwdriver-wrench"></i></p>';
	$ac = '<p class="profilepic">'.$counts["actionCount"].' <i class="fa-solid fa-circle-play"></i></p>';
    $lr = '<p class="profilepic">'.$counts["levelsRated"].' <i class="fa-regular fa-star"></i></p>';
    $stats = $st.$ms.$dm.$gc.$uc.$dn.$cp.$ac.$lr;
    if(empty($stats)) $stats = '<p style="font-size:25px;color:#212529">'.$dl->getLocalizedString("empty").'</p>';
	$registerDate = $dl->convertToDate($action["registerDate"], true);
	$members .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'GET\')"><div class="acclistdiv">
				<h2 style="color:rgb('.$gs->getAccountCommentColor($action["accountID"]).');" class="profilenick acclistnick">'.$action["userName"].' '.$clan.'</h2><h2 class="accresultrole">'.$resultRole.'</h2>
			</div></button></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div class="acccomments"><h3 class="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("accountID").': <b>'.$accountID.'</b></h3><h3 class="comments" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("registerDate").': <b>'.$registerDate.'</b></h3></div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("modActions").'</h1>
<div class="form-control new-form-control">
		'.$members.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
$dl->printPage($pagel.$bottomrow, true, "stats");
?>