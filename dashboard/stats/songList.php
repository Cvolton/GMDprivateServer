<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
error_reporting(0);
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
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
$table = '<div class="notifyblue" style="display:'.$notify.'">'.$dl->getLocalizedString("renamedSong").' <b>'.$an.'</b> - <b>'.$nn.'</b>!</div><table class="table table-inverse"><tr><th>#</th><th></th><th>'.$dl->getLocalizedString("songIDw").'</th><th>'.$dl->getLocalizedString("songAuthor").'</th><th>'.$dl->getLocalizedString("name").'</th><th>'.$dl->getLocalizedString("size").'</th><th>'.$dl->getLocalizedString("time").'</th>'.$me.'</tr>';

if(!empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$ngw = $_GET["ng"] == 1 ? '' : 'AND reuploadID > 0';
	$q = is_numeric(trim(ExploitPatch::remove($_GET["search"]))) ? "ID LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'" : "(name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%')";
	$srcbtn = '<a href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></a>';
	$query = $db->prepare("SELECT * FROM songs WHERE $q $ngw ORDER BY ID DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p>'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>');
		die();
	} 
} else {
	$ngw = $_GET["ng"] == 1 ? '' : 'WHERE reuploadID > 0';
	$query = $db->prepare("SELECT * FROM songs $ngw ORDER BY ID ASC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
}
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
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
	$download = $action["download"];
	if($action["reuploadID"] == 0) {
		$download = str_replace('%3A', ':', $download);
		$download = str_replace('%2F', '/', $download);
		$time = "<div style='color:gray'>Newgrounds</div>";
		$who = "<div><a style='color:#a7a7ff' target='_blank' href='https://".$author.".newgrounds.com/audio';>".$author."</a></div>";
		$btn = '<button type="button" title="'.$songsid.'.mp3" style="display: contents;color: #ffb1ab;margin: 0;" onclick="btn'.$songsid.'();"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-xmark" aria-hidden="false"></i></div>';
	} else {
		$btn = '<button type="button" title="'.$songsid.'.mp3" style="display: contents;color: white;margin: 0;" onclick="btn'.$songsid.'();"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-play" aria-hidden="false"></i></div><audio name="song" preload="metadata" controls class="audio" id="'.$songsid.'" style="display: none"><source src="'.$download.'" type="audio/mpeg"></audio></button>
		<script>
			function btn'.$songsid.'(){
				document.getElementById("'.$songsid.'").volume = 0.2;
				var elems=document.getElementsByTagName("audio");
				for(var i=0; i<elems.length; i++)elems[i].pause();
				for(var i=0; i<elems.length; i++)elems[i].style.display="none";
				document.getElementById("'.$songsid.'").style.display = "block";
				document.getElementById("'.$songsid.'").play();
			}
		</script>';
	}
	$manage = '<td><a class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$dl->getLocalizedString("change").'</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;transform: translate3d(971px, 200px, 0px);will-change: transform;">
									 <form class="form__inner" method="post" action="stats/renameSong.php">
										<div class="field" style="display:none"><input type="hidden" name="ID" value="'.$songsid.'"></div>
										<div class="field" style="display:none"><input type="hidden" name="page" value="'.$actualpage.'"></div>
										<div class="field"><input type="text" name="author" id="p1" value="'.$author.'" placeholder="'.$author.'"></div>
										<div class="field"><input type="text" name="name" id="p2" value="'.$name.'" placeholder="'.$name.'"></div>
										<button type="submit" class="btn-song" id="submit">'.$dl->getLocalizedString("change").'</button>
									</form>
								</div>
                                <script>
$(document).change(function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length || !p2.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-song");
	}
});
</script>
							</td>';
	if(strlen($author) > 18) $author = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$author</details>";
  	if(strlen($name) > 30) $name = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$name</details>";
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
						<td>".$btn."</td>
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
						<td>".$btn."</td>
						<td>".$songsid."</td>
						<td>".$author."</td>
						<td>".$name."</td>
						<td>".$size."</td>
						<td>".$time."</td>
						</tr>";
						$x++;
}

}
$table .= '</table><form method="get" class="form__inner">
	<div class="field" style="display:flex">
		<input style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
/*
	bottom row
*/
//getting count
if(!empty(trim($_GET["search"]))) $query = $db->prepare("SELECT count(*) FROM songs WHERE name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'");
else $query = $db->prepare("SELECT count(*) FROM songs $ngw");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
?>