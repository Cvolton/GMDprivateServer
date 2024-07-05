<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("reportMod"));
$dl->printFooter('../');
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
if($modcheck) {
$reported = '';
$query = $db->prepare("SELECT levels.*, count(*) AS reportsCount FROM reports INNER JOIN levels ON reports.levelID = levels.levelID GROUP BY levels.levelID ORDER BY reportsCount DESC");
$query->execute();
$result = $query->fetchAll();
$x = 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'mod');
	die();
} 
foreach($result as &$level){
	$reports = $level["reportsCount"];
	$repstr = (string)$reports; // bruh
	$report = $repstr[strlen($repstr)-1];
	if($report == 1) $action = 0; elseif(($report < 5 AND $report != 0) AND !($reports > 9 AND $reports < 20)) $action = 1; else $action = "s";
	$reportsText = $reports.' '.$dl->getLocalizedString("time".$action);
	$levelid = $level["levelID"];
	$levelname = $level["levelName"];
	$levelIDlol = '<button id="copy'.$level["levelID"].'" class="accbtn songidyeah" onclick="copysong('.$level["levelID"].')">'.$level["levelID"].'</button>';
	$levelDesc = htmlspecialchars(ExploitPatch::url_base64_decode($level["levelDesc"]));
	if(empty($levelDesc)) $levelDesc = '<text style="color:gray">'.$dl->getLocalizedString("noDesc").'</text>';
	$levelpass = $level["password"];
	$likes = $level["likes"];
	$stats = '<div class="profilepic" style="display:inline-flex;grid-gap:3px;color:#c0c0c0">'.($likes >= 0 ? '<i class="fa-regular fa-thumbs-up"></i>' : '<i class="fa-regular fa-thumbs-down"></i>').' '.abs($likes). '</div>';
	if($modcheck) {
		$levelpass = substr($levelpass, 1);
		$levelpass = preg_replace('/(0)\1+/', '', $levelpass);
		if($levelpass == 0 OR empty($levelpass)) $lp = '<p class="profilepic"><i class="fa-solid fa-unlock"></i> '.$dl->getLocalizedString("nopass").'</p>';
		else {
			if(strlen($levelpass) < 4) while(strlen($levelpass) < 4) $levelpass = '0'.$levelpass;
			$lp = '<p class="profilepic"><i class="fa-solid fa-lock"></i> '.$levelpass.'</p>';
		}
		if($level["requestedStars"] <= 0 && $level["requestedStars"] > 10) $rs = '<p class="profilepic"><i class="fa-solid fa-star-half-stroke"></i> 0</p>';
		else $rs = '<p class="profilepic"><i class="fa-solid fa-star-half-stroke"></i> '.$level["requestedStars"].'</p>';
	} else $lp = $rs = '';
	if($level["songID"] > 0) {
		$songlol = $gs->getSongInfo($level["songID"]);
		$btn = '<button type="button" name="btnsng" id="btn'.$level["songID"].'" title="'.$songlol["authorName"].' — '.$songlol["name"].'" style="display: contents;color: white;margin: 0;" download="'.str_replace('http://', 'https://', $songlol["download"]).'" onclick="btnsong(\''.$level["songID"].'\');"><div class="icon songbtnpic""><i id="icon'.$level["songID"].'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
		$songid = '<div class="profilepic songpic">'.$btn.'<div class="songfullname"><div class="songauthor">'.$songlol["authorName"].'</div><div class="songname">'.$songlol["name"].'</div></div></div>';
	} else $songid = '<p class="profilepic"><i class="fa-solid fa-music"></i> '.strstr($gs->getAudioTrack($level["audioTrack"]), ' by ', true).'</p>';
	$username =  '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$level["userName"].'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID">'.$level["userName"].'</button></form>';
	$time = $dl->convertToDate($level["uploadDate"], true);
	$diff = $gs->getDifficulty($level["starDifficulty"], $level["auto"], $level["starDemonDiff"]);
	if($level['levelLength'] == 5) $starIcon = 'moon'; else $starIcon = 'star';
	$st = '<p class="profilepic"><i class="fa-solid fa-'.$starIcon.'"></i> '.$diff.', '.$level["starStars"].'</p>';
	$ln = '<p class="profilepic"><i class="fa-solid fa-clock"></i> '.$gs->getLength($level['levelLength']).'</p>';
	$dls = '<p class="profilepic"><i class="fa-solid fa-reply fa-rotate-270"></i> '.$level['downloads'].'</p>';
	$all = $dls.$stats.$st.$ln.$lp.$rs;
	$levels = '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
		<div class="profile">
		<div class="profacclist">
   			<div class="accnamedesc">
       			<div class="profcard1">
       				<h1 class="dlh1 profh1">'.sprintf($dl->getLocalizedString("demonlistLevel"), $levelname, 0, $level["userName"]).'</h1>
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
	$reported .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile">
			<div>
    			<div class="accnamedesc sugnamedesc">
        			<div class="profcard1">
        				<h1 class="dlh1 profh1 suggest">'.sprintf($dl->getLocalizedString("reportedName"), $level["levelName"], $reportsText).'</h1>
        			</div>
    			</div>
    			<div class="form-control new-form-control suggested">
					'.$levels.'
				</div>
    		</div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form new-form">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("reportMod").'</h1>
	<div class="form-control new-form-control">
		'.$reported.'
	</div>
</div>';
$dl->printPage($pagel, true, "mod");
} else $dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
?>