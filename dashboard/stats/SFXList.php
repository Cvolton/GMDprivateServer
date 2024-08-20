<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("sfxs"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
if(!empty($_GET["author"]) AND !empty($_GET["name"])) {
	$notify = "block"; 
	$an = $_GET["author"];
	$nn = $_GET["name"];
} else { 
	$notify = "none";
	$an = 0;
	$nn = 0;
}
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
$srcbtn = $favs = $meta = "";
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$q = is_numeric(trim(ExploitPatch::remove($_GET["search"]))) ? "ID LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'" : "(name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%')";
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM sfxs WHERE $q ORDER BY reuploadTime DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p>'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/songList.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>');
		die();
	} 
} else {
	$query = $db->prepare("SELECT * FROM sfxs ORDER BY reuploadTime DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
}
$x = 0;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'browse');
	die();
} 
foreach($result as &$action){
	$x++;
	$fontsize = 27;
	$check = $gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs");
	$sfxsid = $action["ID"];
	$songIDlol = '<button id="copy'.$action["ID"].'" class="accbtn songidyeah" onclick="copysong('.$action["ID"].')">'.$action["ID"].'</button>';
	$time = $dl->convertToDate($action["reuploadTime"], true);
	$who = '<button type="button" onclick="a(\'profile/'.$gs->getAccountName($action['reuploadID']).'\', true, true, \'POST\')" style="margin:0;font-size:20px" class="accbtn songacc" name="accountID" value="'.$action["reuploadID"].'">'.$gs->getAccountName($action['reuploadID']).'</button>';
	$author = htmlspecialchars($action["authorName"]);
	$name = htmlspecialchars($action["name"]);
	$size = round($action["size"] / 1024 / 1024, 2);
	$download = str_replace('http://', 'https://', $action["download"]);
	$btn = '<button type="button" name="btnsng" id="btn'.$sfxsid.'" title="'.$author.' — '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$download.'" onclick="btnsong(\''.$sfxsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$sfxsid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
	if($check) $manage = '<a style="margin-left:5px;width:max-content;color:white;padding:8px;font-size:13px" class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-pencil"></i></a><div onclick="event.stopPropagation()" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;transform: translate3d(971px, 200px, 0px);will-change: transform;">
									 <form class="form__inner" method="post" name="songrename'.$sfxsid.'">
										<div class="field" style="display:none"><input type="hidden" name="ID" value="'.$sfxsid.'"></div>
										<div class="field" style="display:none"><input type="hidden" name="page" value="'.$actualpage.'"></div>
										<div class="field"><input type="text" name="name" id="p2" value="'.$name.'" placeholder="'.$name.'"></div>
										<input type="hidden" name="sfx" value="1"></input>
										<button type="button" class="btn-song" id="submit" onclick="rename('.$sfxsid.')">'.$dl->getLocalizedString("change").'</button>
									</form>
								</div>';
	if(mb_strlen($name) > 30) $fontsize = 17;
	elseif(mb_strlen($name) > 20) $fontsize = 20;
	$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.$size.' MB</p>';
	$who = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-user-plus"></i> '.$who.'</p>';
	$stats = $songSize.$who;
	$songs .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
				<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick"><text id="songname'.$sfxsid.'">'.$name.'</text>'.$btn.'</h2>'.$favs.$manage.'
			</div></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;align-items: center;">'.$dl->getLocalizedString("sfxID").': <b>'.$songIDlol.'</b></h3><h3 id="comments" class="songidyeah"  style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
		</div></div>';
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("sfxs").'</h1>
<div class="form-control new-form-control songs">
		'.$songs.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
if($x > 0 AND !empty(trim(ExploitPatch::remove($_GET["search"])))) {
	if($x > 1) {
		echo '<meta name="description" content="Послушай '.$x.' звуковых эффектов по запросу '.trim($_GET["search"]).'!">';
	} else {
		echo '<meta property="og:video" content="'.str_replace('http://', 'https://', $result[0]["download"]).'">
		<meta property="og:audio:type" content="audio/mpeg">
		<meta name="description" content="Послушай звуковой эффект '.$result[0]["name"].'!">';
	}
}
if(!empty(trim($_GET["search"]))) $query = $db->prepare("SELECT count(*) FROM sfxs WHERE name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'");
else $query = $db->prepare("SELECT count(*) FROM sfxs");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow.'<script>
			function rename(id) {
				nfd = new FormData(document.getElementsByName("songrename"+id)[0]);
				ren = new XMLHttpRequest();
				ren.open("POST", "stats/renameSong.php", true);
				ren.onload = function () {
					r = JSON.parse(ren.response);
					if(r.success) document.getElementById("songname"+id).innerHTML = nfd.get("name");
				}
				ren.send(nfd);
			}
		</script>', true, "browse");
?>