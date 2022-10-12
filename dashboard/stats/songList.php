<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
error_reporting(0);
$gs = new mainLib();
include "../../incl/lib/connection.php";
$dl->title($dl->getLocalizedString("songs"));
$dl->printFooter('../');
if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs")) $me = '<th>'.$dl->getLocalizedString("whoAdded").'</th>'; else $me = '';
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
$table = '<div class="notifyblue" style="display:'.$notify.'">'.$dl->getLocalizedString("renamedSong").' <b>'.$an.'</b> - <b>'.$nn.'</b>!</div><table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("songIDw").'</th><th>'.$dl->getLocalizedString("songAuthor").'</th><th>'.$dl->getLocalizedString("name").'</th><th>'.$dl->getLocalizedString("size").'</th><th>'.$dl->getLocalizedString("time").'</th>'.$me.'</tr>';

$query = $db->prepare("SELECT * FROM songs ORDER BY ID ASC LIMIT 10 OFFSET $page");
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
</div>', 'browse');
	die();
} 
foreach($result as &$action){
	$songsid = $action["ID"];
	$time = $dl->convertToDate($action["reuploadTime"]);
  	$who = '<form style="margin:0" method="post" action="profile/"><button style="margin:0" class="accbtn" name="accountID" value="'.$action["reuploadID"].'">'.$gs->getAccountName($action['reuploadID']).'</button></form>';
  	$author = $action["authorName"];
	$name = $action["name"];
	$size = $action["size"];
	if($action["reuploadID"] == 0) {
		$time = "<div style='color:gray'>Newgrounds</div>";
		$who = "<div><a style='color:#a7a7ff' target='_blank' href='https://".$author.".newgrounds.com/audio';>".$author."</a></div>";
	}
  	if(strlen($author) > 18) $author = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$author</details>";
  	if(strlen($name) > 30) $name = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$name</details>";
	$manage = '<td><a class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$dl->getLocalizedString("change").'</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;transform: translate3d(971px, 200px, 0px);will-change: transform;">
									 <form class="form__inner" method="post" action="stats/renameSong.php">
										<div class="field" style="display:none"><input type="hidden" name="ID" value="'.$songsid.'"></div>
										<div class="field" style="display:none"><input type="hidden" name="page" value="'.$actualpage.'"></div>
										<div class="field"><input type="text" name="author" value="'.$author.'" placeholder="'.$author.'"></div>
										<div class="field"><input type="text" name="name" value="'.$name.'" placeholder="'.$name.'"></div>
										<button type="submit" class="btn-song">'.$dl->getLocalizedString("change").'</button>
									</form>
								</div>
							</td>';
    if($action["isDisabled"]) {
		$songsid = '<div style="text-decoration:line-through;color:#8b2e2c">'.$songsid.'</div>';
		$author = '<div style="text-decoration:line-through;color:#8b2e2c">'.$author.'</div>';
		$name = '<div style="text-decoration:line-through;color:#8b2e2c">'.$name.'</div>';
      	$size = '<div style="text-decoration:line-through;color:#8b2e2c">'.$size.'</div>';
      	$time = '<div style="text-decoration:line-through;color:#8b2e2c">'.$time.'</div>';
	}
if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs")){
	$table .= "<tr>
						<th scope='row'>".$x."</th>
						<td>".$songsid."</td>
						<td>".$author."</td>
						<td>".$name."</td>
						<td>".$size."</td>
						<td>".$time."</td>
						<td>".$who."</td>
						<td>".$manage."</td>
						</tr>";
	$x++;
} else {
	$table .= "<tr>
						<th scope='row'>".$x."</th>
						<td>".$songsid."</td>
						<td>".$author."</td>
						<td>".$name."</td>
						<td>".$size."</td>
						<td>".$time."</td>
						</tr>";
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