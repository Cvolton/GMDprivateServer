<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("suggestLevels"));
$dl->printFooter('../');
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
if($modcheck) {
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$query = $db->prepare("SELECT * FROM suggest WHERE suggestLevelId > 0 ORDER BY ID DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
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
foreach($result as &$action){
	$suggestid = $action["suggestLevelId"];
	$suggestby =  $gs->getAccountName($action["suggestBy"]);
	$stars = $action["suggestStars"];
	if($stars < 5) $star = 1; elseif($stars > 4) $star = 2; else $star = 0;
	$suggestStars = $stars.' '.$dl->getLocalizedString("starsLevel$star");
	$suggestFeatured = $action["suggestFeatured"];
	$suggestTime = $dl->convertToDate($action["timestamp"], true);
	$feat = ['', 'Featured, ', 'Epic, '];
	$level = $db->prepare("SELECT * FROM levels WHERE levelID = :id");
	$level->execute([':id' => $action["suggestLevelId"]]);
	$level = $level->fetch();
	if(!empty($level)) {
		$levelid = $level["levelID"];
		$levelname = $level["levelName"];
		$levelIDlol = '<button id="copy'.$level["levelID"].'" class="accbtn songidyeah" onclick="copysong('.$level["levelID"].')">'.$level["levelID"].'</button>';
		$levelDesc = htmlspecialchars(base64_decode($level["levelDesc"]));
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
		if($level["starStars"] == 0 AND $modcheck) {
			$stars = '<div class="dropdown-menu" style="padding:17px 17px 0px 17px; top:0%;">
										 <form class="form__inner" method="post" action="levels/rateLevel.php">
											<div class="field"><input type="number" id="p1" name="rateStars" placeholder="'.$dl->getLocalizedString("stars").'"></div>
											<div class="ratecheck"><input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="0">'.$dl->getLocalizedString("isAdminNo").'</input>
											<input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="1">Featured</input>
											<input type="radio" style="margin-right:5px;margin-left: 2px" name="featured" value="2">Epic</div>
											<button type="submit" class="btn-song" id="submit" name="level" value="'.$levelid.'">'.$dl->getLocalizedString("rate").'</button>
										</form>
									</div>';
		} elseif($level["starStars"] != 0) $stars = '';
		if($level['levelLength'] == 5) $starIcon = 'moon'; else $starIcon = 'star';
		if(!empty($stars)) $st = '<a class="dropdown" href="#" data-toggle="dropdown"><p class="profilepic"><i class="fa-solid fa-'.$starIcon.'"></i> '.$diff.', '.$level["starStars"].'</p></a>'.$stars;
		else $st = '<p class="profilepic"><i class="fa-solid fa-'.$starIcon.'"></i> '.$diff.', '.$level["starStars"].'</p>';
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
	} else $levels = '<div class=" form-control new-form-control dmbox list" style="margin: 0px"><div class="messenger"><p>'.$dl->getLocalizedString("deletedLevel").'</p></div></div>';
	$suggested .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile">
			<div>
    			<div class="accnamedesc sugnamedesc">
        			<div class="profcard1">
        				<h1 class="dlh1 profh1 suggest">'.sprintf($dl->getLocalizedString("suggestedName"), $suggestby, $level["levelName"], $suggestStars, $feat[$suggestFeatured]).'</h1>
        			</div>
    			</div>
    			<div class="form-control new-form-control suggested">
					'.$levels.'
				</div>
    		</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;align-items: center;">'.$dl->getLocalizedString("ID").': <b>'.$action["ID"].'</b></h3><h3 id="comments" class="songidyeah"  style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$suggestTime.'</b></h3></div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form new-form">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("suggestLevels").'</h1>
	<div class="form-control new-form-control">
		'.$suggested.'
	</div>
</div>';
/*
	bottom row
*/
$query = $db->prepare("SELECT count(*) FROM suggest");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "mod");
} else $dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
?>