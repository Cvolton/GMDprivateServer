<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("sfxAdd"));
$dl->printFooter('../');
if(strpos($sfxEnabled, '1') === false) {
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
		exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'sfxs\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload'));
	}
	$info = new finfo(FILEINFO_MIME);
	$file_type = explode(';', $info->buffer(file_get_contents($_FILES['filename']['tmp_name'])))[0];
	$allowed = array("audio/mpeg", "audio/ogg", "audio/mp3");
	$db_fid = 1;
	if(!in_array($file_type, $allowed)) $db_fid = -7;
	else {
		if($_FILES['filename']['size'] == 0) $db_fid = -6;
		else {
			if($_FILES['filename']['size'] >= $sfxSize * 1024 * 1024) $db_fid = -5;
			else {
				$time = time();
				$length = 10;
				$types = array('.mp3', '.ogg', '.mpeg');
				$name = !empty(mb_substr(ExploitPatch::rucharclean($_POST['name']), 0, 40)) ? mb_substr(ExploitPatch::rucharclean($_POST['name']), 0, 40) : 'Unnamed SFX';
				$author = $gs->getAccountName($_SESSION['accountID']);
				$size = $_FILES['filename']['size'];
				$query = $db->prepare("INSERT INTO sfxs (name, authorName, size, download,  reuploadTime, reuploadID) VALUES (:name, :author, :size, :download, :reuploadTime, :reuploadID)");
				$query->execute([':name' => $name, ':download' => '', ':author' => $author, ':size' => $size, ':reuploadTime' => $time, ':reuploadID' => $_SESSION['accountID']]);
				$db_fid = $db->lastInsertId();
				$song = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".$db_fid.".ogg";
				move_uploaded_file($_FILES['filename']['tmp_name'], "$db_fid.ogg");
				$duration = $gs->getAudioDuration(realpath("$db_fid.ogg"));
				$duration = empty($duration) ? 0 : $duration * 1000;
				$query = $db->prepare('UPDATE sfxs SET download = :dl, milliseconds = :ms WHERE ID = :id');
				$query->execute([':dl' => $song, ':ms' => $duration, ':id' => $db_fid]);
				$fontsize = 27;
				$songIDlol = '<button id="copy'.$db_fid.'" class="accbtn songidyeah" onclick="copysong('.$db_fid.')">'.$db_fid.'</button>';
				$time = $dl->convertToDate($time, true);
				if(mb_strlen($author) + mb_strlen($name) > 30) $fontsize = 17;
				elseif(mb_strlen($author) + mb_strlen($name) > 20) $fontsize = 20;
				$btn = '<button type="button" name="btnsng" id="btn'.$db_fid.'" title="'.$author.' — '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$song.'" onclick="btnsong(\''.$db_fid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$db_fid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
				$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.round($size / 1024 / 1024, 2).' MB</p>';
				$whoused = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-gamepad"></i> <span style="color:#333">0</span></p>';
				$favs = '';
				$stats = $songSize.$whoused;
				$songs = '<div id="profile'.$db_fid.'" style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
						<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
							<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick">'.$author.' — '.$name.$btn.'</h2>
						</div></div>
						<div class="form-control" style="display: flex;width: 97.5%;height: max-content;align-items: center;">'.$stats.'</div>
						<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;">SFX ID: <b>'.$songIDlol.'</b></h3><h3 id="comments" class="songidyeah" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
					</div></div>';
			}
		}			
	}
		if($db_fid < 0) {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("sfxAddError$db_fid").'</p>
				<button type="button" onclick="a(\'sfxs\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'reupload');
		} else {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("sfxAdded").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("yourNewSFX").'</p>
			<div class="songUploadDiv">'.$songs.'</div>
			<button type="button" onclick="a(\'sfxs\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("sfxAddAnotherBTN").'</button>
			</form>', 'reupload');
		}
	} else {
	$dl->printSong('<div class="draganddrop" id="dad" style="opacity: 0; visibility: hidden;"><div class="form dadform" style="background: #29282c;"><h1 class="dadh1"><i class="fa-solid fa-file-import"></i>Drag-and-drop!</h1></div></div>
	<div class="form">
    <h1>'.$dl->getLocalizedString("sfxAdd").'</h1>
    <form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("sfxAddDesc").'</p>
        <div style="width:100%;text-align:center">
          <label for="upload" id="labelupload" class="btn-upload-song">
          	 <i style="margin:0;font-size: 17" class="fa-solid fa-music icon"></i> 
              <input id="upload" type="file" name="filename" size="10" accept="audio/mpeg, audio/ogg, audio/mp3">
                  <text style="font-size: 21">
                    <span id="songnamelol">
                        '.$dl->getLocalizedString("chooseSFX").'
                    </span>
                  </text>
             <i style="margin:0;font-size: 17" class="fa-solid fa-music icon fa-flip-horizontal"></i>
		  </label>
		  <progress id="progress" style="display: none"></progress>
        </div>
        <div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("sfxAddNameFieldPlaceholder").'"></div>
		'.Captcha::displayCaptcha(true).'
		<button type="button" onclick="a(\'sfxs\', true, false, \'POST\');" style="margin-top:5px;margin-bottom:5px" type="submit" id="submit" class="btn-song btn-block" disabled>'.$dl->getLocalizedString("reuploadBTN").'</button></form>
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
				if(file.size > '.$sfxSize * 1024 * 1024 .') {
					sn.innerHTML = "'.$dl->getLocalizedString("sfxAddError-5").'";
					upload.classList.add("btn-size");
					btn.disabled = true;
					btn.classList.add("btn-block");
					btn.classList.remove("btn-song");
				}
				else if(file.type != "audio/mpeg" && file.type != "audio/ogg" && file.type != "audio/mp3") {
					sn.innerHTML = "'.$dl->getLocalizedString("sfxAddError-7").'";
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