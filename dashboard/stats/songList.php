<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
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

$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
$table = '<div class="notifyblue" style="display:'.$notify.'">'.$dl->getLocalizedString("renamedSong").' <b>'.$an.'</b> - <b>'.$nn.'</b>!</div><table class="table table-inverse"><tr><th>#</th><th></th><th>'.$dl->getLocalizedString("songIDw").'</th><th>'.$dl->getLocalizedString("songAuthor").'</th><th>'.$dl->getLocalizedString("name").'</th><th>'.$dl->getLocalizedString("size").'</th><th>'.$dl->getLocalizedString("time").'</th>'.$me.'</tr>';
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = $favs = "";
if(!empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$ngw = $_GET["ng"] == 1 ? '' : 'AND reuploadID > 0';
	$q = is_numeric(trim(ExploitPatch::remove($_GET["search"]))) ? "ID LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'" : "(name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%')";
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM songs WHERE $q $ngw ORDER BY ID DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p>'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/songList.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
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
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'browse');
	die();
} 
foreach($result as &$action){
	$fontsize = 27;
	$check = $gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs");
	$songsid = $action["ID"];
	$songIDlol = '<button id="copy'.$action["ID"].'" class="accbtn" onclick="copysong('.$action["ID"].')">'.$action["ID"].'</button>';
	$time = $dl->convertToDate($action["reuploadTime"], true);
	$who = '<button type="button" onclick="a(\'profile/'.$gs->getAccountName($action['reuploadID']).'\', true, true, \'POST\')" style="margin:0;font-size:20px" class="accbtn songacc" name="accountID" value="'.$action["reuploadID"].'">'.$gs->getAccountName($action['reuploadID']).'</button>';
  	$author = $action["authorName"];
	$name = $action["name"];
	$size = $action["size"];
	$download = str_replace('http://', 'https://', $action["download"]);
	if($_SESSION["accountID"] != 0) {
		$favourites = $db->prepare("SELECT * FROM favsongs WHERE songID = :id AND accountID = :aid");
		$favourites->execute([':id' => $songsid, ':aid' => $_SESSION["accountID"]]);
		$favourites = $favourites->fetch();
		if(!empty($favourites)) $favs = '<button title="'.$dl->getLocalizedString("dislikeSong").'" id="like'.$songsid.'" value="1" style="display:contents;cursor:pointer" onclick="like('.$songsid.')"><i id="likeicon'.$songsid.'" class="fa-solid fa-heart" style="font-size: 25px;color:#ff5c5c"></i></button>'; 
		else $favs = '<button title="'.$dl->getLocalizedString("likeSong").'" id="like'.$songsid.'" onclick="like('.$songsid.')" value="0" style="display:contents;cursor:pointer"><i id="likeicon'.$songsid.'" class="fa-regular fa-heart" style="font-size: 25px;color:#ff5c5c"></i></button>';
	}
	if($action["reuploadID"] == 0) {
		$time = "<div style='color:gray'>Newgrounds</div>";
		$who = "<div><a style='color:#a7a7ff' target='_blank' href='https://".$author.".newgrounds.com/audio';>".$author."</a></div>";
		$btn = '<button type="button" title="'.$songsid.'.mp3" style="display: contents;color: #ffb1ab;margin: 0;"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-xmark" aria-hidden="false"></i></div></button>';
	} else {
		$btn = '<button type="button" name="btnsng" id="btn'.$songsid.'" title="'.$author.' - '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$download.'" onclick="btnsong(\''.$songsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$songsid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
	}
	if($check) $manage = '<a style="margin-left:5px;width:max-content;color:white;padding:8px;font-size:13px" class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-pencil"></i></a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;transform: translate3d(971px, 200px, 0px);will-change: transform;">
									 <form class="form__inner" method="post" action="stats/renameSong.php">
										<div class="field" style="display:none"><input type="hidden" name="ID" value="'.$songsid.'"></div>
										<div class="field" style="display:none"><input type="hidden" name="page" value="'.$actualpage.'"></div>
										<div class="field"><input type="text" name="author" id="p1" value="'.$author.'" placeholder="'.$author.'"></div>
										<div class="field"><input type="text" name="name" id="p2" value="'.$name.'" placeholder="'.$name.'"></div>
										<button type="submit" class="btn-song" id="submit">'.$dl->getLocalizedString("change").'</button>
									</form>
								</div>';
	if(strlen($author) + strlen($name) > 30) $fontsize = 17;
	elseif(strlen($author) + strlen($name) > 20) $fontsize = 20;
    if($action["isDisabled"]) {
		$songsid = '<div style="text-decoration:line-through;color:#8b2e2c">'.$songsid.'</div>';
		$author = '<div style="text-decoration:line-through;color:#8b2e2c">'.$author.'</div>';
		$name = '<div style="text-decoration:line-through;color:#8b2e2c">'.$name.'</div>';
      	$size = '<div style="text-decoration:line-through;color:#8b2e2c">'.$size.'</div>';
      	$time = '<div style="text-decoration:line-through;color:#8b2e2c">'.$time.'</div>';
		$btn = '<button type="button" style="display: contents;color: #ffb1ab;margin: 0;"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i class="fa-solid fa-xmark" aria-hidden="false"></i></div></button>';
		$manage = '';
	}
	$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.$action["size"].' MB</p>';
	$who = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-user-plus"></i> '.$who.'</p>';
	$stats = $songSize.$who;
	$songs .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
				<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick">'.$author.' — '.$name.$btn.'</h2>'.$favs.$manage.'
			</div></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("songIDw").': <b>'.$songIDlol.'</b></h3><h3 id="comments" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
		</div></div>';
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("songs").'</h1>
<div class="form-control new-form-control songs">
		'.$songs.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
if(!empty(trim($_GET["search"]))) $query = $db->prepare("SELECT count(*) FROM songs WHERE name LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' OR authorName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'");
else $query = $db->prepare("SELECT count(*) FROM songs $ngw");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow.'<script>
			function btnsong(id) {
				$("#song"+id).on("pause play", function() {
					if(document.getElementById("song" + id).paused) {
						var elems=document.getElementsByName("iconlol");
						for(var i=0; i<elems.length; i++)elems[i].classList.replace("fa-pause", "fa-play");
					} else document.getElementById("icon"+id).classList.replace("fa-play", "fa-pause");
				});
				if(document.getElementById(id) == null) {
					deleteDuplicates = $(".audio");
					for(var i=0; i<deleteDuplicates.length; i++) deleteDuplicates[i].remove();
					var elems=document.getElementsByName("iconlol");
					for(var i=0; i<elems.length; i++)elems[i].classList.replace("fa-pause", "fa-play");
					if(id != 0) {
						divsong = document.createElement("div");
						audiosong = document.createElement("audio");
						sourcesong = document.createElement("source");
						divsong.name = "audio";
						divsong.classList.add("audio");
						divsong.id = id;
						divsong.style.display = "flex";
						audiosong.title = document.getElementById("btn"+id).title;
						audiosong.style.width = "100%";
						audiosong.name = "song";
						audiosong.id = "song"+id;
						audiosong.setAttribute("controls", "");
						audiosong.volume = 0.2;
						sourcesong.src = document.getElementById("btn"+id).getAttribute("download");
						sourcesong.type = "audio/mpeg";
						closesong = document.createElement("button");
						closesong.type = "button";
						closesong.classList.add("msgupd");
						closesong.classList.add("closebtn");
						closesong.setAttribute("onclick", "btnsong(0)");
						closesong.innerHTML = \'<i class="fa-solid fa-xmark"></i>\';
						audiosong.appendChild(sourcesong);
						divsong.appendChild(audiosong);
						divsong.appendChild(closesong);
						document.body.appendChild(divsong);
						audiosong.play();
						document.getElementById("icon"+id).classList.replace("fa-play", "fa-pause");
					} else {
						divsong = audiosong = sourcesong = closesong = "";
						var elems=document.getElementsByName("iconlol");
						for(var i=0; i<elems.length; i++)elems[i].classList.replace("fa-pause", "fa-play");
					}
				} else {
					if(document.getElementById("song" + id).paused) {
						document.getElementById("song" + id).play();
					}
					else document.getElementById("song" + id).pause();
				}
			}
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
			function copysong(id) {
				navigator.clipboard.writeText(id);
				document.getElementById("copy"+id).style.transition = "0.05s";
				document.getElementById("copy"+id).style.color = "#bbffbb";
				setTimeout(function(){document.getElementById("copy"+id).style.transition = "0.2s";}, 1)
				setTimeout(function(){document.getElementById("copy"+id).style.color = "#007bff";}, 200)
			}
		</script>', true, "browse");
?>