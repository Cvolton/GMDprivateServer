<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("levels"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
	$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("levelid").'</th><th>'.$dl->getLocalizedString("levelname").'</th><th>'.$dl->getLocalizedString("levelAuthor").'</th><th>'.$dl->getLocalizedString("leveldesc").'</th><th>'.$dl->getLocalizedString("levelpass").'</th><th>'.$dl->getLocalizedString("stars").'</th><th>'.$dl->getLocalizedString("stats").'</th><th>'.$dl->getLocalizedString("songIDw").'</th></tr>';
} else {
	$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("levelid").'</th><th>'.$dl->getLocalizedString("levelname").'</th><th>'.$dl->getLocalizedString("levelAuthor").'</th><th>'.$dl->getLocalizedString("leveldesc").'</th><th>'.$dl->getLocalizedString("stars").'</th><th>'.$dl->getLocalizedString("stats").'</th><th>'.$dl->getLocalizedString("songIDw").'</th></tr>';
}
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = "";
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM levels WHERE unlisted<>1 AND levelName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p>'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/levelsList.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>');
		die();
	} 
} else {
	$query = $db->prepare("SELECT * FROM levels WHERE unlisted<>1 ORDER BY levelID DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
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
}
$x = $page + 1;
foreach($result as &$action){
	$levelid = $action["levelID"];
	$levelname = $action["levelName"];
	$levelDesc = base64_decode($action["levelDesc"]);
  	if(strlen($levelDesc) > 31) $levelDesc = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$levelDesc</details>";
  	if(empty($levelDesc)) $levelDesc = '<div style="color:gray">'.$dl->getLocalizedString("noDesc").'</div>';
	$levelpass = $action["password"];
	$levelpass = substr($levelpass, 1);
  	$levelpass = preg_replace('/(0)\1+/', '', $levelpass);
	if($levelpass == 0 OR empty($levelpass)) $levelpass = '<div style="color:gray">'.$dl->getLocalizedString("nopass").'</div>';
	else if(strlen($levelpass) < 4) while(strlen($levelpass) < 4) $levelpass = '0'.$levelpass;
	$songid = $action["songID"];
	if($songid == 0) $songid = '<div style="color:#d0d0d0">'.strstr($gs->getAudioTrack($action["audioTrack"]), ' by ', true).'</div>';
	$username =  '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID">'.$action["userName"].'</button></form>';
  	$stars = $action["starStars"];
    if($stars < 5 AND $stars != 1) {
          $star = 1;
      } elseif($stars > 4) {
          $star = 2;
      } else {
          $star = 0;
      }
	$stars = $action["starStars"].' '.$dl->getLocalizedString("starsLevel$star");
	if($action["starStars"] == 0 AND $gs->checkPermission($_SESSION["accountID"], "dashboardModTools")) {
      	$stars = '<a class="dropdown" href="#" data-toggle="dropdown">'.$dl->getLocalizedString("unrated").'</a>
								<div class="dropdown-menu" style="padding:17px 17px 0px 17px; top:0%;">
									 <form class="form__inner" method="post" action="levels/rateLevel.php">
										<div class="field"><input type="number" id="p1" name="rateStars" placeholder="'.$dl->getLocalizedString("stars").'"></div>
                                        <div class="ratecheck"><input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="0">'.$dl->getLocalizedString("isAdminNo").'</input>
                                        <input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="1">Featured</input>
                                        <input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="2">Epic</div>
										<button type="submit" class="btn-song" id="submit" name="level" value="'.$levelid.'">'.$dl->getLocalizedString("rate").'</button>
									</form>
								</div>';
	} elseif($action["starStars"]== 0) $stars = '<div style="color:gray">'.$dl->getLocalizedString("unrated").'</div>';
	if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
	$table .= "<tr><th scope='row'>".$x."</th><td>".$levelid."</td><td>".$levelname."</td><td>".$username."</td><td>".$levelDesc."</td><td>".$levelpass."</td><td>".$stars."</td><td>".$songid."</td></tr>";
	$x++;
	} else {
	$table .= "<tr><th scope='row'>".$x."</th><td>".$levelid."</td><td>".$levelname."</td><td>".$username."</td><td>".$levelDesc."</td><td>".$stars."</td><td>".$songid."</td></tr>";
	$x++;
	}
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
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted=0 AND levelName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'");
else $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted=0");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
?>