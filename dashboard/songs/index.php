<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("songAdd"));
$dl->printFooter('../');
if(strpos($songEnabled, '1') === false) {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("pageDisabled").'</p>
		<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'reupload');
	die();
}
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) {
if($_FILES && $_FILES['filename']['error'] == UPLOAD_ERR_OK) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'songs\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload');
		die();
	} else {
		$info = new finfo(FILEINFO_MIME);
		$file_type = explode(';', $info->buffer(file_get_contents($_FILES['filename']['tmp_name'])))[0];
		$allowed = array("audio/mpeg", "audio/ogg", "audio/mp3");
		if(!in_array($file_type, $allowed)) $db_fid = -7;
		else {
			if($_FILES['filename']['size'] == 0) $db_fid = -6;
			else {
				$maxsize = $songSize * 1024 * 1024;
				if($_FILES['filename']['size'] >= $maxsize) $db_fid = -5;
				else {
					$length = 10;
					$freeID = false;
					while(!$freeID) {
						$db_fid = rand(99, 9999999);
						$checkID = $db->prepare('SELECT count(*) FROM songs WHERE ID = :id'); // If randomized ID picks existing song ID
						$checkID->execute([':id' => $db_fid]);
						if($checkID->fetchColumn() == 0) $freeID = true;
					}
					move_uploaded_file($_FILES['filename']['tmp_name'], "$db_fid.mp3");
					$duration = $gs->getAudioDuration(realpath("$db_fid.ogg"));
					$duration = empty($duration) ? 0 : $duration;
					$size = ($_FILES['filename']['size'] / 1048576);
					$size = round($size, 2);
					$hash = "";
					$types = array('.mp3', '.ogg', '.mpeg');
					$nAu = explode(' - ', str_replace($types, '', $_FILES['filename']['name']), 2);
					if(empty($nAu[1])) $nAu = explode(' — ', str_replace($types, '', $_FILES['filename']['name']), 2);
					if(!empty($nAu[1])) {
						if(!empty($_POST['name'])) $name = ExploitPatch::rucharclean($_POST['name']);
						else $name = trim(ExploitPatch::rucharclean($nAu[1]));
						if(!empty($_POST['author'])) $author = ExploitPatch::rucharclean($_POST['author']);
						else $author = trim(ExploitPatch::rucharclean($nAu[0]));
					} else {
						$name = ExploitPatch::rucharclean($_POST['name']);
						$author = ExploitPatch::rucharclean($_POST['author']);
					}
					if(empty($name)) $name = "Unnamed";
					if(empty($author)) $author = "Reupload";
					$accountID = $_SESSION["accountID"];
					$name = mb_substr($name, 0, 40);
					$author = mb_substr($author, 0, 40);
					$song = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".$db_fid.".mp3";
					$query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, duration, download, hash, reuploadTime, reuploadID) VALUES (:id, :name, '9', :author, :size, :duration, :download, :hash, :reuploadTime, :reuploadID)");
					$query->execute([':id' => $db_fid, ':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':duration' => $duration, ':hash' => $hash, ':reuploadTime' => time(), ':reuploadID' => $accountID]);
					$fontsize = 27;
					$songIDlol = '<button id="copy'.$db_fid.'" class="accbtn songidyeah" onclick="copysong('.$db_fid.')">'.$db_fid.'</button>';
					$time = $dl->convertToDate(time(), true);
					$btn = '<button type="button" name="btnsng" id="btn'.$db_fid.'" title="'.$author.' — '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$song.'" onclick="btnsong(\''.$db_fid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$db_fid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
					if(mb_strlen($author) + mb_strlen($name) > 30) $fontsize = 17;
					elseif(mb_strlen($author) + mb_strlen($name) > 20) $fontsize = 20;
					$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.$size.' MB</p>';
					$wholiked = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-heart"></i> <span style="color:#333">0</span></p>';
					$whoused = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-gamepad"></i> <span style="color:#333">0</span></p>';
					$favs = '<button title="'.$dl->getLocalizedString("likeSong").'" id="like'.$db_fid.'" onclick="like('.$db_fid.')" value="0" style="display:contents;cursor:pointer"><i id="likeicon'.$db_fid.'" class="fa-regular fa-heart" style="font-size: 25px;color:#ff5c5c"></i></button>';
					$stats = $wholiked.$songSize.$whoused;
					$songs = '<div id="profile'.$db_fid.'" style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
							<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
								<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick">'.$author.' — '.$name.$btn.'</h2>'.$favs.'
							</div>
						</div>
						<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
						<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("songIDw").': <b>'.$songIDlol.'</b></h3><h3 id="comments" class="songidyeah" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
					</div></div>';
				}
			}			
		}
		if($db_fid < 0) {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("songAddError$db_fid").'</p>
				<button type="button" onclick="a(\'songs\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'reupload');
		} else {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("songAdded").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("yourNewSong").'</p>
			<div class="songUploadDiv">'.$songs.'</div>
			<button type="button" onclick="a(\'songs\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("songAddAnotherBTN").'</button>
			</form><script>
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
			</script>', 'reupload');
		}
	}
} else {
	$dl->printSong('<div class="draganddrop" id="dad" style="opacity: 0; visibility: hidden;"><div class="form dadform" style="background: #29282c;"><h1 class="dadh1"><i class="fa-solid fa-file-import"></i>Drag-and-drop!</h1></div></div>
	<div class="form">
    <h1>'.$dl->getLocalizedString("songAdd").'</h1>
    <form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("songAddDesc").'</p>
        <div style="width:100%;text-align:center">
          <label for="upload" id="labelupload" class="btn-upload-song">
          	 <i style="margin:0;font-size: 17" class="fa-solid fa-music icon"></i> 
              <input id="upload" type="file" name="filename" size="10" accept="audio/mpeg, audio/ogg, audio/mp3">
                  <text style="font-size: 21">
                    <span id="songnamelol">
                        '.$dl->getLocalizedString("chooseFile").'
                    </span>
                  </text>
             <i style="margin:0;font-size: 17" class="fa-solid fa-music icon fa-flip-horizontal"></i>
		  </label>
		  <progress id="progress" style="display: none"></progress>
        </div>
        <div class="field"><input type="text" name="author" placeholder="'.$dl->getLocalizedString("songAddAuthorFieldPlaceholder").'"></div>
        <div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("songAddNameFieldPlaceholder").'"></div>
		'.Captcha::displayCaptcha(true).'
		<button type="button" onclick="a(\'songs\', true, false, \'POST\');" style="margin-top:5px;margin-bottom:5px" type="submit" id="submit" class="btn-song btn-block" disabled>'.$dl->getLocalizedString("reuploadBTN").'</button></form>
		<script>
			dad = document.getElementById("dad");
			document.getElementsByTagName("body")[0].ondragover = function(e) {
				dad.style.opacity = "1";
				dad.style.visibility = "initial";
				e.stopPropagation();
				e.preventDefault();
				return false;
			};
			document.getElementsByTagName("body")[0].ondragleave = function(e) {
				dad.style.opacity = "0";
				dad.style.visibility = "hidden";
				e.stopPropagation();
				e.preventDefault();
				return false;
			};
			document.getElementsByTagName("body")[0].ondrop = function(e) {
				changeSong(e);
				dad.style.opacity = "0";
				dad.style.visibility = "hidden";
				e.stopPropagation();
				e.preventDefault();
				return false;
			}
			$(".btn-upload-song input[type=file]").on("change", function(e) {changeSong(e);});
			function changeSong(fl) {
				if(typeof fl.target.files != "undefined") file = fl.target.files[0];
				else {
					document.getElementById("upload").files = fl.dataTransfer.files;
					file = fl.dataTransfer.files[0];
				}
				sn = document.getElementById("songnamelol");
				const upload = document.getElementById("labelupload");
				const btn = document.getElementById("submit");
				if(file.size > '.$songSize * 1024 * 1024 .') {
					sn.innerHTML = "'.$dl->getLocalizedString("songAddError-5").'";
					upload.classList.add("btn-size");
					btn.disabled = true;
					btn.classList.add("btn-block");
					btn.classList.remove("btn-song");
				}
				else if(file.type != "audio/mpeg" && file.type != "audio/ogg" && file.type != "audio/mp3") {
					sn.innerHTML = "'.$dl->getLocalizedString("songAddError-7").'";
					upload.classList.add("btn-size");
					btn.disabled = true;
					btn.classList.add("btn-block");
					btn.classList.remove("btn-song");
				} 
				else {
					sn.innerHTML = file.name.split(".").slice(0, -1).join(".");
					upload.classList.remove("btn-size");
					btn.removeAttribute("disabled");
					btn.classList.remove("btn-block");
					btn.classList.add("btn-song");
				}
				return false;
			}
		</script>', 'reupload');
}
} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="./login/login.php">
		<p>'.$dl->getLocalizedString("noLogin?").'</p>
		<button type="button" onclick="a(\'login/login.php\');" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
		</form>
	</div>', 'reupload');
}
?>