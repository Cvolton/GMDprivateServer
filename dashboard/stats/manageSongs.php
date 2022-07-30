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
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("songIDw").'</th><th>'.$dl->getLocalizedString("songAuthor").'</th><th>'.$dl->getLocalizedString("name").'</th><th>'.$dl->getLocalizedString("size").'</th><th>'.$dl->getLocalizedString("time").'</th></tr>';
$accountID = $_SESSION["accountID"];
$query = $db->prepare("SELECT * FROM songs WHERE reuploadID = $accountID ORDER BY ID ASC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
foreach($result as &$action){
	$songsid = $action["ID"];
	$time = $dl->convertToDate($action["reuploadTime"]);
	$author = $action["authorName"];
	$name = $action["name"];
	$size = $action["size"];
	$delete = '<td><a style="color:#ff444c" href="stats/deleteSong.php?ID='.$songsid.'">'.$dl->getLocalizedString("delete").'</a></td>';
	$table .= "<tr><th scope='row'>".$x."</th><td>".$songsid."</td><td>".$author."</td><td>".$name."</td><td>".$size."</td><td>".$time."</td><td>".$delete."</td></tr>";
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