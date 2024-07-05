<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$dl->title($dl->getLocalizedString("dailyTable"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$dailytable = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$query = $db->prepare("SELECT * FROM dailyfeatures WHERE timestamp < :time ORDER BY feaID DESC LIMIT 10 OFFSET $page");
$query->execute([':time' => time()]);
$result = $query->fetchAll();
$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE timestamp < :time");
$query->execute([':time' => time()]);
$dailycount = $query->fetchColumn();
$x = $dailycount - $page;
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
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
foreach($result as &$daily){
	$typeArray = ['Daily', 'Weekly'];
  	$type = $typeArray[$daily["type"]];
    $query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
	$query->execute([':levelID' => $daily["levelID"]]);
	$level = $query->fetch();
	$dtt = $dl->convertToDate($daily['timestamp'], true);
	if(!empty($level)) {
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
		$dailyl = '<p class="profilepic"><i class="fa-solid fa-circle-play"></i> '.$type.'</p>';
		$dt = '<p class="profilepic"><i class="fa-regular fa-clock"></i> '.$dtt.'</p>';
		$dls = '<p class="profilepic"><i class="fa-solid fa-reply fa-rotate-270"></i> '.$level['downloads'].'</p>';
		$all = $dailyl.$dt.$dls.$stats.$st.$ln.$lp.$rs;
		$levels .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
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
	} else $levels .= '<div class=" form-control new-form-control dmbox list" style="margin: 0px"><div class="messenger"><p>'.$dl->getLocalizedString("deletedLevel").'</p></div></div>';
}
$pagel = '<div class="form new-form">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("dailyTable").'</h1>
	<div class="form-control new-form-control">
		'.$levels.'
	</div>
</div>';
$pagecount = ceil($dailycount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "stats");
?>