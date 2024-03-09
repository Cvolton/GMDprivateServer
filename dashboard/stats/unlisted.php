<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
	if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("levelid").'</th><th>'.$dl->getLocalizedString("levelname").'</th><th>'.$dl->getLocalizedString("leveldesc").'</th><th>'.$dl->getLocalizedString("levelpass").'</th><th>'.$dl->getLocalizedString("stars").'</th><th>'.$dl->getLocalizedString("songIDw").'</th></tr>';
$yourID = $gs->getAccountName($_SESSION["accountID"]);
$query = $db->prepare("SELECT * FROM levels WHERE unlisted=1 AND userName='$yourID' ORDER BY levelID DESC LIMIT 10 OFFSET $page");
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
	$songid = $action["songID"];
	$levelpass = $action["password"];
	if($levelpass == 0) {
		$levelpass = $dl->getLocalizedString("nopass");
	}
	$stars = $action["starStars"];
	if($stars == 0) {
		$stars = $dl->getLocalizedString("unrated");
	}
	$table .= "<tr><th scope='row'>".$x."</th><td>".$levelid."</td><td>".$levelname."</td><td>".$levelDesc."</td><td>".$levelpass."</td><td>".$stars."</td><td>".$songid."</td></tr>";
	$x++;
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
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="../dashboard/login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>');
}
?>