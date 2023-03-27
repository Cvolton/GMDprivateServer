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
	$dailytable = "";
	if(!isset($_GET["type"])) $_GET["type"] = "";
	if(!isset($_GET["ng"])) $_GET["ng"] = "";
	$query = $db->prepare("SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC LIMIT 10 OFFSET $page");
	$query->execute([':id' => $_SESSION["accountID"]]);
	$result = $query->fetchAll();
	$x = 1;
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
	//printing data
	foreach($result as &$liked){
		$songID = $liked["songID"];
		$author = $liked["authorName"];
		$name = $liked["name"];
		$favtime = $dl->convertToDate($liked["timestamp"]);
		$favs = '<button title="'.$dl->getLocalizedString("dislikeSong").'" id="like'.$songID.'" value="1" style="display:contents;cursor:pointer" onclick="like('.$songID.')"><i id="likeicon'.$songID.'" class="fa-solid fa-heart" style="font-size: 18px;color:#ff5c5c"></i></button>'; 
		if($liked["reuploadID"] > 0) {
			$download = str_replace("http://", "https://", $liked["download"]);
			$play = '<button type="button" name="btnsng" id="btn'.$songID.'" title="'.$author.' - '.$name.'" style="display: contents;color: white;margin: 0;" onclick="btnsong(\''.$songID.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-play" aria-hidden="false"></i></div></button>
				<div name="audio" class="audio" id="'.$songID.'" style="display: none">
				<audio title="'.$author.' - '.$name.'" style="width:100%" name="song" id="song'.$songID.'" preload="metadata" controls><source src="'.$download.'" type="audio/mpeg"></audio>
				<button style="margin: 0px;font-size: 25px;padding: 14px 19px;margin-left: 5px;" type="button" class="msgupd" onclick="btnsong(0)"><i class="fa-solid fa-xmark"></i></button></div>';
		} else {
			$play = '<button type="button" title="'.$songID.'.mp3" style="display: contents;color: #ffb1ab;margin: 0;"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 0px;margin-right: -9px;"><i class="fa-solid fa-xmark" aria-hidden="false"></i></div>';
		}
		$dailytable .= '<tr>
						<th scope="row">'.$x.'</th>
						<td>'.$play.'</td>
						<td>'.$songID.'</td>
						<td>'.$author.'</td>
						<td>'.$name.'</td>
						<td>'.$favtime.'</td>
						<td>'.$favs.'</td>
					</tr>';
		$x++;
		echo "</td></tr>";
	}
	/*
		bottom row
	*/
	$query = $db->prepare("SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC");
	$query->execute([':id' => $_SESSION["accountID"]]);
	$result = $query->fetchAll();
	$pagecount = ceil(count($result) / 10);
	$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
	/* 
		printing
	*/
	$dl->printPage('<table class="table table-inverse">
		<thead>
			<tr>
				<th>#</th>
				<th></th>
				<th>'.$dl->getLocalizedString("songIDw").'</th>
				<th>'.$dl->getLocalizedString("author").'</th>
				<th>'.$dl->getLocalizedString("name").'</th>
				<th>'.$dl->getLocalizedString("time").'</th>
			</tr>
		</thead>
		<tbody>
			'.$dailytable.'
		</tbody>
	</table><script>
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
			</script>'
	.$bottomrow, true, "account");
} else $dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'account');
?>