<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$dl->title($dl->getLocalizedString("manageSongs"));
$dl->printFooter('../');
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
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
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
$table = '<div class="notify" style="display:'.$notify.'">'.$dl->getLocalizedString("deletedSong").' <b>'.$an.'</b> - <b>'.$nn.'</b>!</div><table class="table table-inverse"><tr><th>#</th><th></th><th>'.$dl->getLocalizedString("songIDw").'</th><th>'.$dl->getLocalizedString("songAuthor").'</th><th>'.$dl->getLocalizedString("name").'</th><th>'.$dl->getLocalizedString("size").'</th><th>'.$dl->getLocalizedString("time").'</th><th>'.$dl->getLocalizedString("howMuchLiked").'</th></tr>';
$accountID = $_SESSION["accountID"];
if(!isset($_GET["search"])) $_GET["search"] = "";
$srcbtn = "";
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$q = is_numeric(trim(ExploitPatch::remove($_GET["search"]))) ? "ID LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'" : "(name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%')";
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM songs WHERE reuploadID = $accountID AND $q ORDER BY ID DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p>'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/manageSongs.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>');
		die();
	} 
} else {
	$query = $db->prepare("SELECT * FROM songs WHERE reuploadID = $accountID ORDER BY ID ASC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
}
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'account');
	die();
} 
foreach($result as &$action){
	$songsid = $action["ID"];
	$time = $dl->convertToDate($action["reuploadTime"]);
	$author = $action["authorName"];
   	if(strlen($author) > 18) $author = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$author</details>";
	$name = $action["name"];
	$download = str_replace('http://', 'https://', $action["download"]);
  	if(strlen($name) > 30) $name = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$name</details>";
  	$delete = '<td><a style="color:#ff444c" class="btn-rendel" href="stats/deleteSong.php?ID='.$songsid.'">'.$dl->getLocalizedString("delete").'</a></td>';
	$size = $action["size"];
    if($action["isDisabled"]) {
		$songsid = '<div style="text-decoration:line-through;color:#8b2e2c">'.$songsid.'</div>';
		$author = '<div style="text-decoration:line-through;color:#8b2e2c">'.$author.'</div>';
		$name = '<div style="text-decoration:line-through;color:#8b2e2c">'.$name.'</div>';
      	$size = '<div style="text-decoration:line-through;color:#8b2e2c">'.$size.'</div>';
      	$time = '<div style="text-decoration:line-through;color:#8b2e2c">'.$time.'</div>';
	}
	$wholiked = "";
	$wholiked = $db->prepare("SELECT count(*) FROM favsongs WHERE songID = :id");
	$wholiked->execute([':id' => $songsid]);
	$wholiked = $wholiked->fetchColumn();
	if($wholiked == 0) $likes = '<div style="color:gray">'.$dl->getLocalizedString("nooneLiked").'</div>';
	else {
		$strs = $wholiked[strlen($wholiked)-1];
		if($strs == 1) $star = 0; elseif($strs < 5 AND $strs != 0 AND ($wholiked > 20 OR $wholiked < 10)) $star = 1; else $star = 2;
		$likes = $wholiked.' '.$dl->getLocalizedString("player".$star);
	}
	$btn = '<button type="button" name="btnsng" id="btn'.$songsid.'" title="'.$author.' - '.$name.'" style="display: contents;color: white;margin: 0;" onclick="btnsong(\''.$songsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-play" aria-hidden="false"></i></div></button>
			<div name="audio" class="audio" id="'.$songsid.'" style="display: none">
			<audio title="'.$author.' - '.$name.'" style="width:100%" name="song" id="song'.$songsid.'" preload="metadata" controls><source src="'.$download.'" type="audio/mpeg"></audio>
			<button style="margin: 0px;font-size: 25px;padding: 14px 19px;margin-left: 5px;" type="button" class="msgupd" onclick="btnsong(0)"><i class="fa-solid fa-xmark"></i></button></div>';
	$table .= "<tr><th scope='row'>".$x."</th><td>".$btn."</td><td>".$songsid."</td><td>".$author."</td><td>".$name."</td><td>".$size."</td><td>".$time."</td><td>".$likes."</td><td>".$delete."</td></tr>";
	$x++;
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
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM songs WHERE reuploadID=:id AND $q");
else $query = $db->prepare("SELECT count(*) FROM songs WHERE reuploadID=:id");
$query->execute([':id' => $accountID]);
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow.'<script>
			function btnsong(id, pausemaybe = false) {
				$("#song"+id).on("pause play", function() {
					if(document.getElementById("song" + id).paused) {
						var elems=document.getElementsByName("btnsng");
						for(var i=0; i<elems.length; i++)elems[i].innerHTML = \'<div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-play" aria-hidden="false"></i></div>\';
					} else document.getElementById("btn"+id).innerHTML = \'<div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-pause" aria-hidden="false"></i></div>\';
				});
				var elems=document.getElementsByName("audio");
				for(var i=0; i<elems.length; i++)elems[i].style.display="none";
				for(var i=0; i<elems.length; i++)elems[i].classList.remove("playing");
				var elems=document.getElementsByName("btnsng");
				for(var i=0; i<elems.length; i++)elems[i].innerHTML = \'<div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-play" aria-hidden="false"></i></div>\';
				var elems=document.getElementsByTagName("audio");
				for(var i=0; i<elems.length; i++)elems[i].pause();
				if(id != 0) {
					document.getElementById(id).style.display = "flex";
					document.getElementById(id).classList.add("playing");
					if(pausemaybe == false) {
						document.getElementById("btn"+id).innerHTML = \'<div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-pause" aria-hidden="false"></i></div>\';
						document.getElementById("song"+id).volume = 0.2;
						document.getElementById("song"+id).play();
						document.getElementById("btn"+id).setAttribute("onclick", "btnsong(" + id + ", true)");
					} else document.getElementById("btn"+id).setAttribute("onclick", "btnsong(" + id + ")");
				}
			}
		</script>', true, "account");
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'account');
}
?>