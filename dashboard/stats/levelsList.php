<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
$dl->title($dl->getLocalizedString("levels"));
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
	$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("levelid").'</th><th>'.$dl->getLocalizedString("levelname").'</th><th>'.$dl->getLocalizedString("levelAuthor").'</th><th>'.$dl->getLocalizedString("leveldesc").'</th><th>'.$dl->getLocalizedString("levelpass").'</th><th>'.$dl->getLocalizedString("stars").'</th><th>'.$dl->getLocalizedString("songIDw").'</th></tr>';
} else {
	$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("levelid").'</th><th>'.$dl->getLocalizedString("levelname").'</th><th>'.$dl->getLocalizedString("levelAuthor").'</th><th>'.$dl->getLocalizedString("leveldesc").'</th><th>'.$dl->getLocalizedString("stars").'</th><th>'.$dl->getLocalizedString("songIDw").'</th></tr>';
}
$query = $db->prepare("SELECT * FROM levels WHERE unlisted=0 ORDER BY levelID DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>');
	die();
} 
foreach($result as &$action){
	$levelid = $action["levelID"];
	$levelname = $action["levelName"];
	$levelDesc = base64_decode($action["levelDesc"]);
	if(empty($levelDesc)) {
		$levelDesc = $dl->getLocalizedString("noDesc");
	}
	$levelpass = $action["password"];
	$levelpass = substr($levelpass, 1);
	if($levelpass == 0 OR empty($levelpass)) {
		$levelpass = $dl->getLocalizedString("nopass");
	}
	$songid = $action["songID"];
	if($songid == 0) $songid = $gs->getAudioTrack($action["audioTrack"]);
	$username = $action["userName"];
	$stars = $action["starStars"];
	if($stars == 0 AND $gs->checkPermission($_SESSION["accountID"], "dashboardModTools")) {
      	$stars = '<a class="dropdown" href="#" data-toggle="dropdown">'.$dl->getLocalizedString("unrated").'</a>
								<div class="dropdown-menu" style="padding:17px 17px 0px 17px; top:0%;">
									 <form class="form__inner" method="post" action="levels/rateLevel.php">
										<div class="field"><input type="number" name="rateStars" placeholder="'.$dl->getLocalizedString("stars").'"></div>
										<div class="ratecheck"><input type="checkbox" style="margin-right:5px" name="featured" value="1">Featured?</div>
										<button type="submit" class="btn-song" name="level" value="'.$levelid.'">'.$dl->getLocalizedString("rate").'</button>
									</form>
								</div>';
	} elseif($stars == 0) $stars = $dl->getLocalizedString("unrated");
	if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
	$table .= "<tr><th scope='row'>".$x."</th><td>".$levelid."</td><td>".$levelname."</td><td>".$username."</td><td>".$levelDesc."</td><td>".$levelpass."</td><td>".$stars."</td><td>".$songid."</td></tr>";
	$x++;
	} else {
	$table .= "<tr><th scope='row'>".$x."</th><td>".$levelid."</td><td>".$levelname."</td><td>".$username."</td><td>".$levelDesc."</td><td>".$stars."</td><td>".$songid."</td></tr>";
	$x++;
	}
}
$table .= "</table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM songs");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
?>