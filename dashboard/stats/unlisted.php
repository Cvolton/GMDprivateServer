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
if(!isset($_SESSION["accountID"]) || $_SESSION["accountID"] == 0) exit($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'account'));
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
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
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM levels WHERE unlisted != 0 AND extID = :extid AND levelName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' LIMIT 10 OFFSET $page");
	$query->execute([':extid' => $_SESSION['accountID']]);
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
	$query = $db->prepare("SELECT * FROM levels WHERE unlisted != 0 AND extID = :extid ORDER BY levelID DESC LIMIT 10 OFFSET $page");
	$query->execute([':extid' => $_SESSION['accountID']]);
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
	$levelIDlol = '<button id="copy'.$action["levelID"].'" class="accbtn songidyeah" onclick="copysong('.$action["levelID"].')">'.$action["levelID"].'</button>';
	$levelDesc = base64_decode($action["levelDesc"]);
  	if(empty($levelDesc)) $levelDesc = '<text style="color:gray">'.$dl->getLocalizedString("noDesc").'</text>';
	$levelpass = $action["password"];
	$likes = $action["likes"] > 0 ? $action["likes"] : '<span style="color:gray">'.$action["likes"].'</span>';
	$stats = '<div class="profilepic" style="display:inline-flex;grid-gap:3px;color:white"><i class="fa-regular fa-thumbs-up"></i> '.$likes.'</div>';
	$levelpass = substr($levelpass, 1);
  	$levelpass = preg_replace('/(0)\1+/', '', $levelpass);
	if($levelpass == 0 OR empty($levelpass)) $lp = '<p class="profilepic"><i class="fa-solid fa-unlock"></i> '.$dl->getLocalizedString("nopass").'</p>';
	else {
	    if(strlen($levelpass) < 4) while(strlen($levelpass) < 4) $levelpass = '0'.$levelpass;
    	$lp = '<p class="profilepic"><i class="fa-solid fa-lock"></i> '.$levelpass.'</p>';
	}
	if($action["requestedStars"] <= 0 && $action["requestedStars"] > 10) $rs = '<p class="profilepic"><i class="fa-solid fa-star-half-stroke"></i> 0</p>';
	else $rs = '<p class="profilepic"><i class="fa-solid fa-star-half-stroke"></i> '.$action["requestedStars"].'</p>';
	if($action["songID"] > 0) {
	    $songlol = $gs->getSongInfo($action["songID"]);
	    $btn = '<button type="button" name="btnsng" id="btn'.$action["songID"].'" title="'.$songlol["authorName"].' — '.$songlol["name"].'" style="display: contents;color: white;margin: 0;" download="'.str_replace('http://', 'https://', $songlol["download"]).'" onclick="btnsong(\''.$action["songID"].'\');"><div class="icon songbtnpic""><i id="icon'.$action["songID"].'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
	    $songid = '<div class="profilepic songpic">'.$btn.'<div class="songfullname"><div class="songauthor">'.$songlol["authorName"].'</div><div class="songname">'.$songlol["name"].'</div></div></div>';
	} else $songid = '<p class="profilepic"><i class="fa-solid fa-music"></i> '.strstr($gs->getAudioTrack($action["audioTrack"]), ' by ', true).'</p>';
	$username =  '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID">'.$action["userName"].'</button></form>';
	$time = $dl->convertToDate($action["uploadDate"], true);
	$diff = $gs->getDifficulty($action["starDifficulty"], $action["auto"], $action["starDemonDiff"]);
	if($action["starStars"] == 0 AND $modcheck) {
      	$stars = '<div class="dropdown-menu" style="padding:17px 17px 0px 17px; top:0%;">
									 <form class="form__inner" method="post" action="levels/rateLevel.php">
										<div class="field"><input type="number" id="p1" name="rateStars" placeholder="'.$dl->getLocalizedString("stars").'"></div>
                                        <div class="ratecheck"><input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="0">'.$dl->getLocalizedString("isAdminNo").'</input>
                                        <input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="1">Featured</input>
                                        <input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="2">Epic</div>
										<button type="submit" class="btn-song" id="submit" name="level" value="'.$levelid.'">'.$dl->getLocalizedString("rate").'</button>
									</form>
								</div>';
	} elseif($action["starStars"] != 0) $stars = '';
	if(!empty($stars)) $st = '<a class="dropdown" href="#" data-toggle="dropdown"><p class="profilepic"><i class="fa-solid fa-star"></i> '.$diff.', '.$action["starStars"].'</p></a>'.$stars;
	else $st = '<p class="profilepic"><i class="fa-solid fa-star"></i> '.$diff.', '.$action["starStars"].'</p>';
	$ln = '<p class="profilepic"><i class="fa-solid fa-clock"></i> '.$gs->getLength($action['levelLength']).'</p>';
	$dls = '<p class="profilepic"><i class="fa-solid fa-reply fa-rotate-270"></i> '.$action['downloads'].'</p>';
	$all = $dls.$stats.$st.$ln.$lp.$rs;
	$levels .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile">
			<div class="profacclist">
    			<div class="accnamedesc">
        			<div class="profcard1">
        				<h1 class="dlh1 profh1">'.sprintf($dl->getLocalizedString("demonlistLevel"), $levelname, 0, $action["userName"]).'</h1>
        			</div>
    			    <p class="dlp">'.$levelDesc.'</p>
    			</div>
    			<div class="form-control acccontrol">
        			<div class="acccontrol2">
        			    '.$all.'
        			</div>
        			'.$songid.'
    			</div>
    		</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;align-items: center;">'.$dl->getLocalizedString("levelid").': <b>'.$levelIDlol.'</b></h3><h3 id="comments" class="songidyeah"  style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("levels").'</h1>
<div class="form-control new-form-control">
		'.$levels.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
/*
	bottom row
*/
//getting count
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted != 0 AND extID = :extid levelName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'");
else $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted != 0 AND extID = :extid");
$query->execute([':extid' => $_SESSION['accountID']]);
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow.'<script>
function copysong(id) {
	navigator.clipboard.writeText(id);
	document.getElementById("copy"+id).style.transition = "0.05s";
	document.getElementById("copy"+id).style.color = "#bbffbb";
	setTimeout(function(){document.getElementById("copy"+id).style.transition = "0.2s";}, 1)
	setTimeout(function(){document.getElementById("copy"+id).style.color = "#007bff";}, 200)
}
function btnsong(id) {
				$("#song"+id).on("pause play", function() {
					if(document.getElementById("song" + id).paused) {
						var elems=document.getElementsByName("iconlol");
						for(var i=0; i<elems.length; i++)elems[i].classList.replace("fa-pause", "fa-play");
					} else document.getElementById("icon"+id).classList.replace("fa-play", "fa-pause");
				});
				if(document.getElementById(id) == null) {
					deleteDuplicates = $(".audio");
					for(var i=0; i<deleteDuplicates.length; i++) deleteDuplicates[i].remove();
					var elems=document.getElementsByName("iconlol");
					for(var i=0; i<elems.length; i++)elems[i].classList.replace("fa-pause", "fa-play");
					if(id != 0) {
						divsong = document.createElement("div");
						audiosong = document.createElement("audio");
						sourcesong = document.createElement("source");
						divsong.name = "audio";
						divsong.classList.add("audio");
						divsong.id = id;
						divsong.style.display = "flex";
						audiosong.title = document.getElementById("btn"+id).title;
						audiosong.style.width = "100%";
						audiosong.name = "song";
						audiosong.id = "song"+id;
						audiosong.setAttribute("controls", "");
						audiosong.volume = 0.2;
						sourcesong.src = document.getElementById("btn"+id).getAttribute("download");
						sourcesong.type = "audio/mpeg";
						closesong = document.createElement("button");
						closesong.type = "button";
						closesong.classList.add("msgupd");
						closesong.classList.add("closebtn");
						closesong.setAttribute("onclick", "btnsong(0)");
						closesong.innerHTML = \'<i class="fa-solid fa-xmark"></i>\';
						audiosong.appendChild(sourcesong);
						divsong.appendChild(audiosong);
						divsong.appendChild(closesong);
						document.body.appendChild(divsong);
						audiosong.play();
						document.getElementById("icon"+id).classList.replace("fa-play", "fa-pause");
					} else {
						divsong = audiosong = sourcesong = closesong = "";
						var elems=document.getElementsByName("iconlol");
						for(var i=0; i<elems.length; i++)elems[i].classList.replace("fa-pause", "fa-play");
					}
				} else {
					if(document.getElementById("song" + id).paused) {
						document.getElementById("song" + id).play();
					}
					else document.getElementById("song" + id).pause();
				}
			}
</script>', true, "account");
?>