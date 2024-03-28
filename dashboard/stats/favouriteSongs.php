<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("favouriteSongs"));
$dl->printFooter('../');
if($_SESSION["accountID"] != 0) {
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$dailytable = $songs = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$query = $db->prepare("SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC LIMIT 10 OFFSET $page");
$query->execute([':id' => $_SESSION["accountID"]]);
$result = $query->fetchAll();
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
	$fontsize = 27;
	$songsid = $action["songID"];
	$songIDlol = '<button id="copy'.$action["ID"].'" class="accbtn songidyeah" onclick="copysong('.$action["ID"].')">'.$action["ID"].'</button>';
	$time = $dl->convertToDate($action["timestamp"], true);
  	$author = htmlspecialchars($action["authorName"]);
	$name = htmlspecialchars($action["name"]);
	$size = $action["size"];
	$who = '<button type="button" onclick="a(\'profile/'.$gs->getAccountName($action['reuploadID']).'\', true, true, \'POST\')" style="margin:0;font-size:20px" class="accbtn songacc" name="accountID" value="'.$action["reuploadID"].'">'.$gs->getAccountName($action['reuploadID']).'</button>';
 	$download = str_replace('http://', 'https://', $action["download"]);
	$btn = '<button type="button" name="btnsng" id="btn'.$songsid.'" title="'.$author.' — '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$download.'" onclick="btnsong(\''.$songsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$songsid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
	if(mb_strlen($author) + mb_strlen($name) > 30) $fontsize = 17;
	elseif(mb_strlen($author) + mb_strlen($name) > 20) $fontsize = 20;
	$favourites = $db->prepare("SELECT * FROM favsongs WHERE songID = :id AND accountID = :aid");
	$favourites->execute([':id' => $songsid, ':aid' => $_SESSION["accountID"]]);
	$favourites = $favourites->fetch();
	if(!empty($favourites)) $favs = '<button title="'.$dl->getLocalizedString("dislikeSong").'" id="like'.$songsid.'" value="1" style="display:contents;cursor:pointer" onclick="like('.$songsid.')"><i id="likeicon'.$songsid.'" class="fa-solid fa-heart" style="font-size: 25px;color:#ff5c5c"></i></button>'; 
	else $favs = '<button title="'.$dl->getLocalizedString("likeSong").'" id="like'.$songsid.'" onclick="like('.$songsid.')" value="0" style="display:contents;cursor:pointer"><i id="likeicon'.$songsid.'" class="fa-regular fa-heart" style="font-size: 25px;color:#ff5c5c"></i></button>';
	$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.$action["size"].' MB</p>';
	$who = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-user-plus"></i> '.$who.'</p>';
	$stats = $songSize.$who;
	$songs .= '<div id="profile'.$songsid.'" style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
				<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick">'.$author.' — '.$name.$btn.'</h2>'.$favs.'
			</div></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("songIDw").': <b>'.$songIDlol.'</b></h3><h3 id="comments" class="songidyeah" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
		</div></div>';
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("favouriteSongs").'</h1>
<div class="form-control new-form-control songs">
		'.$songs.'
	</div></div>';
$query = $db->prepare("SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC");
$query->execute([':id' => $_SESSION["accountID"]]);
$result = $query->fetchAll();
$pagecount = ceil(count($result) / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow.'<script>
			function like(id) {
				likebtn = document.getElementById("like" + id);
				if(likebtn.value == 1) {
					document.getElementById("likeicon" + id).classList.add("fa-regular");
					document.getElementById("likeicon" + id).classList.remove("fa-solid");
					likebtn.value = 0;
					likebtn.title = "'.$dl->getLocalizedString("likeSong").'";
				} else {
					document.getElementById("likeicon" + id).classList.remove("fa-regular");
					document.getElementById("likeicon" + id).classList.add("fa-solid");
					likebtn.value = 1;
					likebtn.title = "'.$dl->getLocalizedString("dislikeSong").'";
				}
				fav = new XMLHttpRequest();
				fav.open("GET", "stats/favourite.php?id=" + id, true);
				fav.onload = function () {
					if(fav.response == "-1") {
						if(likebtn.value == 1) {
							document.getElementById("likeicon" + id).classList.add("fa-regular");
							document.getElementById("likeicon" + id).classList.remove("fa-solid");
							likebtn.value = 0;
							likebtn.title = "'.$dl->getLocalizedString("likeSong").'";
						} else {
							document.getElementById("likeicon" + id).classList.remove("fa-regular");
							document.getElementById("likeicon" + id).classList.add("fa-solid");
							likebtn.value = 1;
							likebtn.title = "'.$dl->getLocalizedString("dislikeSong").'";
						}
					}
				}
				fav.send();
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