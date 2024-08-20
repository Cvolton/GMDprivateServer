<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$dl->title($dl->getLocalizedString("manageSFX"));
$dl->printFooter('../');
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
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
$accountID = $_SESSION["accountID"];
if(!isset($_GET["search"])) $_GET["search"] = "";
$srcbtn = "";
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$q = is_numeric(trim(ExploitPatch::remove($_GET["search"]))) ? "ID LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'" : "(name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%')";
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM sfxs WHERE reuploadID = $accountID AND $q ORDER BY reuploadTime DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p>'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/manageSFX.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', "account");
		die();
	} 
} else {
	$query = $db->prepare("SELECT * FROM sfxs WHERE reuploadID = $accountID ORDER BY reuploadTime DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
}
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'account');
	die();
} 
foreach($result as &$action){
	$fontsize = 27;
	$sfxsid = $action["ID"];
	$songIDlol = '<button id="copy'.$action["ID"].'" class="accbtn songidyeah" onclick="copysong('.$action["ID"].')">'.$action["ID"].'</button>';
	$time = $dl->convertToDate($action["reuploadTime"], true);
  	$author = htmlspecialchars($action["authorName"]);
	$name = htmlspecialchars($action["name"]);
	$size = round($action["size"] / 1024 / 1024, 2);
 	$delete = '<button onclick="deletesong('.$sfxsid.')" style="color:#ffbbbb;margin-left:5px;width:max-content;padding:7px 10px;font-size:15px"  class="btn-rendel"><i class="fa-solid fa-xmark"></i></button>';
	$download = str_replace('http://', 'https://', $action["download"]);
	$btn = '<button type="button" name="btnsng" id="btn'.$sfxsid.'" title="'.$author.' — '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$download.'" onclick="btnsong(\''.$sfxsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$sfxsid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
	if(mb_strlen($name) > 30) $fontsize = 17;
	elseif(mb_strlen($name) > 20) $fontsize = 20;
	$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.$size.' MB</p>';
	$stats = $songSize;
	$songs .= '<div id="profile'.$sfxsid.'" style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
				<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick">'.$name.$btn.'</h2>'.$delete.'
			</div></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("sfxID").': <b>'.$songIDlol.'</b></h3><h3 id="comments" class="songidyeah" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
		</div></div>';
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("manageSFX").'</h1>
<div class="form-control new-form-control songs">
		'.$songs.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM sfxs WHERE reuploadID=:id AND $q");
else $query = $db->prepare("SELECT count(*) FROM sfxs WHERE reuploadID=:id");
$query->execute([':id' => $accountID]);
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow.'<script>
			function deletesong(id) {
				del = new XMLHttpRequest();
				del.open("GET", "stats/deleteSong.php?ID=" + id + "&sfx=1", true);
				del.onload = function () {
					dl = JSON.parse(del.response);
					if(dl.success) document.getElementById("profile"+id).remove()
				}
				del.send();
			}
		</script>', true, "account");
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'account');
}
?>