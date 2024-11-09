<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."config/dashboard.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("sfxAdd"));
$dl->printFooter('../');
if(!$sfxEnabled) {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("pageDisabled").'</p>
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
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
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
				$server = (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$time = time();
				$types = array('.mp3', '.ogg', '.mpeg');
				$name = !empty(mb_substr(ExploitPatch::rucharclean($_POST['name']), 0, 40)) ? mb_substr(ExploitPatch::rucharclean($_POST['name']), 0, 40) : 'Unnamed SFX';
				$author = $gs->getAccountName($_SESSION['accountID']);
				$size = $_FILES['filename']['size'];
				$query = $db->prepare("INSERT INTO sfxs (name, authorName, size, download,  reuploadTime, reuploadID) VALUES (:name, :author, :size, '', :reuploadTime, :reuploadID)");
				$query->execute([':name' => $name, ':author' => $author, ':size' => $size, ':reuploadTime' => $time, ':reuploadID' => $_SESSION['accountID']]);
				$db_fid = $db->lastInsertId();
				$token = $convertEnabled ? $gs->randomString(16) : '';
				$convert = $gs->convertSFX($_FILES['filename'], $server, $name, $token);
				$temp = $convert ? '_temp' : '';
				$song = $server.$db_fid.$temp.".ogg";
				move_uploaded_file($_FILES['filename']['tmp_name'], $db_fid.$temp.".ogg");
				$duration = $gs->getAudioDuration(realpath($db_fid.$temp.".ogg"));
				$duration = empty($duration) ? 0 : $duration * 1000;
				$query = $db->prepare('UPDATE sfxs SET download = :dl, milliseconds = :ms, token = :token, isDisabled = :isDisabled WHERE ID = :id');
				$query->execute([':dl' => $song, ':ms' => $duration, ':id' => $db_fid, ':token' => $token, ':isDisabled' => ($preenableSFXs ? 0 : 1)]);
				$songArray = $db->prepare('SELECT * FROM sfxs WHERE ID = :ID');
				$songArray->execute([':ID' => $db_fid]);
				$songArray = $songArray->fetch();
				$songs = $dl->generateSongCard($songArray, '', false);
			}
		}			
	}
		if($db_fid < 0) {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("sfxAddError$db_fid").'</p>
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