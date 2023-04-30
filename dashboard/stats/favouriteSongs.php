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
	$songIDlol = '<button id="copy'.$action["ID"].'" class="accbtn" onclick="copysong('.$action["ID"].')">'.$action["ID"].'</button>';
	$time = $dl->convertToDate($action["timestamp"], true);
  	$author = $action["authorName"];
	$name = $action["name"];
	$size = $action["size"];
	$who = '<button type="button" onclick="a(\'profile/'.$gs->getAccountName($action['reuploadID']).'\', true, true, \'POST\')" style="margin:0;font-size:20px" class="accbtn songacc" name="accountID" value="'.$action["reuploadID"].'">'.$gs->getAccountName($action['reuploadID']).'</button>';
 	$download = str_replace('http://', 'https://', $action["download"]);
	$btn = '<button type="button" name="btnsng" id="btn'.$songsid.'" title="'.$author.' — '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$download.'" onclick="btnsong(\''.$songsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$songsid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
	if(strlen($author) + strlen($name) > 30) $fontsize = 17;
	elseif(strlen($author) + strlen($name) > 20) $fontsize = 20;
    if($action["isDisabled"]) {
		$songsid = '<div style="text-decoration:line-through;color:#8b2e2c">'.$songsid.'</div>';
		$author = '<div style="text-decoration:line-through;color:#8b2e2c">'.$author.'</div>';
		$name = '<div style="text-decoration:line-through;color:#8b2e2c">'.$name.'</div>';
      	$size = '<div style="text-decoration:line-through;color:#8b2e2c">'.$size.'</div>';
      	$time = '<div style="text-decoration:line-through;color:#8b2e2c">'.$time.'</div>';
		$btn = '<button type="button" style="display: contents;color: #ffb1ab;margin: 0;"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i class="fa-solid fa-xmark" aria-hidden="false"></i></div></button>';
	}
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
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("songIDw").': <b>'.$songIDlol.'</b></h3><h3 id="comments" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
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